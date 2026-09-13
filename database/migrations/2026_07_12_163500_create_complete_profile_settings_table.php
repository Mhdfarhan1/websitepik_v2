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
        Schema::create('complete_profile_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title');
            $table->text('hero_desc')->nullable();
            $table->string('pdf_path')->nullable();
            
            // Biography Section
            $table->string('bio_name');
            $table->string('bio_photo')->nullable();
            $table->text('bio_content')->nullable();
            $table->text('bio_expertise')->nullable();
            $table->text('bio_hopes')->nullable();
            
            // Identity Section
            $table->string('org_name');
            $table->string('org_abbreviation');
            $table->string('org_year');
            $table->string('org_base');
            $table->text('org_philosophy')->nullable();
            
            // Law/Regulations Section
            $table->string('reg_1_title')->nullable();
            $table->text('reg_1_desc')->nullable();
            $table->string('reg_2_title')->nullable();
            $table->text('reg_2_desc')->nullable();
            $table->string('reg_3_title')->nullable();
            $table->text('reg_3_desc')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complete_profile_settings');
    }
};
