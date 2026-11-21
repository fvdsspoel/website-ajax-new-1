<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// First logins for the website back office (21 November 2026). Prints a one-time code (valid 3 days).
// The person opens /admin/join, types the code and chooses their OWN e-mail and password.
// Example: php artisan website:invite "Ferdinand" --role=owner
Artisan::command('website:invite {name} {--role=editor}', function () {
    $role = in_array($this->option('role'), App\Models\User::ROLES, true) ? $this->option('role') : 'editor';
    [$invite, $code] = App\Models\AdminInvite::make($this->argument('name'), $role);
    $this->line('');
    $this->line('  Code for '.$invite->name.' ('.$role.'), valid until '.$invite->expires_at->format('d M Y H:i').':');
    $this->line('');
    $this->info('      '.$code);
    $this->line('');
    $this->line('  Open '.rtrim(config('app.url'), '/').'/admin/join and type this code. It works once.');
})->purpose('Make a one-time code for a new back-office login');
