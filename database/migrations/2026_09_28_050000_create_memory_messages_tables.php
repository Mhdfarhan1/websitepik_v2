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
        // 1. Pengaturan Halaman Jejak Rasa & Musik Latar
        Schema::create('memory_message_settings', function (Blueprint $table) {
            $table->id();
            $table->string('badge_title')->default('BILIK NOSTALGIA & SUASANA HATI');
            $table->string('page_title')->default('Jejak Rasa — Kata yang Belum Sempat Terucap');
            $table->text('subtitle')->nullable();
            $table->string('audio_file')->nullable();
            $table->string('audio_title')->nullable()->default('Alunan Kenangan & Rindu');
            $table->string('audio_artist')->nullable()->default('PIK-R REQUEST');
            $table->boolean('is_audio_active')->default(true);
            $table->string('banner_image')->nullable();
            $table->text('quotes_narrative')->nullable();
            $table->timestamps();
        });

        // 2. Surat & Pesan Tak Terucap (The Unsaid Words)
        Schema::create('memory_messages', function (Blueprint $table) {
            $table->id();
            $table->string('sender_name')->default('Anonim');
            $table->string('sender_role')->nullable(); // e.g. "Kader Angkatan 2", "Divisi Konseling 2022"
            $table->string('recipient_name'); // e.g. "Untuk: Teman-teman Seperjuangan", "Untuk: Pembina"
            $table->string('generation')->nullable(); // e.g. "Generasi 2 (2022/2023)"
            $table->string('category')->default('terima_kasih'); // terima_kasih, maaf, rindu, pesan_adik, catatan_pembina
            $table->longText('message');
            $table->string('paper_theme')->default('warm'); // warm, vintage, night, rose, navy
            $table->integer('hug_count')->default(0); // Tombol reaksi peluk hangat
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
        });

        // 3. Galeri Momen Naratif "Ruang yang Kini Sunyi"
        Schema::create('silent_moments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('period')->nullable();
            $table->string('photo')->nullable();
            $table->text('narrative');
            $table->integer('order_index')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 4. Surat Pamit Purna Tugas Demisioner
        Schema::create('farewell_letters', function (Blueprint $table) {
            $table->id();
            $table->string('generation_title');
            $table->string('period');
            $table->string('author_representative')->nullable();
            $table->string('cover_photo')->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('letter_content');
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
        Schema::dropIfExists('farewell_letters');
        Schema::dropIfExists('silent_moments');
        Schema::dropIfExists('memory_messages');
        Schema::dropIfExists('memory_message_settings');
    }
};
