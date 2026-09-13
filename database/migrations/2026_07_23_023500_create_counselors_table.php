<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('counselors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role_type')->default('konselor_sebaya'); // konselor_sebaya, pendidik_sebaya, keduanya
            $table->string('class_or_title')->nullable(); // e.g. Siswa XI IPA 1 / Konselor Terlatih BKKBN
            $table->string('photo')->nullable();
            $table->text('bio_motto')->nullable();
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('counselors');
    }
};
