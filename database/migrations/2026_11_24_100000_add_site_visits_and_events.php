<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** (24 November 2026) The website counts its own visitors and what they do — read by the social app. */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('site_visits')) {
            Schema::create('site_visits', function (Blueprint $table) {
                $table->id();
                $table->date('day')->index();
                $table->char('visitor', 16);
                $table->string('path', 190);
                $table->string('source', 20);
                $table->string('referrer_host', 120)->nullable();
                $table->string('device', 10);
                $table->string('lang', 5)->nullable();
                $table->timestamp('created_at')->nullable();
                $table->index(['day', 'visitor']);
            });
        }
        if (! Schema::hasTable('site_events')) {
            Schema::create('site_events', function (Blueprint $table) {
                $table->id();
                $table->date('day')->index();
                $table->char('visitor', 16);
                $table->string('name', 40);
                $table->string('detail', 120)->nullable();
                $table->string('path', 190)->nullable();
                $table->timestamp('created_at')->nullable();
                $table->index(['day', 'name']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('site_events');
        Schema::dropIfExists('site_visits');
    }
};
