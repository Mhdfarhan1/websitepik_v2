<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixCpanelStorageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:fix-cpanel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize uploaded media files and verify storage symlink for cPanel hosting';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai perbaikan dan sinkronisasi storage cPanel...');

        $projectUploads = base_path('public/uploads');
        $activeUploads = public_path('uploads');
        $activePublic = public_path();

        $this->line("Direktori project: " . base_path());
        $this->line("Direktori public aktif: " . $activePublic);

        // 1. Ensure required subdirectories exist in active public/uploads
        $subfolders = ['gallery', 'news', 'achievements', 'appearance', 'profile', 'structures', 'documents'];
        foreach ($subfolders as $folder) {
            $path = $activeUploads . DIRECTORY_SEPARATOR . $folder;
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true, true);
                $this->line("-> Dibuat direktori: {$folder}");
            }
        }

        // 2. Sync files from project public to active public if different
        $synced = 0;
        if (File::exists($projectUploads) && realpath($projectUploads) !== realpath($activeUploads)) {
            $files = File::allFiles($projectUploads);
            foreach ($files as $file) {
                $rel = $file->getRelativePathname();
                $dest = $activeUploads . DIRECTORY_SEPARATOR . $rel;
                $destDir = dirname($dest);

                if (!File::exists($destDir)) {
                    File::makeDirectory($destDir, 0755, true, true);
                }

                if (!file_exists($dest) || filemtime($file->getRealPath()) > filemtime($dest)) {
                    if (@copy($file->getRealPath(), $dest)) {
                        $synced++;
                    }
                }
            }
            $this->info("Berhasil menyinkronkan {$synced} file dari project public ke active public_html/uploads.");
        } else {
            $this->info("Direktori uploads project dan active sudah identik.");
        }

        // 3. Check storage symlink
        $storageTarget = storage_path('app/public');
        $publicStorage = public_path('storage');

        if (!File::exists($storageTarget)) {
            File::makeDirectory($storageTarget, 0755, true, true);
        }

        if (is_link($publicStorage)) {
            $target = @readlink($publicStorage);
            if (!$target || !file_exists($publicStorage)) {
                @unlink($publicStorage);
                if (@symlink($storageTarget, $publicStorage)) {
                    $this->info("Symlink storage yang rusak berhasil diperbaiki.");
                } else {
                    $this->warn("Gagal membuat symlink. Fallback route Laravel tetap aktif menangani file.");
                }
            } else {
                $this->info("Symlink storage sudah terhubung dengan baik.");
            }
        } elseif (!file_exists($publicStorage)) {
            if (@symlink($storageTarget, $publicStorage)) {
                $this->info("Symlink storage berhasil dibuat: {$publicStorage} -> {$storageTarget}");
            } else {
                $this->warn("Gagal membuat symlink. Fallback route Laravel tetap aktif menangani file.");
            }
        } else {
            $this->info("Folder storage fisik sudah ada di direktori public.");
        }

        $this->info('Selesai! Seluruh file media siap diakses di web hosting.');
        return Command::SUCCESS;
    }
}
