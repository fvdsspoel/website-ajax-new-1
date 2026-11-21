<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Back office (21 November 2026):
 * - users.role: "owner" (all + can give codes to other people) or "editor" (texts and projects).
 * - admin_invites: one-time codes an owner gives to a new person; only a hash is kept.
 * - site_texts: page texts changed in the back office, per language, on top of lang/{en,tl,ceb}/site.php.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 20)->default('editor')->after('password');
            $table->timestamp('last_login_at')->nullable()->after('role');
        });

        Schema::create('admin_invites', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role', 20)->default('editor');
            $table->string('code_hash', 64)->unique();
            $table->timestamp('expires_at');
            $table->timestamp('used_at')->nullable();
            $table->foreignId('used_by')->nullable();
            $table->foreignId('created_by')->nullable();
            $table->timestamps();
        });

        Schema::create('site_texts', function (Blueprint $table) {
            $table->id();
            $table->string('locale', 8);
            $table->string('key', 191);
            $table->text('value');
            $table->foreignId('updated_by')->nullable();
            $table->timestamps();
            $table->unique(['locale', 'key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_texts');
        Schema::dropIfExists('admin_invites');
        Schema::table('users', fn (Blueprint $t) => $t->dropColumn(['role', 'last_login_at']));
    }
};
