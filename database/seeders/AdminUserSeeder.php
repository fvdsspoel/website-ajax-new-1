<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Creates the first admin account. Deliberately does NOT hardcode a
 * password — set ADMIN_SEED_EMAIL and ADMIN_SEED_PASSWORD in .env
 * before running this seeder, then remove them from .env afterward.
 * Change the password on first login regardless.
 */
class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_SEED_EMAIL');
        $password = env('ADMIN_SEED_PASSWORD');

        if (! $email || ! $password) {
            $this->command->warn('Skipped: set ADMIN_SEED_EMAIL and ADMIN_SEED_PASSWORD in .env first, then run php artisan db:seed --class=AdminUserSeeder');
            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            ['name' => 'Admin', 'password' => Hash::make($password)]
        );

        $this->command->info("Admin account ready for {$email}. Remove ADMIN_SEED_* from .env now.");
    }
}
