<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompleteProfileSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_title',
        'hero_desc',
        'hero_bg',
        'hero_tag',
        'hero_bg_color',
        'pdf_path',
        'bio_name',
        'bio_photo',
        'bio_content',
        'bio_expertise',
        'bio_hopes',
        'org_name',
        'org_abbreviation',
        'org_year',
        'org_base',
        'org_philosophy',
        'reg_1_title',
        'reg_1_desc',
        'reg_2_title',
        'reg_2_desc',
        'reg_3_title',
        'reg_3_desc',
    ];
}
