<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaderSetting;
use App\Models\LeaderHistory;
use Illuminate\Support\Facades\File;

class LeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Leader Setting (Musik latar & Header)
        $audioPath = null;
        $srcAudio = public_path('uploads/tributes/audio/audio_1790274536_8rYyYBew.mp3');
        $targetDir = public_path('uploads/leaders/audio');
        
        if (File::exists($srcAudio)) {
            if (!File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }
            $targetAudio = $targetDir . '/audio_pemimpin_default.mp3';
            if (!File::exists($targetAudio)) {
                File::copy($srcAudio, $targetAudio);
            }
            $audioPath = 'uploads/leaders/audio/audio_pemimpin_default.mp3';
        }

        LeaderSetting::firstOrCreate(
            ['id' => 1],
            [
                'badge_title' => 'ESTAFET KEPEMIMPINAN & DEDIKASI',
                'page_title' => 'Jejak Nakhoda PIK-R REQUEST',
                'subtitle' => 'Panggung kehormatan dan rekam jejak para Ketua yang telah mendedikasikan waktu, jiwa, dan raganya menakhodai perjalanan PIK-R REQUEST SMAN 1 Tasik Putri Puyu dari masa ke masa.',
                'audio_file' => $audioPath,
                'audio_title' => 'Kenangan Terindah Pemimpin',
                'audio_artist' => 'Lagu Kenangan Estafet',
                'is_audio_active' => true,
            ]
        );

        // 2. Data Riwayat Ketua (Generasi I, II, III)
        $leaders = [
            [
                'name' => 'Ahmad Rinaldi, S.Kom.',
                'period' => '2022 — 2023',
                'generation' => 'Generasi I',
                'title_badge' => 'Ketua Perintis',
                'status' => 'demisioner',
                'photo' => null,
                'quote' => 'Memulai bukanlah tentang kesempurnaan sarana, melainkan keberanian menyalakan lentera harapan bagi sesama remaja.',
                'story' => "Menjadi Ketua pertama PIK-R REQUEST adalah amanah yang penuh dengan pertaruhan idealisme. Di tahun 2022, organisasi ini baru saja dirintis dari sebuah ruangan konseling kecil berukuran 3x4 meter di sudut sekolah.\n\nBanyak siswa yang saat itu belum memahami esensi Generasi Berencana (GenRe). Bersama rekan-rekan pengurus angkatan pertama, kami berkeliling dari kelas ke kelas, mengadakan sosialisasi santai di jam istirahat, hingga menginisiasi program Pojok Remaja Berencana pertama. Masa bakti setahun itu kami habiskan untuk menancapkan fondasi dasar tata kelola organisasi, menyusun struktur kepengurusan yang solid, dan membangun kepercayaan pihak sekolah serta para guru pembina.",
                'experience' => "Tantangan terberat di masa kepemimpinan kami adalah meyakinkan teman-teman sebaya bahwa konseling sebaya bukanlah hal yang tabu atau memalukan. Seringkali kami diremehkan dan dianggap hanya organisasi formalitas belaka.\n\nNamun, momen paling mengharukan dan tak terlupakan adalah ketika posko layanan konseling kami pertama kali didatangi oleh seorang siswa yang menangis dan butuh didengarkan. Di titik itulah kami sadar, wadah ini benar-benar menyelamatkan masa depan seorang remaja. Rasa lelah, rapat hingga sore hari, dan keterbatasan anggaran langsung sirna.",
                'hope' => "Pesan saya untuk seluruh adik-adik penerus nahkoda PIK-R REQUEST: Jagalah rumah ini dengan penuh keikhlasan. Jabatan ketua adalah amanah pengabdian, bukan ajang mencari popularitas. Teruslah menjadi telinga yang mendengar tanpa menghakimi, dan jadilah mercusuar inspirasi yang membanggakan almamater tercinta SMAN 1 Tasik Putri Puyu!",
                'instagram' => 'rinaldi_ahmad',
                'linkedin' => null,
                'order_index' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Siti Rahmawati',
                'period' => '2023 — 2024',
                'generation' => 'Generasi II',
                'title_badge' => 'Ketua Demisioner',
                'status' => 'demisioner',
                'photo' => null,
                'quote' => 'Kepemimpinan perempuan adalah tentang kelembutan yang menguatkan, empati yang merangkul, dan ketegasan dalam bertindak.',
                'story' => "Memasuki periode 2023–2024, estafet kepemimpinan berfokus pada ekspansi kegiatan ke luar lingkungan sekolah. Kami ingin PIK-R REQUEST tidak hanya aktif di dalam pagar SMAN 1 Tasik Putri Puyu, melainkan juga dirasakan dampaknya oleh masyarakat pesisir di Kepulauan Meranti.\n\nDi masa kepengurusan kami, program advokasi pencegahan pernikahan usia dini dan kampanye anti-stunting berhasil menembus berbagai desa pesisir. Kami juga mulai merapikan dokumentasi digital dan memperkenalkan media sosial organisasi sebagai sarana edukasi kreatif bagi remaja zaman sekarang.",
                'experience' => "Pengalaman paling berkesan adalah ketika kami menggelar Aksi Safari Konselor Sebaya menyusuri desa-desa di sekitar Tasik Putri Puyu. Melewati jalanan gambut dengan sepeda motor bersama teman-teman demi memberikan edukasi gizi dan kespro kepada para remaja desa adalah kenangan yang tak ternilai.\n\nTentu ada gesekan dinamika internal, perbedaan pendapat antarpengurus, dan rasa jenuh. Namun, kami belajar menyelesaikannya dengan keterbukaan di ruang rapat sambil minum teh bersama, selalu mengingat kembali tujuan awal kami mengabdi.",
                'hope' => "Kepada pengurus masa kini dan mendatang: Jangan pernah lelah menyebarkan kebaikan. Zaman boleh berubah, teknologi semakin canggih, namun kehangatan komunikasi tatap muka dan ketulusan hati konselor sebaya tidak akan pernah bisa tergantikan oleh apa pun.",
                'instagram' => 'siti_rahma',
                'linkedin' => null,
                'order_index' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Fauzi Ramadhan',
                'period' => '2024 — 2025',
                'generation' => 'Generasi III',
                'title_badge' => 'Ketua Demisioner',
                'status' => 'demisioner',
                'photo' => null,
                'quote' => 'Inovasi digital dan sinergi tanpa batas adalah kunci membawa PIK-R REQUEST melompat lebih tinggi.',
                'story' => "Periode 2024–2025 ditandai dengan era transformasi digital dan pencapaian prestasi monumental. Sebagai ketua Generasi III, tantangan kami adalah membuktikan bahwa generasi muda pesisir memiliki kapasitas intelektual dan kreativitas yang setara dengan kota-kota besar.\n\nKami meluncurkan sistem konseling berbasis formulir online, mengoptimalkan database anggota, serta mengantarkan delegasi terbaik kita menembus panggung kehormatan Duta GenRe Kabupaten Kepulauan Meranti dengan raihan piala bergengsi yang mengharumkan nama sekolah.",
                'experience' => "Momen ketika rekan-rekan kita diumumkan sebagai juara di panggung kabupaten adalah detik-detik yang membuat air mata seluruh pengurus tumpah. Semua malam-malam tanpa tidur saat latihan public speaking, kritik yang kami terima, dan peluh latihan terbayar lunas dalam satu pelukan bangga bersama Ibu Pembina dan Kepala Sekolah.",
                'hope' => "Untuk Ketua berikutnya dan seluruh jajaran pengurus: Pertahankan nama harum almamater. Tinggikan standar prestasi, namun selalu rendahkan hati dalam melayani sesama teman sekolah. Jadikan PIK-R REQUEST tempat paling aman bagi siapapun yang sedang mencari arah.",
                'instagram' => 'fauzi_rmdhn',
                'linkedin' => null,
                'order_index' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($leaders as $leaderData) {
            LeaderHistory::updateOrCreate(
                ['name' => $leaderData['name'], 'period' => $leaderData['period']],
                $leaderData
            );
        }
    }
}
