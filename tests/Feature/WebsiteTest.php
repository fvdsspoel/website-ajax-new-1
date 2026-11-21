<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request as HttpRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class WebsiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_every_page_opens_in_english_tagalog_and_bisaya(): void
    {
        foreach (['en' => 'We build', 'tl' => 'Gumagawa kami ng', 'ceb' => 'Naghimo mi og'] as $lang => $hero) {
            $this->get('/?lang='.$lang)->assertOk()->assertSee($hero)->assertSee('lang="'.$lang.'"', false);
            foreach (['/what-we-make', '/projects', '/our-colours', '/our-factory', '/about-us', '/showroom', '/design-your-space', '/contact'] as $url) {
                $this->get($url)->assertOk();
            }
        }
    }

    public function test_the_homepage_shows_real_projects_factory_boards_and_socials(): void
    {
        $this->get('/?lang=en')->assertOk()
            ->assertSee('Two-tone Kitchen Set for a Property Developer')
            ->assertDontSee('DDC')
            ->assertSee('images/projects/02/01-sm.webp', false)
            ->assertSee('Stone cutting machine')
            ->assertSee('Marine plywood, 11 layers')
            ->assertSee('Price on request')
            ->assertSee('facebook.com/plugins/page.php', false)
            ->assertSee('https://www.instagram.com/ajaxtradingcorporation_2024/', false)
            ->assertSee('https://m.me/61559238760421', false)
            ->assertDontSee('₱');                                          // no prices on the site
    }

    public function test_the_design_selector_sends_the_lead_with_its_files_to_the_crm(): void
    {
        Http::fake(['crm.test/*' => Http::response(['ok' => true, 'id' => 1])]);

        $this->post('/design-your-space', [
            'name' => 'Ana Cruz', 'mobile' => '09171234567', 'city' => 'Sta. Rosa, Laguna',
            'room' => 'kitchen', 'layout' => 'l_shape', 'size_m' => '4.2', 'style' => 'handleless',
            'finish' => 'melamine', 'colour' => 'MP.Y2146', 'top' => 'sintered', 'next' => 'measure',
            'visit_date' => now()->addDays(3)->toDateString(), 'visit_time' => 'morning', 'prefer' => 'viber', 'when' => 'asap',
            'files' => [UploadedFile::fake()->image('plan.jpg', 800, 600)],
        ], ['Accept' => 'application/json'])->assertOk()->assertJson(['success' => true]);

        // only colours we really have (or "advise me") are accepted
        $this->post('/design-your-space', ['name' => 'X', 'mobile' => '0917', 'colour' => 'wooddark'], ['Accept' => 'application/json'])->assertStatus(422);

        Http::assertSent(function (HttpRequest $r) {
            $body = $r->body();
            return $r->url() === 'https://crm.test/api/inquiry'
                && $r->isMultipart()
                && str_contains($body, 'Ana Cruz')
                && str_contains($body, 'Layout: L-shape')
                && str_contains($body, 'Colour: Cedar — board colour, wood (MP.Y2146)')
                && str_contains($body, 'Next step: Measure at my place')
                && str_contains($body, 'name="design_config[source]"')
                && str_contains($body, 'website_design_selector')
                && str_contains($body, 'filename="plan.jpg"')
                && str_contains($body, 'name="channel"');
        });
    }

    public function test_a_lead_the_crm_does_not_take_is_kept_with_its_files(): void
    {
        Storage::fake('local');
        Http::fake(['crm.test/*' => Http::response('down', 503)]);

        $this->post('/design-your-space', [
            'name' => 'Ben Reyes', 'mobile' => '09180000000',
            'files' => [UploadedFile::fake()->create('floorplan.pdf', 120, 'application/pdf')],
        ], ['Accept' => 'application/json'])->assertStatus(502)->assertJson(['success' => false]);

        $dirs = Storage::disk('local')->directories('failed-leads');
        $this->assertCount(1, $dirs);
        $this->assertStringContainsString('Ben Reyes', Storage::disk('local')->get($dirs[0].'/lead.json'));
        $this->assertCount(2, Storage::disk('local')->files($dirs[0]));      // lead.json + the PDF
    }

    public function test_the_selector_refuses_wrong_files_and_missing_contact(): void
    {
        Http::fake();
        $this->post('/design-your-space', ['name' => 'X'], ['Accept' => 'application/json'])->assertStatus(422);
        $this->post('/design-your-space', ['name' => 'X', 'mobile' => '0917', 'files' => [UploadedFile::fake()->create('virus.exe', 10)]], ['Accept' => 'application/json'])->assertStatus(422);
        Http::assertNothingSent();
    }

    public function test_a_robot_filling_the_hidden_field_sends_nothing(): void
    {
        Http::fake();
        $this->post('/design-your-space', ['name' => 'Bot', 'mobile' => '1', 'website' => 'spam.example'], ['Accept' => 'application/json'])->assertOk();
        Http::assertNothingSent();
    }

    public function test_the_contact_form_goes_to_the_crm_in_english_whatever_the_language(): void
    {
        Http::fake(['crm.test/*' => Http::response(['ok' => true])]);

        $this->withSession(['locale' => 'ceb'])->post('/contact', [
            'name' => 'Carlo', 'contact' => '09190000000', 'interest' => 'boards', 'message' => 'Pila ang marine boards?',
        ])->assertRedirect()->assertSessionHas('success');

        Http::assertSent(fn (HttpRequest $r) => str_contains($r->body(), 'Interest: Boards (marine plywood)') && str_contains($r->body(), 'Website language: ceb'));
    }

    public function test_the_google_ads_tag_is_on_every_page_and_counts_a_quote_only_after_it_is_sent(): void
    {
        config(['company.google_ads_id' => 'AW-18588478601', 'company.google_ads_lead_label' => 'Bst8CNyq8bwdEInZ1p9F']);

        $this->get('/')->assertOk()
            ->assertSee('googletagmanager.com/gtag/js?id=AW-18588478601', false)
            ->assertSee('AW-18588478601\/Bst8CNyq8bwdEInZ1p9F', false);

        // The form page itself must not count a lead…
        $this->get('/contact')->assertOk()->assertDontSee('ajaxLead && ajaxLead()', false);
        // …only the page shown after a successful send.
        $this->withSession(['success' => true])->get('/contact')->assertOk()->assertSee('ajaxLead && ajaxLead()', false);

        // Switched off when the ID is empty.
        config(['company.google_ads_id' => '']);
        $this->get('/')->assertOk()->assertDontSee('AW-18588478601', false);
    }

    public function test_the_colours_page_shows_the_erp_colours_without_prices(): void
    {
        $this->get('/our-colours?lang=en')->assertOk()
            ->assertSee('Real White')->assertSee('MP.60.MATT.FSI')        // board colour, with the ERP code
            ->assertSee('Board colours · plywood &amp; particle board', false)
            ->assertDontSee('Plywood · two colours')                       // no separate plywood colours
            ->assertSee('Golden Teak')->assertSee('HPL.9066')             // HPL
            ->assertSee('Every HPL colour comes with its own matching edge band.')
            ->assertDontSee('₱')->assertDontSee('Cost');
        $this->assertCount(33, config('colours.board'));
        $this->assertNull(config('colours.plywood'));
        $this->assertCount(26, config('colours.hpl'));
    }

    public function test_google_gets_a_title_and_description_per_page_and_language_and_a_sitemap(): void
    {
        $this->get('/our-factory?lang=en')->assertSee('<title>Furniture Factory in San Pablo, Laguna — 17 Machines | Ajax</title>', false)
            ->assertSee('<link rel="canonical" href="'.url('/our-factory').'">', false);
        $this->get('/our-factory?lang=tl')->assertSee('<link rel="canonical" href="'.url('/our-factory').'?lang=tl">', false)
            ->assertSee('Furniture Factory sa San Pablo');
        $this->get('/?lang=en')->assertSee('"@type":"FAQPage"', false)->assertSee('How much does a modular kitchen cost?');
        $this->get('/sitemap.xml')->assertOk()->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<loc>'.url('/projects').'?lang=ceb</loc>', false);
        $titles = [];
        foreach (['/', '/what-we-make', '/projects', '/our-colours', '/our-factory', '/about-us', '/showroom', '/design-your-space', '/contact'] as $u) {
            preg_match('#<title>(.*?)</title>#', $this->get($u.'?lang=en')->getContent(), $m);
            $titles[] = $m[1];
        }
        $this->assertCount(9, array_unique($titles));
    }

    public function test_old_addresses_still_work(): void
    {
        $this->get('/portfolios')->assertRedirect('/projects');
        $this->get('/machines')->assertRedirect('/our-factory');
        $this->get('/contact-us')->assertRedirect('/contact');
        $this->get('/build-your-own')->assertRedirect('/design-your-space');
        $this->get('/show-rooms')->assertRedirect('/showroom');
        $this->get('/highlights/view/16/Ajax%20Trading%20Flutted%20Pannel')->assertRedirect('/projects');
        $this->get('/portfolios/view/3/Kitchen%20Set')->assertRedirect('/projects');
        $this->get('/products/list/2/abc')->assertRedirect('/what-we-make');
        $this->get('/assets/images/catalog/catalog.pdf')->assertRedirect('/what-we-make');
        $this->get('/login')->assertRedirect('/admin/login');
    }

    public function test_every_language_file_has_the_same_texts(): void
    {
        $flat = function (array $a, string $p = '') use (&$flat): array {
            $out = [];
            foreach ($a as $k => $v) {
                is_array($v) && ! array_is_list($v) ? $out += $flat($v, $p.$k.'.') : $out[$p.$k] = true;
            }
            return $out;
        };
        $en = array_keys($flat(require lang_path('en/site.php')));
        foreach (['tl', 'ceb'] as $l) {
            $this->assertSame([], array_values(array_diff($en, array_keys($flat(require lang_path($l.'/site.php'))))), "Missing in $l");
        }
    }

    public function test_the_language_buttons_work_even_when_the_page_had_lang_in_its_address(): void
    {
        $this->get('/projects?lang=en&type=kitchen');
        $this->from(url('/projects?lang=en&type=kitchen'))->get('/lang/tl')
            ->assertRedirect('/projects?type=kitchen');
        $this->get('/projects?type=kitchen')->assertSee('lang="tl"', false);
        $this->from('https://evil.example/x')->get('/lang/ceb')->assertRedirect(route('home'));
        $this->get('/')->assertSee('lang="ceb"', false);
    }
}
