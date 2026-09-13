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
        Schema::table('profile_settings', function (Blueprint $table) {
            $table->text('visi_text')->nullable();
            $table->text('misi_text')->nullable();
            $table->string('visi_misi_bg')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_settings', function (Blueprint $table) {
            $table->dropColumn(['visi_text', 'misi_text', 'visi_misi_bg']);
        });
    }
};
