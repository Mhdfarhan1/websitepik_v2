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
            $table->string('pilar_1_title')->nullable();
            $table->text('pilar_1_desc')->nullable();
            $table->string('pilar_2_title')->nullable();
            $table->text('pilar_2_desc')->nullable();
            $table->string('pilar_3_title')->nullable();
            $table->text('pilar_3_desc')->nullable();
            $table->string('pilar_4_title')->nullable();
            $table->text('pilar_4_desc')->nullable();
            
            $table->string('renstra_text')->nullable();
            $table->string('renstra_file')->nullable();
            
            $table->text('tujuan_text')->nullable();
            $table->text('sasaran_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_settings', function (Blueprint $table) {
            $table->dropColumn([
                'pilar_1_title', 'pilar_1_desc',
                'pilar_2_title', 'pilar_2_desc',
                'pilar_3_title', 'pilar_3_desc',
                'pilar_4_title', 'pilar_4_desc',
                'renstra_text', 'renstra_file',
                'tujuan_text', 'sasaran_text'
            ]);
        });
    }
};
