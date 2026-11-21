<?php

namespace Tests\Feature;

use App\Models\AdminInvite;
use App\Models\SiteText;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class BackOfficeTest extends TestCase
{
    use RefreshDatabase;

    private function owner(): User
    {
        return User::create(['name' => 'Ferdinand', 'email' => 'f@ajax.test', 'password' => 'a-long-password-1', 'role' => 'owner']);
    }

    public function test_back_office_needs_a_login(): void
    {
        $this->get('/admin/texts')->assertRedirect('/admin/login');
        $this->get('/admin/team')->assertRedirect('/admin/login');
        $this->get('/admin/login')->assertOk()->assertSee('Make your login with the code');
    }

    public function test_an_owner_gives_a_code_and_the_new_person_makes_their_own_login(): void
    {
        $owner = $this->owner();
        $res = $this->actingAs($owner)->post('/admin/team/invite', ['name' => 'Marketing', 'role' => 'editor'])->assertRedirect('/admin/team');
        $code = session('new_code')['code'];
        $this->assertMatchesRegularExpression('/^AJX-[A-Z2-9]{4}-[A-Z2-9]{4}$/', $code);
        $this->assertDatabaseMissing('admin_invites', ['code_hash' => $code]);              // only a hash is kept
        $this->get('/admin/team')->assertSee('Marketing');
        Auth::logout();

        $this->post('/admin/join', ['code' => strtolower(str_replace('-', ' ', $code)), 'name' => 'Ana', 'email' => 'ana@ajax.test',
            'password' => 'my-own-secret-9', 'password_confirmation' => 'my-own-secret-9'])->assertRedirect('/admin/texts');
        $ana = User::where('email', 'ana@ajax.test')->first();
        $this->assertSame('editor', $ana->role);
        $this->assertAuthenticatedAs($ana);

        // the code works only once
        Auth::logout();
        $this->post('/admin/join', ['code' => $code, 'name' => 'X', 'email' => 'x@ajax.test',
            'password' => 'another-pass-1', 'password_confirmation' => 'another-pass-1'])->assertSessionHasErrors('code');

        // an editor cannot see the team page or give codes
        $this->actingAs($ana)->get('/admin/team')->assertForbidden();
        $this->actingAs($ana)->post('/admin/team/invite', ['name' => 'Y', 'role' => 'owner'])->assertForbidden();
    }

    public function test_an_old_code_does_not_work_and_the_last_owner_cannot_be_removed(): void
    {
        $owner = $this->owner();
        [$invite, $code] = AdminInvite::make('Late', 'editor');
        $invite->update(['expires_at' => now()->subMinute()]);
        $this->post('/admin/join', ['code' => $code, 'name' => 'Late', 'email' => 'l@ajax.test',
            'password' => 'late-pass-123', 'password_confirmation' => 'late-pass-123'])->assertSessionHasErrors('code');

        $this->actingAs($owner)->delete('/admin/team/user/'.$owner->id)->assertSessionHasErrors('user');
        $this->assertDatabaseHas('users', ['id' => $owner->id]);
    }

    public function test_a_text_changed_in_the_back_office_shows_on_the_website_and_can_be_reset(): void
    {
        $owner = $this->owner();
        $this->actingAs($owner)->get('/admin/texts?section=hero')->assertOk()->assertSee('Tagalog')->assertSee('hero.lead');

        $en = require lang_path('en/site.php');
        $this->actingAs($owner)->post('/admin/texts', ['section' => 'hero', 't' => [
            'en' => ['hero__lead' => 'Factory-direct kitchens <b>for every home</b>.'],
            'tl' => ['hero__lead' => 'Kusina mula mismo sa pabrika.'],
        ]])->assertRedirect('/admin/texts?section=hero');

        $this->assertSame('Factory-direct kitchens for every home.', SiteText::where(['locale' => 'en', 'key' => 'hero.lead'])->value('value'));   // no HTML kept
        Auth::logout();
        $this->get('/?lang=en')->assertOk()->assertSee('Factory-direct kitchens for every home.')->assertSee('We build');
        $this->get('/?lang=tl')->assertOk()->assertSee('Kusina mula mismo sa pabrika.');
        $this->get('/?lang=ceb')->assertOk()->assertSee('Naghimo mi og');                 // untouched language keeps its own text

        // saving the original text again (or empty) removes the change
        $this->actingAs($owner)->post('/admin/texts', ['section' => 'hero', 't' => ['en' => ['hero__lead' => $en['hero']['lead']], 'tl' => ['hero__lead' => '']]]);
        $this->assertSame(0, SiteText::count());
        Auth::logout();
        $this->get('/?lang=en')->assertSee(e($en['hero']['lead']), false);
    }

    public function test_unknown_keys_are_ignored(): void
    {
        $this->actingAs($this->owner())->post('/admin/texts', ['section' => 'hero', 't' => ['en' => ['quote__title' => 'Hacked', 'nope__x' => 'y']]]);
        $this->assertSame(0, SiteText::count());
    }

    public function test_staff_can_upload_a_real_photo_for_a_design_style_and_the_website_shows_it(): void
    {
        $file = \App\Support\DesignPictures::dir().'/wardrobe-dark.jpg';
        @unlink($file);
        $this->get('/admin/design-pictures')->assertRedirect('/admin/login');

        $owner = $this->owner();
        $this->actingAs($owner)->get('/admin/design-pictures')->assertOk()->assertSee('Wardrobe &amp; bedroom', false)->assertSee('Drawing');

        $img = \Illuminate\Http\UploadedFile::fake()->image('dark-wardrobe.jpg', 1600, 900);
        $this->actingAs($owner)->post('/admin/design-pictures', ['set' => 'wardrobe', 'style' => 'dark', 'image' => $img])->assertRedirect();
        $this->assertFileExists($file);
        [$w, $h] = getimagesize($file);
        $this->assertSame([1200, 900], [$w, $h]); // cropped to the 4:3 tile, max 1200 wide

        $this->get('/design-your-space')->assertOk()->assertSee('uploads/design/wardrobe-dark.jpg', false);

        $this->actingAs($owner)->delete('/admin/design-pictures', ['set' => 'wardrobe', 'style' => 'dark'])->assertRedirect();
        $this->assertFileDoesNotExist($file);

        // Only real room types / styles are accepted.
        $this->actingAs($owner)->post('/admin/design-pictures', ['set' => '../../x', 'style' => 'dark', 'image' => $img])->assertSessionHasErrors('set');
    }
}
