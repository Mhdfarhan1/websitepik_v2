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
        // Settings for Kotak Waktu PIK-R
        Schema::create('time_capsule_settings', function (Blueprint $table) {
            $table->id();
            $table->string('badge_title')->default('RUANG ARSIP DIGITAL MASA DEPAN');
            $table->string('page_title')->default('🔐 Kotak Waktu PIK-R');
            $table->text('subtitle')->nullable();
            $table->string('audio_file')->nullable();
            $table->string('audio_title')->nullable()->default('Melodi Penjaga Waktu');
            $table->string('audio_artist')->nullable()->default('PIK-R REQUEST');
            $table->boolean('is_audio_active')->default(true);
            $table->string('banner_image')->nullable();
            $table->timestamps();
        });

        // Time Capsules (Kotak Waktu per generasi / periode)
        Schema::create('time_capsules', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g. "TIME CAPSULE 2026"
            $table->string('slug')->unique();
            $table->string('creator_generation'); // e.g. "Generasi PIK-R REQUEST 2025–2026"
            $table->date('created_date'); // e.g. "2026-09-26"
            $table->dateTime('unlock_date'); // e.g. "2030-09-26 00:00:00"
            $table->text('seal_message')->nullable(); // Pesan pengantar segel waktu
            $table->string('cover_image')->nullable();
            $table->string('theme_color')->default('amber'); // amber, sky, emerald, purple, rose
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });

        // Items inside a Time Capsule (Pesan, Cerita, Foto, Video)
        Schema::create('time_capsule_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('time_capsule_id')->constrained('time_capsules')->onDelete('cascade');
            $table->string('type')->default('letter'); // letter, story, photo, video
            $table->string('title');
            $table->string('author_name')->nullable(); // e.g. "Ahmad Rinaldi", "Divisi Konseling Sebaya"
            $table->string('author_role')->nullable(); // e.g. "Ketua Umum", "Pendidik Sebaya"
            $table->longText('content')->nullable(); // Surat pesan atau narasi cerita
            $table->string('media_path')->nullable(); // Foto atau video lokal
            $table->string('external_url')->nullable(); // YouTube / Google Drive URL
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
        Schema::dropIfExists('time_capsule_items');
        Schema::dropIfExists('time_capsules');
        Schema::dropIfExists('time_capsule_settings');
    }
};
