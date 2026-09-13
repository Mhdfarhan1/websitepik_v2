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
        Schema::create('menu_settings', function (Blueprint $table) {
            $table->id();
            $table->string('menu_key')->unique();
            $table->string('menu_label');
            $table->boolean('pembina_visible')->default(true);
            $table->boolean('ketua_visible')->default(true);
            $table->boolean('anggota_visible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_settings');
    }
};
