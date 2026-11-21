<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/** A one-time code an owner gives to a new person for the website back office. Only the hash is stored. */
class AdminInvite extends Model
{
    public const DAYS_VALID = 3;

    protected $fillable = ['name', 'role', 'code_hash', 'expires_at', 'used_at', 'used_by', 'created_by'];

    protected $casts = ['expires_at' => 'datetime', 'used_at' => 'datetime'];

    /** Makes the invite and returns [invite, plain code]. The plain code is shown once and never stored. */
    public static function make(string $name, string $role, ?int $by = null): array
    {
        $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';           // no 0/O, 1/I: easy to read out on the phone
        $raw = '';
        for ($i = 0; $i < 8; $i++) {
            $raw .= $alphabet[random_int(0, strlen($alphabet) - 1)];
        }
        $code = 'AJX-'.substr($raw, 0, 4).'-'.substr($raw, 4);

        $invite = static::create([
            'name' => $name,
            'role' => in_array($role, User::ROLES, true) ? $role : 'editor',
            'code_hash' => static::hash($code),
            'expires_at' => now()->addDays(self::DAYS_VALID),
            'created_by' => $by,
        ]);

        return [$invite, $code];
    }

    public static function hash(string $code): string
    {
        $clean = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $code));
        if (! str_starts_with($clean, 'AJX')) {
            $clean = 'AJX'.$clean;
        }

        return hash_hmac('sha256', $clean, (string) config('app.key'));
    }

    public static function findOpen(string $code): ?self
    {
        return static::where('code_hash', static::hash($code))
            ->whereNull('used_at')->where('expires_at', '>', now())->first();
    }

    public function isOpen(): bool
    {
        return $this->used_at === null && $this->expires_at->isFuture();
    }
}
