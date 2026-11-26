<?php

namespace Tests\Feature;

use App\Http\Controllers\ChatController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * The website chat keeps its visitor reachable (26 November 2026): remembered 30 days in a cookie, "Continue on
 * Messenger / WhatsApp / Viber" with the chat's code, and "Notify me of the answer" (the phone's address goes to the CRM).
 */
class ChatReachableTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        config(['services.crm.webchat_url' => 'https://crm.test/api/webchat', 'services.crm.webchat_key' => 'k']);
        Http::fake([
            'crm.test/api/webchat/push-key' => Http::response(['key' => str_repeat('B', 87)]),
            'crm.test/api/webchat/send' => Http::response(['messages' => [['id' => 5, 'from' => 'visitor', 'text' => 'Hi']], 'human' => false, 'link' => 'AB12CD34EF']),
            'crm.test/api/webchat/messages*' => Http::response(['messages' => [], 'human' => false, 'link' => 'AB12CD34EF']),
            'crm.test/api/webchat/subscribe' => Http::response(['ok' => true]),
        ]);
    }

    public function test_the_chat_is_remembered_30_days_and_gives_its_code(): void
    {
        $r = $this->post('/chat/send', ['text' => 'Hi'])->assertOk()->assertJsonPath('link', 'AB12CD34EF');
        $cookie = collect($r->headers->getCookies())->first(fn ($c) => $c->getName() === ChatController::COOKIE);
        $this->assertNotNull($cookie, 'the chat code is kept in a cookie');
        $this->assertEqualsWithDelta(now()->addDays(30)->timestamp, $cookie->getExpiresTime(), 120);
        $this->assertTrue($cookie->isHttpOnly());

        // Another day, a new visit (no session): the cookie brings the same chat back.
        $token = session('chat_token');
        $this->flushSession();
        $this->withCookie(ChatController::COOKIE, $token)->get('/chat/poll')->assertOk()->assertJsonPath('link', 'AB12CD34EF');
        Http::assertSent(fn ($req) => str_contains($req->url(), 'messages') && str_contains($req->url(), 'token='.$token));
    }

    public function test_the_page_has_continue_and_notify_and_the_phone_address_goes_to_the_crm(): void
    {
        $page = $this->get('/?lang=tl')->assertOk();
        $page->assertSee('id="chat-continue"', false)->assertSee('Ituloy sa:')->assertSee('Abisuhan ako sa sagot')
            ->assertSee('data-push-key="'.str_repeat('B', 87).'"', false);

        $this->post('/chat/notify', ['endpoint' => 'https://fcm.googleapis.com/fcm/send/x', 'p256dh' => 'p', 'auth' => 'a'])->assertStatus(409);
        $this->post('/chat/send', ['text' => 'Hi'])->assertOk();
        $this->post('/chat/notify', ['endpoint' => 'https://fcm.googleapis.com/fcm/send/x', 'p256dh' => 'p', 'auth' => 'a'])->assertOk()->assertJsonPath('ok', true);
        Http::assertSent(fn ($req) => str_ends_with($req->url(), '/subscribe') && $req['endpoint'] === 'https://fcm.googleapis.com/fcm/send/x' && strlen($req['token']) === 40);
    }

    public function test_a_tap_on_an_advisor_button_is_sent_with_its_action(): void
    {
        Http::swap(new \Illuminate\Http\Client\Factory);
        Http::fake(['crm.test/api/webchat/send' => Http::response(['messages' => [['id' => 9, 'from' => 'ajax', 'name' => 'Maya', 'text' => 'Tap below', 'actions' => [['id' => 'call', 'label' => '📞 Call me back']], 'secret' => 'x']], 'human' => false, 'link' => 'AB12CD34EF'])]);
        $r = $this->post('/chat/send', ['text' => '📞 Call me back', 'action' => 'call'])->assertOk();
        $this->assertSame('call', $r->json('messages.0.actions.0.id'));
        $this->assertNull($r->json('messages.0.secret'), 'only the known fields go to the page');
        Http::assertSent(fn ($req) => str_ends_with($req->url(), '/send') && ($req['action'] ?? null) === 'call');
        $this->post('/chat/send', ['text' => 'x', 'action' => 'hack'])->assertStatus(302);
    }
}
