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
        Schema::table('tribute_editions', function (Blueprint $table) {
            $table->string('school_logo')->nullable()->after('poster_image');
            $table->string('institution_name')->nullable()->default('Keluarga Besar PIK–R REQUEST')->after('school_logo');
            $table->string('institution_subtext')->nullable()->default('SMAN 1 Tasik Putri Puyu — Kabupaten Kepulauan Meranti')->after('institution_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tribute_editions', function (Blueprint $table) {
            $table->dropColumn(['school_logo', 'institution_name', 'institution_subtext']);
        });
    }
};
