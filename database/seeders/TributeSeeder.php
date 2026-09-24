<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TributeEdition;
use App\Models\TributeFigure;
use App\Models\MenuSetting;

class TributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Edisi Pertama: Periode 2024 — 2025
        $edition2024 = TributeEdition::updateOrCreate(
            ['period' => '2024 — 2025'],
            [
                'badge_title' => 'PANGGUNG KEHORMATAN & REKAM JEJAK',
                'title' => 'Proud Moments Duta GenRe',
                'period' => '2024 — 2025',
                'subtitle' => 'Kabupaten Kepulauan Meranti',
                'appreciation_quote' => 'Apresiasi setinggi-tingginya kepada para Duta GenRe yang telah berdedikasi, mengukir prestasi, dan mengharumkan nama PIK-R REQUEST SMAN 1 Tasik Putri Puyu di tingkat Kabupaten Kepulauan Meranti. Perjuangan, peluh, dan waktu yang telah kalian persembahkan menjadi lentera inspirasi abadi bagi seluruh generasi penerus.',
                'story_title' => 'Menapaki Jejak Juara: Perjuangan dan Kenangan Manis Duta GenRe 2024 — 2025',
                'story_content' => "Perjalanan menuju panggung kehormatan Duta GenRe Kabupaten Kepulauan Meranti bukanlah jalan yang instan. Semuanya bermula dari ruang kelas sederhana di SMAN 1 Tasik Putri Puyu, di mana semangat kepemimpinan, kepedulian remaja, dan cita-cita luhur mulai disemai bersama PIK-R REQUEST.\n\nNurmega, M. Fauzan, dan Putri Shalihati melalui tahapan persiapan yang begitu panjang dan menguras energi. Di bawah bimbingan pembina dan rekan-rekan sebaya, mereka mendalami substansi Generasi Berencana—mulai dari pemahaman mendalam tentang Triad KRR (Kesehatan Reproduksi Remaja, Napza, dan HIV/AIDS), pencegahan stunting dari hulu, hingga perencanaan masa depan yang matang. Latihan public speaking hingga larut malam dan pematangan program advokasi menjadi rutinitas harian demi membawa nama baik sekolah.\n\nMasa karantina dan malam puncak pemilihan di Selatpanjang menjadi saksi bisu keteguhan mental dan kesantunan mereka. Dengan penuh percaya diri, mereka membuktikan bahwa jarak dan keterbatasan geografis di pesisir bukanlah halangan untuk bersinar di tingkat kabupaten. Melalui penampilan yang memukau, Nurmega berhasil meraih Juara II Duta GenRe Putri 2024, disusul oleh M. Fauzan sebagai Duta GenRe III 2025, serta Putri Shalihati sebagai Duta GenRe Influencer 2025.\n\nBagi Keluarga Besar SMAN 1 Tasik Putri Puyu, piala dan selempang tersebut bukanlah sekadar simbol kemenangan, melainkan lambang ketulusan dalam menginspirasi sesama remaja. Di pundak mereka, harapan generasi muda yang sehat, cerdas, dan ceria terus dikobarkan.\n\nSemoga jejak bakti, kerendahan hati, dan dedikasi yang telah kalian torehkan menjadi lentera inspirasi abadi bagi adik-adik kelas generasi penerus. Terima kasih atas setiap peluh, waktu, dan kebanggaan yang kalian persembahkan untuk almamater tercinta!",
                'poster_image' => 'uploads/tributes/poster_duta_genre.jpg',
                'appreciation_count' => 148,
                'is_featured' => true,
                'is_active' => true,
                'order_index' => 1,
            ]
        );

        // 2. Data Tiga Tokoh / Duta untuk Edisi 2024 — 2025
        $figures = [
            [
                'tribute_edition_id' => $edition2024->id,
                'name' => 'NURMEGA',
                'honor_title' => 'Duta Genre III 2024',
                'period' => '2024',
                'badge_color' => 'amber',
                'photo' => null,
                'quote' => 'PIK-R adalah rumah tempat kami bertumbuh dan belajar bahwa kepedulian pada sesama remaja adalah langkah awal menuju perubahan besar yang bermakna.',
                'contribution' => 'Membuka tonggak sejarah prestasi PIK-R REQUEST SMAN 1 Tasik Putri Puyu di ajang Pemilihan Duta GenRe Kabupaten Kepulauan Meranti 2024.',
                'instagram' => 'nurmega',
                'order_index' => 1,
                'is_active' => true,
            ],
            [
                'tribute_edition_id' => $edition2024->id,
                'name' => 'M. FAUZAN',
                'honor_title' => 'Duta Genre III 2025',
                'period' => '2025',
                'badge_color' => 'sky',
                'photo' => null,
                'quote' => 'Jadilah remaja yang berencana, berani melangkah, dan tidak pernah ragu memberikan yang terbaik untuk almamater tercinta.',
                'contribution' => 'Melanjutkan tongkat estafet juara putra dan aktif mengadvokasikan edukasi kesehatan reproduksi serta pencegahan pernikahan dini.',
                'instagram' => 'm.fauzan',
                'order_index' => 2,
                'is_active' => true,
            ],
            [
                'tribute_edition_id' => $edition2024->id,
                'name' => 'PUTRI SHALIHATI',
                'honor_title' => 'Duta Genre Influencer 2025',
                'period' => '2025',
                'badge_color' => 'rose',
                'photo' => null,
                'quote' => 'Gunakan setiap media dan ruang bicara untuk menyebarkan pesan positif, menginspirasi teman sebaya agar saling merangkul demi masa depan cerah.',
                'contribution' => 'Menginspirasi remaja Kepulauan Meranti melalui konten edukasi kreatif digital serta advokasi program GenRe yang berdampak positif luas.',
                'instagram' => 'putri_shalihati',
                'order_index' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($figures as $fig) {
            TributeFigure::updateOrCreate(
                [
                    'tribute_edition_id' => $fig['tribute_edition_id'],
                    'name' => $fig['name'],
                ],
                $fig
            );
        }

        // 3. Pastikan Menu Settings dashboard aktif
        MenuSetting::updateOrCreate(
            ['menu_key' => 'jejak_bakti'],
            [
                'menu_label' => 'Jejak Bakti & Apresiasi',
                'pembina_visible' => true,
                'ketua_visible' => true,
                'anggota_visible' => false,
            ]
        );
    }
}
