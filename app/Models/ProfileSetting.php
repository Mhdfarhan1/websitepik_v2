<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'sejarah_title',
        'pembina_name',
        'pembina_period',
        'pembina_photo',
        'pembina_pantun',
        'pembina_speech',
        'about_title',
        'about_content',
        'about_video_url',
        'visi_text',
        'misi_text',
        'visi_misi_bg',
        'pilar_1_title', 'pilar_1_desc',
        'pilar_2_title', 'pilar_2_desc',
        'pilar_3_title', 'pilar_3_desc',
        'pilar_4_title', 'pilar_4_desc',
        'renstra_text', 'renstra_file',
        'tujuan_text', 'sasaran_text',
    ];
}
