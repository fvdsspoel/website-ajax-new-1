<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->getCms();
    }

    public function getCms(){

        $query = DB::table('cms')->whereNull('deleted_at')->first();

        View::share('home_banner', $query->home_banner ?? '/assets/images/covers/home.webp');
        View::share('home_mobile_banner', $query->home_mobile_banner ?? '/assets/images/covers/home.webp');
        View::share('home_title', $query->home_title ?? 'Furniture, Decor, And Beyond');

        View::share('about_banner', $query->about_banner ?? '/assets/images/covers/about-us.jpg');
        View::share('about_mobile_banner', $query->about_mobile_banner ?? '/assets/images/covers/about-us.jpg');
        View::share('about_title', $query->about_title ?? 'About Us');
        
        View::share('about_detail_banner', $query->about_image ?? '/assets/images/covers/about-us.jpg');
        View::share('about_detail', $query->about_detail ?? '');

        View::share('logo', $query->logo ?? '/assets/images/logos/logo.png');
        View::share('icon', $query->icon ?? '/assets/images/icons/icon.png');

        View::share('contact_banner', $query->contact_banner ?? '/assets/images/covers/about-us.jpg');
        View::share('contact_mobile_banner', $query->contact_mobile_banner ?? '/assets/images/covers/about-us.jpg');
        View::share('contact_title', $query->contact_title ?? '');

        View::share('cms_contact_no', $query->corporate_no ?? '0945584559');
        View::share('cms_email', $query->corporate_email ?? 'info@ajaxdesign.com');
        View::share('cms_address', $query->address ?? '204-B The Atrium Of Makati City');

        View::share('cms_corporate_no', $query->contact_no ?? '0945584559');
        View::share('cms_corporate_email', $query->contact_email ?? 'info@ajaxdesign.com');
        View::share('cms_corporate_map', $query->map_link ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15446.696078817742!2d121.00400931018667!3d14.56062464334816!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c91377b0a94d%3A0xac79f2c232903875!2sCityland%20Pasong%20Tamo%20Tower!5e0!3m2!1sen!2sph!4v1700145087498!5m2!1sen!2sph');

        View::share('cms_fb', $query->fb ?? 'https://www.facebook.com/duphilco');
        View::share('cms_intagram', $query->intagram ?? 'https://www.instagram.com/duphilco');
        View::share('cms_twitter', $query->twitter ?? 'https://twitter.com/duphilco_realty');
        View::share('cms_yt', $query->yt ?? 'https://www.youtube.com/channel/UCha7Rk1531V9ZurS_JdwqtA');

        View::share('what_ajax', $query->what_ajax ?? 'Ajax Design Inc. is a premium Property template based on Bootstrap 4 . Ajax Design Inc. helped thousands of clients to find the right furniture for their needs.');
    }
}
