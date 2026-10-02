<?php

namespace Database\Seeders;

use App\Models\TimeCapsule;
use App\Models\TimeCapsuleItem;
use App\Models\TimeCapsuleSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class TimeCapsuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Setting Ruang Arsip Kotak Waktu
        $audioPath = null;
        $srcAudio = public_path('uploads/tributes/audio/audio_1790274536_8rYyYBew.mp3');
        $targetDir = public_path('uploads/time_capsules/audio');

        if (File::exists($srcAudio)) {
            if (!File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }
            $targetAudio = $targetDir . '/audio_capsule_default.mp3';
            if (!File::exists($targetAudio)) {
                File::copy($srcAudio, $targetAudio);
            }
            $audioPath = 'uploads/time_capsules/audio/audio_capsule_default.mp3';
        }

        TimeCapsuleSetting::firstOrCreate(
            ['id' => 1],
            [
                'badge_title' => 'RUANG ARSIP DIGITAL MASA DEPAN',
                'page_title' => '🔐 Kotak Waktu PIK-R',
                'subtitle' => '“Tidak semua cerita harus dibaca hari ini. Beberapa cerita sengaja kita tinggalkan untuk masa depan.”',
                'audio_file' => $audioPath,
                'audio_title' => 'Melodi Penjaga Waktu',
                'audio_artist' => 'PIK-R REQUEST',
                'is_audio_active' => true,
            ]
        );

        // 2. Kapsul Waktu Utama: TIME CAPSULE 2026 (TERKUNCI)
        $capsule2026 = TimeCapsule::updateOrCreate(
            ['slug' => 'time-capsule-2026'],
            [
                'title' => 'TIME CAPSULE 2026',
                'creator_generation' => 'Generasi PIK-R REQUEST 2025–2026',
                'created_date' => '2026-09-26',
                'unlock_date' => '2030-09-26 00:00:00',
                'seal_message' => 'Kotak waktu ini dikunci rapat dengan komitmen, cinta, dan dedikasi seluruh pengurus PIK-R REQUEST angkatan 2025–2026. Di dalamnya tersimpan surat rahasia, rekaman suara, foto perjuangan, dan visi besar yang kami titipkan kepada adik-adik penerus perjuangan di tahun 2030.',
                'cover_image' => null,
                'theme_color' => 'amber',
                'is_featured' => true,
                'is_active' => true,
                'order_index' => 1,
            ]
        );

        // Items for TIME CAPSULE 2026
        // Pesan & Surat
        TimeCapsuleItem::updateOrCreate(
            ['time_capsule_id' => $capsule2026->id, 'title' => 'Surat untuk Nahkoda & Pengurus PIK-R Tahun 2030'],
            [
                'type' => 'letter',
                'author_name' => 'Farhan & Badan Pengurus Harian',
                'author_role' => 'Ketua Umum & BPH 2025–2026',
                'content' => "Halo adik-adik pengurus PIK-R REQUEST di tahun 2030!\n\nSaat kalian membaca surat ini, mungkin dunia dan teknologi di sekolah kita telah berubah drastis. Ruang sekretariat kita mungkin sudah jauh lebih megah, piala-piala baru telah berjejer, atau mungkin tantangan remaja di zaman kalian jauh lebih kompleks daripada yang kami hadapi hari ini.\n\nKami menulis surat ini di malam yang hening pada tanggal 26 September 2026, setelah seharian penuh kami menuntaskan agenda besar organisasi. Ada rasa haru dan lelah, namun rasa bangga kami jauh lebih besar. Kami ingin menitipkan satu hal sederhana: Jangan pernah hilangkan ruh kekeluargaan di PIK-R REQUEST. Ruang ini bukan sekadar tentang sertifikat atau piala kejuaraan, melainkan tentang menjadi tempat berteduh teraman bagi setiap remaja yang sedang terluka dan mencari arah hidup.\n\nRawatlah pohon yang telah kami tanam ini. Jadilah pemimpin yang memeluk, bukan memukul; jadilah pendengar yang tulus, bukan pencela. Kami bangga pada kalian, wahai generasi masa depan!",
                'order_index' => 1,
                'is_active' => true,
            ]
        );

        TimeCapsuleItem::updateOrCreate(
            ['time_capsule_id' => $capsule2026->id, 'title' => 'Bisikan Kasih dari Bilik Konseling Sebaya'],
            [
                'type' => 'letter',
                'author_name' => 'Tim Konselor Sebaya GenRe',
                'author_role' => 'Divisi Konseling & Edukasi Sebaya',
                'content' => "Untuk kalian para konselor masa depan,\n\nDi tahun 2026 ini, kami telah mendengarkan ratusan curahan hati teman-teman sebaya. Ada air mata, kegelisahan tentang keluarga, masa depan, dan pergaulan. Tugas menjadi konselor sebaya seringkali menguras emosi, tetapi percayalah, satu senyuman lega dari teman yang terbantu adalah anugerah terbesar.\n\nIngat selalu kode etik kerahasiaan kita. Simpan setiap rahasia sahabatmu di dalam hatimu yang paling suci. Bila kalian lelah, ingatlah bahwa kami di tahun 2026 mendoakan setiap langkah kalian.",
                'order_index' => 2,
                'is_active' => true,
            ]
        );

        TimeCapsuleItem::updateOrCreate(
            ['time_capsule_id' => $capsule2026->id, 'title' => 'Pesan Cinta dari Pendidik Sebaya'],
            [
                'type' => 'letter',
                'author_name' => 'Divisi Pendidik Sebaya',
                'author_role' => 'Pendidik Sebaya 2025–2026',
                'content' => "Tiga Nilai GenRe (Say No to Early Marriage, Sex Before Marriage, and Drugs) telah kami gaungkan ke setiap pelosok sekolah dan desa di Tasik Putri Puyu. Teruslah bersuara dengan lantang dan santun, jangan pernah lelah mengedukasi!",
                'order_index' => 3,
                'is_active' => true,
            ]
        );

        // Cerita & Rekam Jejak
        TimeCapsuleItem::updateOrCreate(
            ['time_capsule_id' => $capsule2026->id, 'title' => 'Malam Penuh Doa Sebelum Ajang Jambore GenRe Riau'],
            [
                'type' => 'story',
                'author_name' => 'Tim Delegasi 2026',
                'author_role' => 'Pengurus Inti',
                'content' => "Kisah rahasia yang tidak pernah kami publikasikan di media sosial: H-1 sebelum keberangkatan delegasi ke tingkat provinsi, salah satu properti pementasan kami rusak terkena hujan deras di pelabuhan penyeberangan. Kami sempat panik dan hampir putus asa. Namun di sanalah keajaiban kebersamaan terjadi. Seluruh pengurus berkumpul hingga jam 3 dini hari, memperbaiki semuanya dengan tawa dan saling menguatkan. Esoknya, kita berhasil membuktikan bahwa keterbatasan geografis bukan halangan untuk berprestasi!",
                'order_index' => 4,
                'is_active' => true,
            ]
        );

        TimeCapsuleItem::updateOrCreate(
            ['time_capsule_id' => $capsule2026->id, 'title' => 'Rahasia Botol Kaca di Bawah Pohon Palem Sekolah'],
            [
                'type' => 'story',
                'author_name' => 'Arsiparis Organisasi',
                'author_role' => 'Divisi Dokumentasi',
                'content' => "Selain arsip digital di website ini, pada 26 September 2026 kami juga menanam sebuah kapsul fisik mini berupa tabung aluminium anti-karat di dekat taman konseling sekolah. Di dalamnya ada foto polaroid seluruh pengurus dan gantungan kunci khas angkatan kami!",
                'order_index' => 5,
                'is_active' => true,
            ]
        );

        // Foto & Video
        TimeCapsuleItem::updateOrCreate(
            ['time_capsule_id' => $capsule2026->id, 'title' => 'Foto Keluarga Besar Pengurus PIK-R REQUEST 2025/2026'],
            [
                'type' => 'photo',
                'author_name' => 'Dokumentasi BPH',
                'author_role' => 'Fotografer Resmi',
                'content' => 'Potret senyuman bahagia di hari pengukuhan kepengurusan. Mengenakan almamater kebanggaan dengan tatapan penuh optimisme.',
                'media_path' => 'assets/img/bg_utama.JPG',
                'order_index' => 6,
                'is_active' => true,
            ]
        );

        TimeCapsuleItem::updateOrCreate(
            ['time_capsule_id' => $capsule2026->id, 'title' => 'Dokumentasi Video: Suara Hati untuk Masa Depan'],
            [
                'type' => 'video',
                'author_name' => 'Tim Multimedia PIK-R',
                'author_role' => 'Divisi Kreatif',
                'content' => 'Video kompilasi pesan singkat dari masing-masing kepala divisi yang disatukan untuk dibuka pada 26 September 2030.',
                'external_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'order_index' => 7,
                'is_active' => true,
            ]
        );


        // 3. Kapsul Waktu Demo Terbuka: TIME CAPSULE 2022 (TELAH DIBUKA)
        $capsule2022 = TimeCapsule::updateOrCreate(
            ['slug' => 'time-capsule-2022'],
            [
                'title' => 'TIME CAPSULE 2022 — Titik Mula Sejarah',
                'creator_generation' => 'Generasi Perintis 2022–2023',
                'created_date' => '2022-09-26',
                'unlock_date' => '2024-09-26 00:00:00', // Sudah lewat, otomatis terbuka!
                'seal_message' => 'Kotak waktu pertama dalam sejarah PIK-R REQUEST. Dibuat oleh angkatan perintis untuk dibuka setelah 2 tahun masa bakti.',
                'cover_image' => null,
                'theme_color' => 'emerald',
                'is_featured' => false,
                'is_active' => true,
                'order_index' => 2,
            ]
        );

        TimeCapsuleItem::updateOrCreate(
            ['time_capsule_id' => $capsule2022->id, 'title' => 'Surat Pengakuan dari Generasi Pendiri'],
            [
                'type' => 'letter',
                'author_name' => 'Ahmad Rinaldi',
                'author_role' => 'Ketua Perintis 2022',
                'content' => "Ketika kami memulai PIK-R REQUEST di tahun 2022, kami tidak memiliki apa-apa selain kemauan keras. Ruang konseling kami saat itu hanya pinjaman di sudut perpustakaan. Surat ini menjadi bukti bahwa mimpi kecil yang dirawat dengan kesungguhan hati akan menjelma menjadi rumah besar penuh prestasi. Selamat membaca bagi kalian yang kini menikmati hasil perjuangan masa awal!",
                'order_index' => 1,
                'is_active' => true,
            ]
        );

        TimeCapsuleItem::updateOrCreate(
            ['time_capsule_id' => $capsule2022->id, 'title' => 'Catatan Perjalanan Rintisan Pertama'],
            [
                'type' => 'story',
                'author_name' => 'Pengurus Perintis',
                'author_role' => 'Angkatan 2022',
                'content' => "Hari pertama sosialisasi GenRe di aula sekolah: Dari 100 brosur fotokopi hitam putih yang kami bagikan, hampir setengahnya ditinggalkan di kursi. Tapi kami tidak berkecil hati. Dari sanalah lahir ide layanan konseling sebaya yang hangat dan bersahabat.",
                'order_index' => 2,
                'is_active' => true,
            ]
        );

        TimeCapsuleItem::updateOrCreate(
            ['time_capsule_id' => $capsule2022->id, 'title' => 'Momen Peletakan Prasasti Generasi Perintis'],
            [
                'type' => 'photo',
                'author_name' => 'Dokumentasi 2022',
                'author_role' => 'Pengurus Awal',
                'content' => 'Foto kenangan saat pertama kali plang nama PIK-R REQUEST dipasang di dinding sekolah SMAN 1 Tasik Putri Puyu.',
                'media_path' => 'assets/img/bg_berita.JPG',
                'order_index' => 3,
                'is_active' => true,
            ]
        );
    }
}
