<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * The website's live chat window ("Chat with us").
 *
 * The visitor's browser only ever talks to THIS site. This controller
 * forwards messages server-to-server to the CRM (crm.ajaxtradingcorp.com
 * /api/webchat/*), where Maya — the same AI sales agent that answers
 * Facebook and WhatsApp — replies, and staff can take over from the
 * normal Inquiries screen. The visitor is identified by a random token
 * kept in their session, so the chat follows them from page to page —
 * and (26 November 2026) in a cookie for 30 days, so a visitor who comes
 * back sees the team's late reply ("1 new reply" on the chat button).
 */
class ChatController extends Controller
{
    public const COOKIE = 'ajax_chat';

    public const DAYS = 30;

    /** The visitor's chat token (session, else the 30-day cookie), or null when no chat was started. */
    public static function tokenOf(Request $request): ?string
    {
        $token = $request->session()->get('chat_token') ?: $request->cookie(self::COOKIE);

        return is_string($token) && preg_match('/^[A-Za-z0-9]{40}$/', $token) ? $token : null;
    }

    public function send(Request $request): JsonResponse
    {
        $data = $request->validate([
            'text' => 'required|string|max:2000',
            'after' => 'nullable|integer|min:0',
            'page' => 'nullable|string|max:255',
        ]);

        // The first message of a visitor: a chat started (counted for the social app's Website page).
        if (self::tokenOf($request) === null) {
            \App\Support\SiteStats::event($request, 'chat_started');
        }

        return $this->forward('post', 'send', [
            'token' => $this->token($request),
            'text' => $data['text'],
            'after' => $data['after'] ?? 0,
            'page' => $data['page'] ?? null,
            'locale' => app()->getLocale(),
        ]);
    }

    public function poll(Request $request): JsonResponse
    {
        // No chat started yet in this session: nothing to fetch.
        if (self::tokenOf($request) === null) {
            return response()->json(['messages' => [], 'human' => false]);
        }

        return $this->forward('get', 'messages', [
            'token' => $this->token($request),
            'after' => (int) $request->query('after', 0),
        ]);
    }

    /** "Notify me of the answer" (26 November 2026): the visitor's phone or computer, sent on to the CRM. */
    public function notify(Request $request): JsonResponse
    {
        $data = $request->validate([
            'endpoint' => 'required|url|max:1000',
            'p256dh' => 'required|string|max:255',
            'auth' => 'required|string|max:255',
        ]);
        if (self::tokenOf($request) === null) {
            return response()->json(['ok' => false], 409);
        }

        return $this->forward('post', 'subscribe', ['token' => $this->token($request)] + $data, true);
    }

    /** The CRM's public key for notifications (kept a day; none: the "Notify me" button is not shown). */
    public static function pushKey(): ?string
    {
        $base = rtrim((string) config('services.crm.webchat_url'), '/');
        $key = (string) config('services.crm.webchat_key');
        if ($base === '' || $key === '') {
            return null;
        }
        $hit = \Illuminate\Support\Facades\Cache::get('chat_push_key');
        if (is_array($hit)) {
            return $hit['v'];
        }
        try {
            $r = Http::withHeaders(['X-Api-Key' => $key])->acceptJson()->connectTimeout(2)->timeout(3)->get("{$base}/push-key");
            $value = $r->successful() && is_string($r->json('key')) && preg_match('/^[A-Za-z0-9_-]{80,100}$/', $r->json('key')) ? $r->json('key') : null;
        } catch (\Throwable) {
            $value = null;
        }
        \Illuminate\Support\Facades\Cache::put('chat_push_key', ['v' => $value], $value ? 86400 : 600);

        return $value;
    }

    private function token(Request $request): string
    {
        $token = self::tokenOf($request) ?? Str::random(40);
        $request->session()->put('chat_token', $token);
        // Kept 30 days from the last message or look (only once a chat is started; it holds nothing but this random code).
        Cookie::queue(Cookie::make(self::COOKIE, $token, 60 * 24 * self::DAYS, '/', null, $request->isSecure(), true, false, 'Lax'));

        return $token;
    }

    private function forward(string $method, string $path, array $payload, bool $plain = false): JsonResponse
    {
        $base = rtrim((string) config('services.crm.webchat_url'), '/');
        $key = (string) config('services.crm.webchat_key');

        if ($base === '' || $key === '') {
            return response()->json(['error' => 'chat_unavailable'], 503);
        }

        try {
            $request = Http::withHeaders(['X-Api-Key' => $key])
                ->acceptJson()
                // Maya can take a few seconds to write a reply (and the CRM
                // tries the AI twice if the first try fails).
                ->timeout($method === 'post' ? 60 : 10);

            $response = $method === 'post'
                ? $request->asForm()->post("{$base}/{$path}", $payload)
                : $request->get("{$base}/{$path}", $payload);

            if (! $response->successful()) {
                Log::warning('Website chat: CRM returned ' . $response->status(), ['body' => Str::limit($response->body(), 500)]);
                return response()->json(['error' => 'chat_unavailable'], 502);
            }
            if ($plain) {
                return response()->json(['ok' => (bool) $response->json('ok', false)]);
            }

            return response()->json([
                'messages' => $response->json('messages', []),
                'human' => (bool) $response->json('human', false),
                // (26 November 2026) the chat's code for "Continue on Messenger / WhatsApp".
                'link' => is_string($response->json('link')) && preg_match('/^[A-Z0-9]{10}$/', $response->json('link')) ? $response->json('link') : null,
            ]);
        } catch (\Throwable $e) {
            Log::error('Website chat: CRM unreachable', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'chat_unavailable'], 502);
        }
    }
}
