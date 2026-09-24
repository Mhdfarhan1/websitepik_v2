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
        Schema::create('tribute_editions', function (Blueprint $table) {
            $table->id();
            $table->string('badge_title')->default('PANGGUNG KEHORMATAN & REKAM JEJAK');
            $table->string('title')->default('Proud Moments Duta GenRe');
            $table->string('period')->default('2024 — 2025'); // e.g. 2024 — 2025
            $table->string('subtitle')->nullable()->default('Kabupaten Kepulauan Meranti');
            $table->text('appreciation_quote')->nullable();
            $table->string('poster_image')->nullable();
            $table->unsignedBigInteger('appreciation_count')->default(148);
            $table->boolean('is_featured')->default(true); // Edisi utama yang disorot di beranda
            $table->boolean('is_active')->default(true);
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });

        Schema::create('tribute_figures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tribute_edition_id')->constrained('tribute_editions')->onDelete('cascade');
            $table->string('name');
            $table->string('honor_title');
            $table->string('period')->nullable();
            $table->string('badge_color')->default('amber'); // amber, sky, emerald, rose, purple
            $table->string('photo')->nullable();
            $table->text('quote')->nullable();
            $table->text('contribution')->nullable();
            $table->string('instagram')->nullable();
            $table->integer('order_index')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('tribute_memories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tribute_edition_id')->constrained('tribute_editions')->onDelete('cascade');
            $table->string('title');
            $table->string('image');
            $table->text('caption')->nullable();
            $table->date('event_date')->nullable();
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tribute_memories');
        Schema::dropIfExists('tribute_figures');
        Schema::dropIfExists('tribute_editions');
    }
};
