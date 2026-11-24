<?php

namespace Tests\Feature;

use App\Support\SiteStats;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * (Sir Ferdinand, 24 November 2026: "it should count itself visitors also and shown on our social app") The website
 * counts its visitors without cookies or outside services: where they came from, phone or computer, which pages, how far
 * in the design page, and what they sent. Robots, the back office and the team are not counted.
 */
class VisitorCounterTest extends TestCase
{
    use RefreshDatabase;

    protected const PHONE = 'Mozilla/5.0 (Linux; Android 14; SM-A155F) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0 Mobile Safari/537.36';
    protected const PC = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0 Safari/537.36';

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_pages_are_counted_with_where_the_visitor_came_from(): void
    {
        $this->withHeaders(['User-Agent' => self::PHONE, 'Referer' => 'https://m.facebook.com/'])->get('/?lang=en')->assertOk();
        $this->withHeaders(['User-Agent' => self::PHONE, 'Referer' => 'https://www.ajaxtradingcorp.com/'])->get('/what-we-make')->assertOk();
        $this->withHeaders(['User-Agent' => self::PC, 'Referer' => 'https://www.google.com/'])->get('/our-factory')->assertOk();
        $this->withHeaders(['User-Agent' => self::PC])->get('/projects?gclid=abc123')->assertOk();
        $this->withServerVariables(['REMOTE_ADDR' => '10.0.0.9'])->withHeaders(['User-Agent' => self::PC, 'Referer' => ''])->get('/showroom')->assertOk();

        // Not counted: a robot, the link preview of Facebook, a page that is not found, the back office.
        $this->withHeaders(['User-Agent' => 'Googlebot/2.1 (+http://www.google.com/bot.html)'])->get('/')->assertOk();
        $this->withHeaders(['User-Agent' => 'facebookexternalhit/1.1'])->get('/')->assertOk();
        $this->withHeaders(['User-Agent' => self::PC])->get('/no-such-page')->assertNotFound();
        $this->withHeaders(['User-Agent' => self::PC])->get('/admin/login')->assertOk();

        $rows = DB::table('site_visits')->orderBy('id')->get();
        $this->assertSame(['/', '/what-we-make', '/our-factory', '/projects', '/showroom'], $rows->pluck('path')->all());
        $this->assertSame(['facebook', 'inside', 'google', 'google_ads', 'direct'], $rows->pluck('source')->all());
        $this->assertSame(['phone', 'phone', 'computer', 'computer', 'computer'], $rows->pluck('device')->all());
        $this->assertSame(SiteStats::today(), (string) $rows[0]->day);
        // A visitor is a code of the day — the same phone twice is one visitor; no address is kept.
        $this->assertSame($rows[0]->visitor, $rows[1]->visitor);
        $this->assertSame(16, strlen($rows[0]->visitor));
        $this->assertNotSame($rows[2]->visitor, $rows[4]->visitor);
        $this->assertFalse(collect((array) $rows[0])->contains(fn ($v) => is_string($v) && str_contains($v, '127.0.0.1')));
    }

    public function test_design_steps_taps_and_requests_are_counted(): void
    {
        Http::fake(['crm.test/*' => Http::response(['ok' => true, 'id' => 1])]);
        $phone = ['User-Agent' => self::PHONE, 'Referer' => 'https://www.ajaxtradingcorp.com/design-your-space'];

        $this->withHeaders($phone)->post('/t', ['e' => 'design_step', 'd' => '1'])->assertNoContent();
        $this->withHeaders($phone)->post('/t', ['e' => 'design_step', 'd' => '2'])->assertNoContent();
        $this->withHeaders($phone)->post('/t', ['e' => 'call_click', 'd' => '/design-your-space'])->assertNoContent();
        // Something else is not kept.
        $this->withHeaders($phone)->post('/t', ['e' => 'drop table', 'd' => 'x'])->assertNoContent();

        $this->withHeaders($phone + ['Accept' => 'application/json'])->post('/design-your-space', [
            'name' => 'Ana Cruz', 'mobile' => '09171234567', 'room' => 'kitchen', 'next' => 'call',
        ])->assertOk()->assertJson(['success' => true]);

        $events = DB::table('site_events')->orderBy('id')->get();
        $this->assertSame(['design_step', 'design_step', 'call_click', 'design_request'], $events->pluck('name')->all());
        $this->assertSame(['1', '2', '/design-your-space', 'kitchen'], $events->pluck('detail')->all());
        $this->assertSame('/design-your-space', $events[0]->path);
    }
}
