<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuSetting extends Model
{
    protected $fillable = [
        'menu_key',
        'menu_label',
        'pembina_visible',
        'ketua_visible',
        'anggota_visible',
    ];

    protected $casts = [
        'pembina_visible' => 'boolean',
        'ketua_visible' => 'boolean',
        'anggota_visible' => 'boolean',
    ];
}
