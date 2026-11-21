<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// A project now shows all its photos (gallery), where it is, and in which order.
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolio_items', function (Blueprint $table) {
            $table->string('location')->nullable()->after('title');
            $table->json('images')->nullable()->after('image_url');
            $table->unsignedSmallInteger('sort')->default(100)->after('is_featured');
        });
    }

    public function down(): void
    {
        Schema::table('portfolio_items', function (Blueprint $table) {
            $table->dropColumn(['location', 'images', 'sort']);
        });
    }
};
