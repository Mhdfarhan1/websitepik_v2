<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tribute_editions', function (Blueprint $table) {
            $table->string('story_title')->nullable()->after('appreciation_quote');
            $table->longText('story_content')->nullable()->after('story_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tribute_editions', function (Blueprint $table) {
            $table->dropColumn(['story_title', 'story_content']);
        });
    }
};
