<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\MenuSettingController;
use App\Http\Controllers\Dashboard\PartnerController;
use App\Http\Controllers\Dashboard\AppearanceController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Dashboard\NewsController;
use App\Http\Controllers\Dashboard\GalleryController;
use App\Http\Controllers\Dashboard\AchievementController;
use App\Http\Controllers\Dashboard\PeerEvaluationAdminController;
use App\Http\Controllers\Dashboard\PeerEvaluationMemberController;
use App\Http\Controllers\Dashboard\ProfileSettingController;
use App\Http\Controllers\Dashboard\CompleteProfileController;
use App\Http\Controllers\Dashboard\OrganizationStructureController;
use App\Http\Controllers\Dashboard\WorkProgramController;
use App\Http\Controllers\Dashboard\PeerEducationController;
use App\Http\Controllers\Dashboard\ReportController;
use App\Http\Controllers\Dashboard\MediaOptimizerController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PushSubscriptionController;
use App\Http\Controllers\Dashboard\NotificationAdminController;

use App\Models\Partner;
use App\Models\News;
use App\Models\Gallery;
use App\Models\Achievement;

Route::get('/', function (\App\Services\OrganizationStructureService $structureService, \App\Services\TributeService $tributeService) {
    $partners = Partner::all();
    $newsList = (new \App\Services\NewsService())->getLatestNews(4);
    $galleryList = (new \App\Services\GalleryService())->getAllGallery();
    $achievementList = (new \App\Services\AchievementService())->getLatestAchievements(3);
    $activities = \App\Models\Activity::with('creator')->orderBy('event_date', 'asc')->get();
    $structures = $structureService->getAllStructures();
    $structureSettings = $structureService->getSettings();
    $tributeEditions = $tributeService->getAllEditions(true);
    $featuredTribute = $tributeService->getFeaturedEdition();
    return view('welcome', compact('partners', 'newsList', 'galleryList', 'achievementList', 'activities', 'structures', 'structureSettings', 'tributeEditions', 'featuredTribute'));
});

Route::get('/profil/visi-misi', function (\App\Services\ProfileService $profileService) {
    $settings = $profileService->getProfileSetting();
    return view('pages.visi-misi', compact('settings'));
})->name('visi-misi');

Route::get('/profil/struktur', function (\App\Services\OrganizationStructureService $structureService) {
    $pengurus = $structureService->getAllStructures();
    $settings = $structureService->getSettings();
    return view('pages.struktur', compact('pengurus', 'settings'));
})->name('struktur');

Route::get('/profil/sejarah', function (\App\Services\ProfileService $profileService) {
    $settings = $profileService->getProfileSetting();
    $milestones = $profileService->getAllMilestones();
    return view('pages.sejarah', compact('settings', 'milestones'));
})->name('sejarah');

Route::get('/profil/jejak-bakti', function (\Illuminate\Http\Request $request, \App\Services\TributeService $tributeService) {
    $editions = $tributeService->getAllEditions(true);
    $selectedPeriod = $request->query('periode');
    
    if ($selectedPeriod) {
        $activeEdition = $editions->firstWhere('period', $selectedPeriod) ?? $editions->first();
    } else {
        $activeEdition = $editions->firstWhere('is_featured', true) ?? $editions->first();
    }

    return view('pages.jejak-bakti', compact('editions', 'activeEdition'));
})->name('jejak-bakti');

Route::post('/api/tributes/appreciate', function (\Illuminate\Http\Request $request, \App\Services\TributeService $tributeService) {
    $editionId = $request->input('edition_id');
    $count = $tributeService->incrementAppreciation($editionId);
    return response()->json(['success' => true, 'count' => $count]);
})->name('tributes.appreciate');

Route::get('/kegiatan', function () {
    $activities = \App\Models\Activity::with('creator')->latest('event_date')->paginate(3);
    $heroSettings = \App\Http\Controllers\Dashboard\ActivityController::getSettings();
    return view('pages.kegiatan', compact('activities', 'heroSettings'));
})->name('kegiatan');

Route::get('/kegiatan/{slug}', function ($slug) {
    $activity = \App\Models\Activity::with('creator')->where('slug', $slug)->firstOrFail();
    $relatedActivities = \App\Models\Activity::where('id', '!=', $activity->id)->latest('event_date')->take(3)->get();
    return view('pages.kegiatan-detail', compact('activity', 'relatedActivities'));
})->name('kegiatan.show');

Route::get('/pendidikan/proker', function (\App\Services\WorkProgramService $workProgramService) {
    $prokers = $workProgramService->getAllWorkPrograms();
    return view('pages.proker', compact('prokers'));
})->name('proker');

Route::get('/pendidikan/edukasi-sebaya', function (\App\Services\PeerEducationService $peerEducationService) {
    $edukasi = $peerEducationService->getAllItems();
    return view('pages.edukasi-sebaya', compact('edukasi'));
})->name('edukasi');

Route::get('/pendidikan/konseling', function () {
    $heroSettings = \App\Http\Controllers\Dashboard\CounselingController::getSettings();
    $counselors = \App\Models\Counselor::orderBy('order_index', 'asc')->latest()->get();
    return view('pages.konseling', compact('heroSettings', 'counselors'));
})->name('konseling');

Route::post('/pendidikan/konseling', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'title' => 'required|string|max:255',
        'topic' => 'required|string|max:255',
        'student_class' => 'nullable|string|max:255',
        'counselor_name' => 'nullable|string|max:255',
        'date' => 'nullable|date',
        'description' => 'nullable|string',
    ]);

    \App\Models\Counseling::create([
        'title' => $request->title,
        'topic' => $request->topic,
        'student_class' => $request->student_class,
        'counselor_name' => $request->counselor_name ?: 'Konselor Sebaya PIK-R',
        'date' => $request->date ?: now(),
        'description' => $request->description,
        'status' => 'Pending',
    ]);

    return redirect()->route('konseling')->with('success', 'Permohonan Layanan Konseling berhasil dikirim! Tim Konselor PIK-R REQUEST akan segera menghubungi kamu.');
})->name('konseling.store');

Route::get('/transparansi/laporan', function (\App\Services\ReportService $reportService) {
    $laporan = $reportService->getPaginatedItems(3);
    return view('pages.laporan', compact('laporan'));
})->name('laporan');

Route::get('/transparansi/statistik', function (\App\Services\StatisticService $statisticService) {
    $settings = $statisticService->getSettings();
    return view('pages.statistik', compact('settings'));
})->name('statistik');

Route::get('/profil/prestasi', function (\App\Services\AchievementService $achievementService) {
    $settings = $achievementService->getSettings();
    $prestasiList = $achievementService->getPaginatedAchievements(6);
    return view('pages.prestasi', compact('prestasiList', 'settings'));
})->name('prestasi');

Route::get('/profil/prestasi/{id}', function ($id, \App\Services\AchievementService $achievementService) {
    $achievement = $achievementService->getAchievementById($id);
    $relatedAchievements = \App\Models\Achievement::with('images')
        ->where('id', '!=', $id)
        ->orderBy('date', 'desc')
        ->take(3)
        ->get();
    return view('pages.prestasi-detail', compact('achievement', 'relatedAchievements'));
})->name('prestasi.show');

Route::get('/profil/lengkap', function (\App\Services\CompleteProfileService $profileService) {
    $settings = $profileService->getSettings();
    return view('pages.profil-lengkap', compact('settings'));
})->name('profil-lengkap');

Route::get('/faq', function () {
    return view('pages.faq');
})->name('faq');

Route::get('/berita', function () {
    return redirect()->route('news.index');
});

Route::get('/berita/{slug}', function ($slug) {
    $newsService = new \App\Services\NewsService();
    $news = $newsService->getNewsBySlug($slug);
    $recentNews = $newsService->getLatestNews(5);
    return view('pages.berita.detail', compact('news', 'recentNews'));
})->name('news.show');

Route::get('/semua-berita', function () {
    $newsList = (new \App\Services\NewsService())->getPaginatedNews(9);
    return view('pages.berita.index', compact('newsList'));
})->name('news.index');

Route::get('/galeri', function () {
    $galleryList = (new \App\Services\GalleryService())->getPaginatedGallery(12);
    return view('pages.gallery.index', compact('galleryList'));
})->name('gallery.index');

// Public Notification Center & Web Push API Routes
Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifications.index');
Route::get('/notifikasi/{id}/baca', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::post('/notifikasi/tandai-semua', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');

Route::get('/api/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('api.notifications.unread-count');
Route::get('/api/notifications/recent', [NotificationController::class, 'getRecent'])->name('api.notifications.recent');
Route::post('/api/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('api.notifications.mark-all-read');

Route::get('/api/push-subscriptions/vapid-public-key', [PushSubscriptionController::class, 'vapidPublicKey'])->name('api.push-subscriptions.key');
Route::post('/api/push-subscriptions', [PushSubscriptionController::class, 'store'])->name('api.push-subscriptions.store');
Route::post('/api/push-subscriptions/unsubscribe', [PushSubscriptionController::class, 'destroy'])->name('api.push-subscriptions.destroy');

// Public Pendaftaran (Member Application)
Route::get('/daftar', [RegistrationController::class, 'showForm'])->name('register');
Route::post('/daftar', [RegistrationController::class, 'store'])->name('register.post');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('throttle:20,1');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'force_password', 'role:super_admin,pembina,ketua,anggota']);

Route::middleware(['auth', 'force_password'])->prefix('dashboard')->name('dashboard.')->group(function () {
    // Password Change Routes
    Route::get('/change-password', [UserController::class, 'showChangePassword'])->name('password.index');
    Route::post('/change-password', [UserController::class, 'updatePassword'])->name('password.update');

    // Partner Management
    Route::get('/partners', [PartnerController::class, 'index'])->name('partners.index');
    Route::post('/partners', [PartnerController::class, 'store'])->name('partners.store');
    Route::put('/partners/{partner}', [PartnerController::class, 'update'])->name('partners.update');
    Route::delete('/partners/{partner}', [PartnerController::class, 'destroy'])->name('partners.destroy');

    // News Management
    Route::resource('/news', NewsController::class);

    // Gallery Management
    Route::resource('/gallery', GalleryController::class);

    // Achievements Management
    Route::get('/achievements/settings', [AchievementController::class, 'settings'])->name('achievements.settings');
    Route::post('/achievements/settings', [AchievementController::class, 'updateSettings'])->name('achievements.settings.update');
    Route::delete('/achievements/{achievement}/photos/{photo}', [AchievementController::class, 'deletePhoto'])->name('achievements.photos.destroy');
    Route::resource('/achievements', AchievementController::class);

    // Complete Profile Configuration
    Route::get('/complete-profile', [CompleteProfileController::class, 'index'])->name('complete-profile.index');
    Route::post('/complete-profile', [CompleteProfileController::class, 'update'])->name('complete-profile.update');

    // Work Programs Management
    Route::get('/work-programs/settings', [WorkProgramController::class, 'settings'])->name('work-programs.settings');
    Route::post('/work-programs/settings', [WorkProgramController::class, 'updateSettings'])->name('work-programs.settings.update');
    Route::resource('/work-programs', WorkProgramController::class)->except(['show']);

    // Peer Educations Management
    Route::get('/peer-educations/settings', [PeerEducationController::class, 'settings'])->name('peer-educations.settings');
    Route::post('/peer-educations/settings', [PeerEducationController::class, 'updateSettings'])->name('peer-educations.settings.update');
    Route::resource('/peer-educations', PeerEducationController::class)->except(['show']);

    // Reports Management
    Route::get('/reports/settings', [ReportController::class, 'settings'])->name('reports.settings');
    Route::post('/reports/settings', [ReportController::class, 'updateSettings'])->name('reports.settings.update');
    Route::resource('/reports', ReportController::class)->except(['show']);

    // Layanan Konseling & Tim Konselor
    Route::get('/counselings/settings', [\App\Http\Controllers\Dashboard\CounselingController::class, 'settings'])->name('counselings.settings');
    Route::post('/counselings/settings', [\App\Http\Controllers\Dashboard\CounselingController::class, 'updateSettings'])->name('counselings.settings.update');
    Route::resource('/counselings', \App\Http\Controllers\Dashboard\CounselingController::class)->names('counselings');
    Route::resource('/counselors', \App\Http\Controllers\Dashboard\CounselorController::class);

    // Activities / Agenda Kegiatan Management
    Route::get('/activities/settings', [\App\Http\Controllers\Dashboard\ActivityController::class, 'settings'])->name('activities.settings');
    Route::post('/activities/settings', [\App\Http\Controllers\Dashboard\ActivityController::class, 'updateSettings'])->name('activities.settings.update');
    Route::resource('/activities', \App\Http\Controllers\Dashboard\ActivityController::class);

    // Statistics Management
    Route::get('/statistics/settings', [\App\Http\Controllers\Dashboard\StatisticController::class, 'settings'])->name('statistics.settings');
    Route::post('/statistics/settings', [\App\Http\Controllers\Dashboard\StatisticController::class, 'updateSettings'])->name('statistics.settings.update');

    // Peer Evaluation Member
    Route::get('/peer-evaluation', [PeerEvaluationMemberController::class, 'index'])->name('peer-evaluation.index');
    Route::get('/peer-evaluation/evaluate/{peerId}', [PeerEvaluationMemberController::class, 'evaluate'])->name('peer-evaluation.evaluate');
    Route::post('/peer-evaluation/evaluate/{peerId}', [PeerEvaluationMemberController::class, 'submit'])->name('peer-evaluation.submit');

    // Jejak Bakti & Apresiasi Duta GenRe (Multi-Edition / Generasi)
    Route::get('/tributes', [\App\Http\Controllers\Dashboard\TributeController::class, 'index'])->name('tributes.index');
    Route::post('/tributes/editions', [\App\Http\Controllers\Dashboard\TributeController::class, 'storeEdition'])->name('tributes.editions.store');
    Route::put('/tributes/editions/{id}', [\App\Http\Controllers\Dashboard\TributeController::class, 'updateEdition'])->name('tributes.editions.update');
    Route::post('/tributes/editions/{id}/feature', [\App\Http\Controllers\Dashboard\TributeController::class, 'setFeatured'])->name('tributes.editions.feature');
    Route::delete('/tributes/editions/{id}', [\App\Http\Controllers\Dashboard\TributeController::class, 'destroyEdition'])->name('tributes.editions.destroy');
    Route::post('/tributes/figures', [\App\Http\Controllers\Dashboard\TributeController::class, 'storeFigure'])->name('tributes.figures.store');
    Route::put('/tributes/figures/{id}', [\App\Http\Controllers\Dashboard\TributeController::class, 'updateFigure'])->name('tributes.figures.update');
    Route::delete('/tributes/figures/{id}', [\App\Http\Controllers\Dashboard\TributeController::class, 'destroyFigure'])->name('tributes.figures.destroy');
    Route::post('/tributes/memories', [\App\Http\Controllers\Dashboard\TributeController::class, 'storeMemory'])->name('tributes.memories.store');
    Route::delete('/tributes/memories/{id}', [\App\Http\Controllers\Dashboard\TributeController::class, 'destroyMemory'])->name('tributes.memories.destroy');

    // Pusat Notifikasi & Broadcast Web Push
    Route::get('/notifications', [NotificationAdminController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/send', [NotificationAdminController::class, 'sendManual'])->name('notifications.send');
    Route::post('/notifications/quick-send', [NotificationAdminController::class, 'quickSend'])->name('notifications.quick-send');
    Route::post('/notifications/batch-send', [NotificationAdminController::class, 'batchSend'])->name('notifications.batch-send');
    Route::delete('/notifications/{notification}', [NotificationAdminController::class, 'destroy'])->name('notifications.destroy');
});

Route::middleware(['auth', 'role:super_admin'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/menu-settings', [MenuSettingController::class, 'index'])->name('menu-settings.index');
    Route::put('/menu-settings', [MenuSettingController::class, 'update'])->name('menu-settings.update');
    
    // User Management
    Route::get('/users', function() {
        return redirect()->route('dashboard.users.pembina');
    });
    Route::get('/users/pembina', [UserController::class, 'pembinaIndex'])->name('users.pembina');
    Route::get('/users/ketua', [UserController::class, 'ketuaIndex'])->name('users.ketua');
    Route::get('/users/anggota', [UserController::class, 'anggotaIndex'])->name('users.anggota');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Registrations Management
    Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::post('/registrations/{registration}/approve', [RegistrationController::class, 'approve'])->name('registrations.approve');
    Route::post('/registrations/{registration}/reject', [RegistrationController::class, 'reject'])->name('registrations.reject');

    // Appearance
    Route::get('/appearance', [AppearanceController::class, 'index'])->name('appearance.index');
    Route::post('/appearance', [AppearanceController::class, 'update'])->name('appearance.update');

    // Media & Storage Optimizer
    Route::get('/media-optimizer', [MediaOptimizerController::class, 'index'])->name('media-optimizer.index');
    Route::post('/media-optimizer/simulate', [MediaOptimizerController::class, 'simulate'])->name('media-optimizer.simulate');
    Route::post('/media-optimizer/batch', [MediaOptimizerController::class, 'batchOptimize'])->name('media-optimizer.batch');
    Route::post('/media-optimizer/sync-cpanel', [MediaOptimizerController::class, 'syncCpanelStorage'])->name('media-optimizer.sync-cpanel');

    // Peer Evaluation Admin Configuration
    Route::get('/peer-evaluation/config', [PeerEvaluationAdminController::class, 'index'])->name('peer-evaluation.config');
    Route::post('/peer-evaluation/schedules', [PeerEvaluationAdminController::class, 'storeSchedule'])->name('peer-evaluation.schedules.store');
    Route::post('/peer-evaluation/schedules/{id}/toggle', [PeerEvaluationAdminController::class, 'toggleScheduleActive'])->name('peer-evaluation.schedules.toggle');
    Route::delete('/peer-evaluation/schedules/{id}', [PeerEvaluationAdminController::class, 'destroySchedule'])->name('peer-evaluation.schedules.destroy');
    
    Route::post('/peer-evaluation/questions', [PeerEvaluationAdminController::class, 'storeQuestion'])->name('peer-evaluation.questions.store');
    Route::put('/peer-evaluation/questions/{id}', [PeerEvaluationAdminController::class, 'updateQuestion'])->name('peer-evaluation.questions.update');
    Route::delete('/peer-evaluation/questions/{id}', [PeerEvaluationAdminController::class, 'destroyQuestion'])->name('peer-evaluation.questions.destroy');

    Route::get('/peer-evaluation/results', [PeerEvaluationAdminController::class, 'results'])->name('peer-evaluation.results');
    Route::get('/peer-evaluation/results/{memberId}', [PeerEvaluationAdminController::class, 'resultsDetail'])->name('peer-evaluation.results.detail');

    // Profile Settings, Struktur & Sejarah Management
    Route::get('/profile-settings', [ProfileSettingController::class, 'index'])->name('profile-settings.index');
    Route::post('/profile-settings', [ProfileSettingController::class, 'update'])->name('profile-settings.update');
    Route::post('/profile-settings/milestones', [ProfileSettingController::class, 'storeMilestone'])->name('profile-settings.milestones.store');
    Route::put('/profile-settings/milestones/{id}', [ProfileSettingController::class, 'updateMilestone'])->name('profile-settings.milestones.update');
    Route::delete('/profile-settings/milestones/{id}', [ProfileSettingController::class, 'destroyMilestone'])->name('profile-settings.milestones.destroy');

    Route::post('/organization-structures/settings', [OrganizationStructureController::class, 'updateSettings'])->name('organization-structures.settings.update');
    Route::resource('/organization-structures', OrganizationStructureController::class)->except(['create', 'show', 'edit']);

    // Activity Logs
    Route::get('/activity-logs', [\App\Http\Controllers\Dashboard\ActivityLogController::class, 'index'])->name('activity-logs.index');
});

/*
|--------------------------------------------------------------------------
| Media Fallback Routes (Anti-Broken Images for cPanel & Shared Hosting)
|--------------------------------------------------------------------------
| When web server rewrite triggers because a static file is not directly found
| in public_html, these routes search candidate locations (project public & storage),
| auto-synchronize to public_html, and stream the file with caching headers.
*/
Route::get('/uploads/{path}', function (string $path) {
    $cleanPath = str_replace(['../', '..\\'], '', $path);

    // Candidate 1: Current public_path (e.g. public_html/uploads/...)
    $file1 = public_path('uploads/' . $cleanPath);
    if (file_exists($file1) && is_file($file1)) {
        return response()->file($file1, [
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ]);
    }

    // Candidate 2: Project public uploads (e.g. websitepik_v2/public/uploads/...)
    $file2 = base_path('public/uploads/' . $cleanPath);
    if (file_exists($file2) && is_file($file2)) {
        // Auto-copy to public_path so Apache/LiteSpeed serves it statically on next hits
        try {
            $destDir = dirname($file1);
            if (!is_dir($destDir)) {
                @mkdir($destDir, 0755, true);
            }
            @copy($file2, $file1);
        } catch (\Throwable $e) {}

        return response()->file($file2, [
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ]);
    }

    // Candidate 3: storage/app/public/uploads/...
    $file3 = storage_path('app/public/uploads/' . $cleanPath);
    if (file_exists($file3) && is_file($file3)) {
        return response()->file($file3, [
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ]);
    }

    abort(404);
})->where('path', '.*')->name('media.uploads');

Route::get('/storage/{path}', function (string $path) {
    $cleanPath = str_replace(['../', '..\\'], '', $path);

    // Candidate 1: storage_path('app/public/...')
    $file1 = storage_path('app/public/' . $cleanPath);
    if (file_exists($file1) && is_file($file1)) {
        return response()->file($file1, [
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ]);
    }

    // Candidate 2: public_path('storage/...')
    $file2 = public_path('storage/' . $cleanPath);
    if (file_exists($file2) && is_file($file2)) {
        return response()->file($file2, [
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ]);
    }

    // Candidate 3: base_path('public/storage/...')
    $file3 = base_path('public/storage/' . $cleanPath);
    if (file_exists($file3) && is_file($file3)) {
        return response()->file($file3, [
            'Cache-Control' => 'public, max-age=31536000, immutable',
        ]);
    }

    abort(404);
})->where('path', '.*')->name('media.storage');

// Preview Maintenance Page
Route::get('/preview-maintenance', function () {
    return response()->view('errors.503', [], 503);
})->name('preview.maintenance');
