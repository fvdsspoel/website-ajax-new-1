<section class="section section--tight">
    <div class="wrap">
        <div class="band" data-reveal>
            <div class="band-grid">
                <div>
                    <h2>{{ __('site.upload.title') }}</h2>
                    <p>{{ __('site.upload.text') }}</p>
                    <div class="btns">
                        <a href="{{ route('design') }}#upload" class="btn btn--gold btn--lg">@include('partials.icon', ['name' => 'upload']) {{ __('site.upload.cta') }}</a>
                        <a href="{{ config('company.messenger_url') }}" target="_blank" rel="noopener" class="btn btn--ghost btn--lg" data-track="Contact">@include('partials.icon', ['name' => 'messenger']) Messenger</a>
                    </div>
                </div>
                <a href="{{ route('design') }}#upload" class="drop-visual" aria-hidden="true" tabindex="-1">
                    <div class="files"><span>@include('partials.icon', ['name' => 'file'])PDF</span><span>@include('partials.icon', ['name' => 'photo'])JPG</span><span>@include('partials.icon', ['name' => 'ruler'])PLAN</span></div>
                    <strong>{{ __('site.design.upload_btn') }}</strong>
                </a>
            </div>
        </div>
    </div>
</section>
