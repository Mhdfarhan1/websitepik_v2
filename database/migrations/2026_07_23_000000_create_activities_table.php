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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->date('event_date');
            $table->string('time_start')->default('08:00');
            $table->string('time_end')->nullable();
            $table->string('location');
            $table->string('category')->default('Edukasi & Konseling');
            $table->string('image')->nullable();
            $table->string('status')->default('upcoming'); // upcoming, ongoing, completed
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
