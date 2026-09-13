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
        Schema::table('complete_profile_settings', function (Blueprint $table) {
            $table->string('hero_bg')->nullable()->after('hero_desc');
            $table->string('hero_tag')->nullable()->default('Complete Identity')->after('hero_bg');
            $table->string('hero_bg_color')->nullable()->default('#1e3a5f')->after('hero_tag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complete_profile_settings', function (Blueprint $table) {
            $table->dropColumn(['hero_bg', 'hero_tag', 'hero_bg_color']);
        });
    }
};
