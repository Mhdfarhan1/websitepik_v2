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
        Schema::create('profile_settings', function (Blueprint $table) {
            $table->id();
            $table->string('sejarah_title');
            $table->string('pembina_name');
            $table->string('pembina_period');
            $table->string('pembina_photo')->nullable();
            $table->text('pembina_pantun')->nullable();
            $table->text('pembina_speech')->nullable();
            $table->string('about_title');
            $table->text('about_content')->nullable();
            $table->string('about_video_url')->nullable();
            $table->timestamps();
        });

        Schema::create('history_milestones', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_milestones');
        Schema::dropIfExists('profile_settings');
    }
};
