{{--
    Call / Messenger / Viber / WhatsApp buttons.
    Params: $variant ('dark' default | 'light')
--}}
@php
    $cls = ($variant ?? 'dark') === 'light' ? 'channel channel--light' : 'channel';
    $tel = preg_replace('/\D+/', '', config('company.phone_primary'));
@endphp
<a class="{{ $cls }}" href="tel:{{ $tel }}">@include('partials.icon', ['name' => 'phone']) {{ __('site.common.call') }}</a>
<a class="{{ $cls }}" href="{{ config('company.messenger_url') }}" target="_blank" rel="noopener">@include('partials.icon', ['name' => 'messenger']) {{ __('site.common.messenger') }}</a>
<a class="{{ $cls }}" href="viber://chat?number=%2B{{ config('company.viber_number') }}">@include('partials.icon', ['name' => 'viber']) {{ __('site.common.viber') }}</a>
@if (!empty($withWhatsapp))
    <a class="{{ $cls }}" href="https://wa.me/{{ config('company.whatsapp_number') }}" target="_blank" rel="noopener">@include('partials.icon', ['name' => 'whatsapp']) {{ __('site.common.whatsapp') }}</a>
@endif
