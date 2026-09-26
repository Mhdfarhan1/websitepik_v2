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
        Schema::create('leader_settings', function (Blueprint $table) {
            $table->id();
            $table->string('badge_title')->default('ESTAFET KEPEMIMPINAN & DEDIKASI');
            $table->string('page_title')->default('Jejak Nakhoda PIK-R REQUEST');
            $table->string('subtitle')->nullable()->default('Rekam jejak, dedikasi, serta torehan sejarah para Ketua yang telah menakhodai perjalanan PIK-R REQUEST dari masa ke masa.');
            $table->string('audio_file')->nullable();
            $table->string('audio_title')->nullable()->default('Lagu Kenangan Pemimpin');
            $table->string('audio_artist')->nullable()->default('PIK-R REQUEST');
            $table->boolean('is_audio_active')->default(true);
            $table->string('banner_image')->nullable();
            $table->timestamps();
        });

        Schema::create('leader_histories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('period'); // e.g. "2023 — 2024"
            $table->string('generation')->nullable(); // e.g. "Generasi Ke-1", "Generasi II"
            $table->string('title_badge')->default('Ketua Demisioner'); // e.g. "Ketua Perintis", "Ketua Ke-2", "Ketua Petahana"
            $table->string('status')->default('demisioner'); // 'demisioner' or 'aktif'
            $table->string('photo')->nullable();
            $table->text('quote')->nullable(); // Motto / Kutipan singkat kepemimpinan
            $table->longText('story')->nullable(); // Cerita & Perjalanan Kepemimpinan
            $table->longText('experience')->nullable(); // Pengalaman & Tantangan yang Dilalui
            $table->longText('hope')->nullable(); // Harapan & Pesan untuk Masa Depan PIK-R
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->integer('order_index')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leader_histories');
        Schema::dropIfExists('leader_settings');
    }
};
