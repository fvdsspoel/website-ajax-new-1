<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
 * kept in their session, so the chat follows them from page to page.
 */
class ChatController extends Controller
{
    public function send(Request $request): JsonResponse
    {
        $data = $request->validate([
            'text' => 'required|string|max:2000',
            'after' => 'nullable|integer|min:0',
            'page' => 'nullable|string|max:255',
        ]);

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
        if (! $request->session()->has('chat_token')) {
            return response()->json(['messages' => [], 'human' => false]);
        }

        return $this->forward('get', 'messages', [
            'token' => $this->token($request),
            'after' => (int) $request->query('after', 0),
        ]);
    }

    private function token(Request $request): string
    {
        if (! $request->session()->has('chat_token')) {
            $request->session()->put('chat_token', Str::random(40));
        }

        return $request->session()->get('chat_token');
    }

    private function forward(string $method, string $path, array $payload): JsonResponse
    {
        $base = rtrim((string) config('services.crm.webchat_url'), '/');
        $key = (string) config('services.crm.webchat_key');

        if ($base === '' || $key === '') {
            return response()->json(['error' => 'chat_unavailable'], 503);
        }

        try {
            $request = Http::withHeaders(['X-Api-Key' => $key])
                ->acceptJson()
                // Maya can take a few seconds to write a reply.
                ->timeout($method === 'post' ? 45 : 10);

            $response = $method === 'post'
                ? $request->asForm()->post("{$base}/{$path}", $payload)
                : $request->get("{$base}/{$path}", $payload);

            if (! $response->successful()) {
                Log::warning('Website chat: CRM returned ' . $response->status(), ['body' => Str::limit($response->body(), 500)]);
                return response()->json(['error' => 'chat_unavailable'], 502);
            }

            return response()->json([
                'messages' => $response->json('messages', []),
                'human' => (bool) $response->json('human', false),
            ]);
        } catch (\Throwable $e) {
            Log::error('Website chat: CRM unreachable', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'chat_unavailable'], 502);
        }
    }
}
