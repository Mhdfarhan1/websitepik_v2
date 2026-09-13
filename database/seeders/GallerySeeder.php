<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleries = [
            [
                'title' => 'Pembuatan Poster Anti-Bullying',
                'image' => 'https://images.unsplash.com/photo-1544928147-79a2dbc1f389?auto=format&fit=crop&q=80&w=600',
                'type' => 'image',
                'order_index' => 1,
            ],
            [
                'title' => 'Edukasi Peer Counselor',
                'image' => 'https://images.unsplash.com/photo-1529390079861-591de354faf5?auto=format&fit=crop&q=80&w=1000',
                'type' => 'image',
                'order_index' => 2,
            ],
            [
                'title' => 'Diskusi Kelompok Remaja',
                'image' => 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?auto=format&fit=crop&q=80&w=600',
                'type' => 'image',
                'order_index' => 3,
            ],
            [
                'title' => 'Pelatihan Keterampilan Hidup',
                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&q=80&w=600',
                'type' => 'image',
                'order_index' => 4,
            ],
        ];

        foreach ($galleries as $item) {
            Gallery::updateOrCreate(
                ['image' => $item['image']],
                $item
            );
        }
    }
}
