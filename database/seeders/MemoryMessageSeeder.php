<?php

namespace Database\Seeders;

use App\Models\MemoryMessage;
use App\Models\MemoryMessageSetting;
use App\Models\SilentMoment;
use App\Models\FarewellLetter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class MemoryMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Copy audio sample for ambient background music
        $audioPath = null;
        $srcAudio = public_path('uploads/time_capsules/audio/audio_capsule_default.mp3');
        if (!File::exists($srcAudio)) {
            $srcAudio = public_path('uploads/tributes/audio/audio_1790274536_8rYyYBew.mp3');
        }
        $targetDir = public_path('uploads/memory_messages/audio');

        if (File::exists($srcAudio)) {
            if (!File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }
            $targetAudio = $targetDir . '/audio_memory_default.mp3';
            if (!File::exists($targetAudio)) {
                File::copy($srcAudio, $targetAudio);
            }
            $audioPath = 'uploads/memory_messages/audio/audio_memory_default.mp3';
        }

        // 2. Setting Halaman
        MemoryMessageSetting::updateOrCreate(
            ['id' => 1],
            [
                'badge_title' => 'BILIK NOSTALGIA & SUASANA HATI',
                'page_title' => 'Jejak Rasa — Kata yang Belum Sempat Terucap',
                'subtitle' => 'Untuk setiap pelukan perpisahan yang tertahan, rasa terima kasih yang terlambat disampaikan, dan ruang sekretariat yang kini telah sunyi. Di sinilah rasa itu kami abadikan.',
                'audio_file' => $audioPath,
                'audio_title' => 'Alunan Kenangan & Rindu',
                'audio_artist' => 'PIK-R REQUEST',
                'is_audio_active' => true,
                'quotes_narrative' => '“Kita memulai segalanya sebagai orang asing yang canggung, bertumbuh menjadi keluarga yang saling menguatkan, dan akhirnya berpisah menjadi kenangan yang membuat mata berkaca-kaca.”',
            ]
        );

        // 3. Surat Tak Sempat Terucap (The Unsaid Words)
        $messages = [
            [
                'sender_name' => 'Rian (Alumni 2022)',
                'sender_role' => 'Mantan Koordinator Divisi Konseling',
                'recipient_name' => 'Untuk: Siti & Sahabat Divisi Konseling',
                'generation' => 'Generasi 2 (2022/2023)',
                'category' => 'maaf',
                'message' => "Dulu pas kita nyiapin modul konseling sebaya dan aku marah-marah karena deadline mepet, sejujurnya sampai hari ini rasa bersalah itu masih ada. Maafin ego kekanak-kanakan aku waktu itu ya.\n\nMakasih kalian nggak pernah ninggalin aku sendirian dan selalu nyelipin sebungkus roti di ranselku tiap malam. Sekarang kita sudah di kampus yang berbeda-beda, tapi tiap dengar lagu GenRe, aku selalu teringat tawa kalian di ruang sekretariat. Semoga kalian selalu bahagia di perantauan masing-masing.",
                'paper_theme' => 'warm',
                'hug_count' => 48,
                'is_pinned' => true,
                'is_approved' => true,
            ],
            [
                'sender_name' => 'Seseorang yang Pernah Terluka',
                'sender_role' => 'Kader Angkatan 3',
                'recipient_name' => 'Untuk: Ruang Sekretariat PIK-R Kita',
                'generation' => 'Generasi 3 (2023/2024)',
                'category' => 'terima_kasih',
                'message' => "Di rumah, aku anak yang tidak pernah didengar dan selalu merasa jadi beban. Tapi di ruangan berukuran 3x4 meter beralas karpet hijau ini, untuk pertama kalinya dalam hidupku, suaraku didengar tanpa ada yang menghakimi.\n\nTerima kasih PIK-R REQUEST sudah menyelamatkan masa remajaku dari rasa putus asa. Walau sekarang kuncinya sudah dipegang oleh adik-adik generasi baru, ruangan itu akan selalu jadi rumah pertama tempat aku merasa berharga.",
                'paper_theme' => 'vintage',
                'hug_count' => 76,
                'is_pinned' => true,
                'is_approved' => true,
            ],
            [
                'sender_name' => 'Ibu Pembina Tercinta',
                'sender_role' => 'Guru Pembina PIK-R REQUEST',
                'recipient_name' => 'Untuk: Seluruh Anak-Anakku yang Telah Melangkah Pergi',
                'generation' => 'Semua Generasi',
                'category' => 'catatan_pembina',
                'message' => "Melihat kalian pertama kali masuk ke organisasi ini sebagai anak-anak yang pemalu, canggung, dan sering menangis karena masalah keluarga... lalu kini melepaskan kalian pergi sebagai pemuda-pemudi yang tangguh, percaya diri, dan berhati mulia adalah kehormatan terbesar dalam hidup Ibu.\n\nJangan pernah merasa sendiri di tanah rantau ya, Nak. Ingatlah bahwa di sekolah tercinta SMAN 1 Tasik Putri Puyu ini, doa seorang guru pembina akan selalu mengiringi setiap langkah sukses kalian.",
                'paper_theme' => 'rose',
                'hug_count' => 112,
                'is_pinned' => true,
                'is_approved' => true,
            ],
            [
                'sender_name' => 'Kader Logistik yang Sering Capek',
                'sender_role' => 'Divisi Perlengkapan & Sound',
                'recipient_name' => 'Untuk: Partner Rapat Jam 7 Malam',
                'generation' => 'Generasi 3 (2023/2024)',
                'category' => 'rindu',
                'message' => "Kangen masa-masa kita ketiduran di lantai beralas kardus bekas karena kecapekan dekor panggung GenRe. Waktu itu kita sering ngeluh capek, lapar, dan pengen buru-buru demisioner.\n\nTernyata benar kata pepatah, yang bikin dada sesak sekarang bukan lelahnya, tapi tawa di sela-sela lelah itu yang nggak akan pernah bisa kita ulang lagi seumur hidup.",
                'paper_theme' => 'night',
                'hug_count' => 39,
                'is_pinned' => false,
                'is_approved' => true,
            ],
            [
                'sender_name' => 'Kakak Alumni 2023',
                'sender_role' => 'Demisioner BPH',
                'recipient_name' => 'Untuk: Adik-Adik Kader Baru Penerus Perjuangan',
                'generation' => 'Generasi 4 (2024/2025)',
                'category' => 'pesan_adik',
                'message' => "Dek, kalau suatu hari nanti proker kalian sepi peminat atau kalian lelah dihujat teman sebaya karena dianggap 'sok suci', tolong jangan mundur ya. Dulu kami juga pernah menangis di pojokan mushola karena hal yang sama.\n\nBertahanlah, Dek. Kelak ketika kalian berdiri di panggung kelulusan, kalian akan menyadari bahwa menjadi tempat bersandar bagi remaja lain yang sedang rapuh adalah hal paling mulia yang pernah kalian berikan untuk sekolah ini.",
                'paper_theme' => 'navy',
                'hug_count' => 61,
                'is_pinned' => false,
                'is_approved' => true,
            ],
            [
                'sender_name' => 'Anonim',
                'sender_role' => 'Kader 2021',
                'recipient_name' => 'Untuk: Kamu yang Duduk di Sebelahku Waktu Rapat Perdana',
                'generation' => 'Generasi 1 (2021/2022)',
                'category' => 'rindu',
                'message' => "Sampai kelulusan tiba, aku nggak pernah berani bilang kalau senyummu pas pertama kali kita kenalan di ruang PIK-R adalah alasan kenapa aku selalu rajin datang kumpul mingguan. Semoga kamu bahagia dengan jalan yang kamu pilih sekarang.",
                'paper_theme' => 'warm',
                'hug_count' => 53,
                'is_pinned' => false,
                'is_approved' => true,
            ],
        ];

        foreach ($messages as $msg) {
            MemoryMessage::create($msg);
        }

        // 4. Momen Naratif "Ruang yang Kini Sunyi"
        $moments = [
            [
                'title' => 'Sudut Meja di Jam Lima Sore',
                'subtitle' => 'Ketika bel pulang sekolah telah berdering dua jam yang lalu',
                'period' => 'Momen Abadi',
                'narrative' => "Dulu, ruangan ini tak pernah benar-benar sunyi. Di jam lima sore saat seluruh sekolah sudah sepi, lampu ruangan PIK-R adalah satu-satunya yang masih menyala terang. Ada suara tawa memecah hening, gemerisik kertas modul, dan aroma teh hangat yang kita seduh bersama. Kini, ruangan itu terkunci rapat di jam yang sama. Tapi jika kau berdiri di depan pintunya, kau masih bisa merasakan hangatnya pelukan kenangan kita.",
                'order_index' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Malam Menjelang Serah Terima Jabatan',
                'subtitle' => 'Malam terakhir memegang kunci dan almamater kebanggaan',
                'period' => 'Periode Demisioner',
                'narrative' => "Kita duduk melingkar di atas karpet usang yang sama. Tak banyak kata yang terucap malam itu, hanya tatapan mata yang saling mengerti bahwa masa-masa kita telah usai. Kita tersenyum menahan air mata yang mendesak keluar, menyadari bahwa besok pagi, status kita resmi berubah dari 'pengurus' menjadi 'kenangan'.",
                'order_index' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Pelukan Tanpa Kata di Belakang Panggung',
                'subtitle' => 'Ketika selempang pengabdian harus diserahkan kepada generasi penerus',
                'period' => 'Hari Kelulusan',
                'narrative' => "Saat nama kami dipanggil untuk menyerahkan estafet kepemimpinan, dada ini terasa begitu sesak. Bukan karena kami tak rela melepaskan jabatan, tapi karena kami menyadari bahwa masa putih abu-abu di tempat ini benar-benar telah sampai di titik akhirnya. Pelukan di belakang panggung hari itu adalah pelukan tererat yang pernah kami berikan satu sama lain.",
                'order_index' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($moments as $mom) {
            SilentMoment::create($mom);
        }

        // 5. Surat Pamit Demisioner (Farewell Letters)
        $farewells = [
            [
                'generation_title' => 'Surat Pamit Generasi 2 — Kabinet Reksa Abyakta',
                'period' => 'Periode 2022/2023',
                'author_representative' => 'Seluruh Pengurus Demisioner Generasi 2',
                'excerpt' => '“Kini kunci ruangan ini telah berada di tangan kalian, adik-adikku. Rawatlah rumah kedua ini dengan penuh cinta...”',
                'letter_content' => "Adik-adikku tercinta,\n\nKetika surat ini kalian baca, lembaran masa bakti kami telah resmi tertutup. Kami melangkah keluar dari ruangan sekretariat ini bukan dengan kepala tertunduk, melainkan dengan dada yang dipenuhi rasa syukur tak terhingga karena pernah diberi kesempatan mengabdi bersama orang-orang terbaik di sekolah ini.\n\nKini kunci ruangan ini telah berada di genggaman tangan kalian. Di dinding ruangan itulah kami menitipkan sejuta keringat, air mata, tawa, dan mimpi-mimpi kami. Tolong rawat rumah kedua ini. Jangan biarkan seorang pun remaja di SMAN 1 Tasik Putri Puyu merasa kesepian dan kehilangan arah selama bendera PIK-R REQUEST masih berkibar.\n\nTerima kasih untuk almamater tercinta, terima kasih untuk para guru pembina, dan terima kasih untuk setiap detik yang pernah kita lewati bersama.\n\nDengan segenap cinta,\nKeluarga Besar Demisioner Generasi 2.",
                'order_index' => 1,
                'is_active' => true,
            ],
            [
                'generation_title' => 'Surat Terbuka Generasi 3 — Lentera Harapan',
                'period' => 'Periode 2023/2024',
                'author_representative' => 'Badan Pengurus Harian Demisioner Generasi 3',
                'excerpt' => '“Menjadi pengurus PIK-R bukan tentang selempang atau pujian, melainkan tentang kerelaan menjadi lilin bagi sesama...”',
                'letter_content' => "Sahabat-sahabatku,\n\nPerjalanan satu tahun ini terasa begitu singkat. Rasanya baru kemarin kita berdiri gugup di depan mimbar pelantikan, dan hari ini kita harus berpamitan melangkah ke gerbang kelulusan.\n\nSatu hal yang kami pelajari dari tempat ini: menjadi kader GenRe bukan tentang selempang juara atau pujian orang lain. Menjadi kader adalah tentang kerelaanmu duduk berjam-jam mendengarkan isak tangis sahabatmu yang hancur hatinya, lalu membantunya tersenyum kembali.\n\nSelamat berjuang adik-adikku. Kami pamit undur diri dari panggung kepengurusan, namun jiwa dan cinta kami akan selalu tertinggal di PIK-R REQUEST.",
                'order_index' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($farewells as $far) {
            FarewellLetter::create($far);
        }
    }
}
