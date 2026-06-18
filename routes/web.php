<?php

use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\AuthController;
use App\Http\Controllers\Public\DipController;
use App\Http\Controllers\Public\DirektoriController;
use App\Http\Controllers\Public\ProfilController;
use App\Http\Controllers\Public\StandarLayananController;
use App\Http\Controllers\Public\InfografisController as PublicInfografisController;
use App\Http\Controllers\Dashboard\Pembantu\DashboardController;
use App\Http\Controllers\Dashboard\Pembantu\DocumentController;
use App\Http\Controllers\Dashboard\Pembantu\CmsProfilOpdController;
use App\Http\Controllers\Dashboard\Pembantu\AgendaController;
use App\Http\Controllers\Dashboard\Pembantu\InfografisController;
use App\Http\Controllers\Dashboard\Pembantu\OpdServiceController;
use App\Http\Controllers\Dashboard\Pembantu\GaleriController;
use App\Http\Controllers\Dashboard\Utama\MonitoringController;
use App\Http\Controllers\Dashboard\Utama\CmsNewsController;
use App\Http\Controllers\Dashboard\Utama\HeroSlideController;
use App\Http\Controllers\Dashboard\Utama\LaporanController;
use App\Http\Controllers\Dashboard\Utama\DocumentManagementController;
use App\Http\Controllers\Dashboard\Utama\PublicServiceController;
use App\Http\Controllers\Dashboard\Pimpinan\PimpinanDashboardController;
use App\Http\Controllers\Dashboard\Pimpinan\PimpinanDocumentController;
use App\Http\Controllers\Dashboard\Pimpinan\PimpinanLaporanController;
use App\Http\Controllers\Admin\OpdController;
use App\Http\Controllers\Admin\VillageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\AuditLogController;
use Illuminate\Support\Facades\Route;

// ============================================================================
// PUBLIC ROUTES
// ============================================================================
Route::get('/', [HomeController::class, 'index'])->name('home');

// Profil PPID
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::get('/profil/{section}', [ProfilController::class, 'show'])->name('profil.show');

// Standar Layanan
Route::get('/standar-layanan', [StandarLayananController::class, 'index'])->name('standar-layanan.index');
Route::get('/standar-layanan/{slug}', [StandarLayananController::class, 'show'])->name('standar-layanan.show');

// DIP (Daftar Informasi Publik)
Route::prefix('dip')->group(function () {
    Route::get('/', [DipController::class, 'index'])->name('dip.index');
    Route::get('/category/{slug}', [DipController::class, 'byCategory'])->name('dip.category');
    Route::get('/preview/{document}', [DipController::class, 'preview'])->name('dip.preview');
    Route::get('/download/{document}', [DipController::class, 'download'])
        ->middleware('auth')->name('dip.download');
});

// Infografis, Galeri, Agenda (Public)
Route::get('/infografis', [PublicInfografisController::class, 'index'])->name('infografis.index');
Route::get('/galeri', [\App\Http\Controllers\Public\GaleriController::class, 'index'])->name('galeri.index');
Route::get('/agenda', [\App\Http\Controllers\Public\AgendaController::class, 'index'])->name('agenda.index');
Route::get('/agenda/filter/{status}', [\App\Http\Controllers\Public\AgendaController::class, 'filter'])->name('agenda.filter');

// Direktori
Route::prefix('direktori')->group(function () {
    Route::get('/opd', [DirektoriController::class, 'opdIndex'])->name('direktori.opd');
    Route::get('/opd/{opd}', [DirektoriController::class, 'opdShow'])->name('direktori.opd.show');
    Route::get('/desa', [DirektoriController::class, 'desaIndex'])->name('direktori.desa');
});

// ============================================================================
// AUTH ROUTES
// ============================================================================
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout')->name('logout');
});

// ============================================================================
// PROFILE ROUTES (Authenticated)
// ============================================================================
Route::middleware('auth')->prefix('profile')->controller(\App\Http\Controllers\ProfileController::class)->group(function () {
    Route::get('/', 'index')->name('profile.index');
    Route::put('/', 'update')->name('profile.update');
    Route::get('/password', 'passwordForm')->name('profile.password');
    Route::put('/password', 'updatePassword')->name('profile.password.update');
});

// ============================================================================
// DASHBOARD ROUTES
// ============================================================================
Route::prefix('dashboard')->middleware('auth')->group(function () {

    // ========================================================================
    // PPID PEMBANTU (role: ppid_pembantu)
    // ========================================================================
    Route::prefix('pembantu')->middleware('role:ppid_pembantu')->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.pembantu');

        // Dokumen DIP (CRUD)
        Route::resource('documents', DocumentController::class)->except(['show']);
        Route::patch('documents/{document}/status', [DocumentController::class, 'updateStatus'])
            ->name('documents.status');

        // CMS
        Route::prefix('cms')->group(function () {

            // CMS Profil OPD (menggunakan method dengan konfigurasi array)
            Route::prefix('profil')->controller(CmsProfilOpdController::class)->group(function () {
                Route::get('/', 'index')->name('pembantu.cms.profil.index');

                // Tentang OPD
                Route::get('/tentang', 'editTentang')->name('pembantu.cms.profil.tentang');
                Route::put('/tentang', 'updateTentang')->name('pembantu.cms.profil.update-tentang');

                // Tugas Fungsi (menggunakan method baru editSection/updateSection)
                Route::get('/tugas-fungsi', 'editSection')->name('pembantu.cms.profil.tugas-fungsi');
                Route::put('/tugas-fungsi', 'updateSection')->name('pembantu.cms.profil.update-tugas-fungsi');

                // Struktur (menggunakan method baru editSection/updateSection)
                Route::get('/struktur', 'editSection')->name('pembantu.cms.profil.struktur');
                Route::put('/struktur', 'updateSection')->name('pembantu.cms.profil.update-struktur');

                // Dasar Hukum (menggunakan method baru editSection/updateSection)
                Route::get('/dasar-hukum', 'editSection')->name('pembantu.cms.profil.dasar-hukum');
                Route::put('/dasar-hukum', 'updateSection')->name('pembantu.cms.profil.update-dasar-hukum');

                // Media Sosial
                Route::get('/media-sosial', 'editMediaSosial')->name('pembantu.cms.profil.media-sosial');
                Route::put('/media-sosial', 'updateMediaSosial')->name('pembantu.cms.profil.update-media-sosial');
            });

            // CMS Agenda
            Route::prefix('agenda')->controller(AgendaController::class)->group(function () {
                Route::get('/', 'index')->name('pembantu.cms.agenda.index');
                Route::get('/create', 'create')->name('pembantu.cms.agenda.create');
                Route::post('/', 'store')->name('pembantu.cms.agenda.store');
                Route::get('/{id}/edit', 'edit')->name('pembantu.cms.agenda.edit');
                Route::put('/{id}', 'update')->name('pembantu.cms.agenda.update');
                Route::delete('/{id}', 'destroy')->name('pembantu.cms.agenda.destroy');
                Route::patch('/{id}/toggle', 'togglePublished')->name('pembantu.cms.agenda.toggle');
            });

            // CMS Galeri
            Route::prefix('gallery')->controller(GaleriController::class)->group(function () {
                Route::get('/', 'index')->name('pembantu.cms.gallery.index');
                Route::get('/create', 'create')->name('pembantu.cms.gallery.create');
                Route::post('/', 'store')->name('pembantu.cms.gallery.store');
                Route::get('/{id}/edit', 'edit')->name('pembantu.cms.gallery.edit');
                Route::put('/{id}', 'update')->name('pembantu.cms.gallery.update');
                Route::delete('/{id}', 'destroy')->name('pembantu.cms.gallery.destroy');
                Route::patch('/{id}/toggle', 'togglePublished')->name('pembantu.cms.gallery.toggle');
            });

            // CMS Infografis
            Route::prefix('infographic')->controller(InfografisController::class)->group(function () {
                Route::get('/', 'index')->name('pembantu.cms.infographic.index');
                Route::get('/create', 'create')->name('pembantu.cms.infographic.create');
                Route::post('/', 'store')->name('pembantu.cms.infographic.store');
                Route::get('/{id}/edit', 'edit')->name('pembantu.cms.infographic.edit');
                Route::put('/{id}', 'update')->name('pembantu.cms.infographic.update');
                Route::delete('/{id}', 'destroy')->name('pembantu.cms.infographic.destroy');
                Route::patch('/{id}/toggle', 'togglePublished')->name('pembantu.cms.infographic.toggle');
            });

            // Layanan Publik (OPD sendiri)
            Route::prefix('services')->controller(OpdServiceController::class)->group(function () {
                Route::get('/', 'index')->name('pembantu.cms.services.index');
                Route::get('/create', 'create')->name('pembantu.cms.services.create');
                Route::post('/', 'store')->name('pembantu.cms.services.store');
                Route::get('/{service}/edit', 'edit')->name('pembantu.cms.services.edit');
                Route::put('/{service}', 'update')->name('pembantu.cms.services.update');
                Route::delete('/{service}', 'destroy')->name('pembantu.cms.services.destroy');
                Route::patch('/{service}/toggle', 'toggleActive')->name('pembantu.cms.services.toggle');
            });
        });
    });

    // ========================================================================
    // PPID UTAMA & SUPER ADMIN (role: super_admin|ppid_utama)
    // ========================================================================
    Route::prefix('utama')->middleware('role:super_admin|ppid_utama')->group(function () {

        // Dashboard Monitoring
        Route::get('/', [MonitoringController::class, 'index'])->name('dashboard.utama');

        // Manajemen Dokumen Global (all OPD)
        Route::prefix('documents')->controller(DocumentManagementController::class)->group(function () {
            Route::get('/', 'index')->name('utama.documents.index');
            Route::get('/{document}/edit', 'edit')->name('utama.documents.edit');
            Route::put('/{document}', 'update')->name('utama.documents.update');
            Route::delete('/{document}', 'destroy')->name('utama.documents.destroy');
            Route::patch('/{document}/force-unpublish', 'forceUnpublish')->name('utama.documents.force-unpublish');
        });

        // Laporan Statistik
        Route::prefix('laporan')->controller(LaporanController::class)->group(function () {
            Route::get('/', 'index')->name('utama.laporan.index');
            Route::post('/generate', 'generate')->name('utama.laporan.generate');
        });

        // CMS Global
        Route::prefix('cms')->group(function () {

            // Agenda (all OPD)
            Route::prefix('agenda')->controller(CmsNewsController::class)->group(function () {
                Route::get('/', 'agendaIndex')->name('utama.cms.agenda.index');
                Route::get('/create', 'agendaCreate')->name('utama.cms.agenda.create');
                Route::post('/', 'agendaStore')->name('utama.cms.agenda.store');
                Route::get('/{news}/edit', 'agendaEdit')->name('utama.cms.agenda.edit');
                Route::put('/{news}', 'agendaUpdate')->name('utama.cms.agenda.update');
                Route::delete('/{news}', 'agendaDestroy')->name('utama.cms.agenda.destroy');
            });

            // Galeri (all OPD)
            Route::prefix('gallery')->controller(CmsNewsController::class)->group(function () {
                Route::get('/', 'galleryIndex')->name('utama.cms.gallery.index');
                Route::get('/create', 'galleryCreate')->name('utama.cms.gallery.create');
                Route::post('/', 'galleryStore')->name('utama.cms.gallery.store');
                Route::get('/{news}/edit', 'galleryEdit')->name('utama.cms.gallery.edit');
                Route::put('/{news}', 'galleryUpdate')->name('utama.cms.gallery.update');
                Route::delete('/{news}', 'galleryDestroy')->name('utama.cms.gallery.destroy');
            });

            // Infografis (all OPD)
            Route::prefix('infographic')->controller(CmsNewsController::class)->group(function () {
                Route::get('/', 'infographicIndex')->name('utama.cms.infographic.index');
                Route::get('/create', 'infographicCreate')->name('utama.cms.infographic.create');
                Route::post('/', 'infographicStore')->name('utama.cms.infographic.store');
                Route::get('/{news}/edit', 'infographicEdit')->name('utama.cms.infographic.edit');
                Route::put('/{news}', 'infographicUpdate')->name('utama.cms.infographic.update');
                Route::delete('/{news}', 'infographicDestroy')->name('utama.cms.infographic.destroy');
            });

            // Hero Slider
            Route::prefix('hero')->controller(HeroSlideController::class)->group(function () {
                Route::get('/', 'index')->name('utama.cms.hero.index');
                Route::get('/create', 'create')->name('utama.cms.hero.create');
                Route::post('/', 'store')->name('utama.cms.hero.store');
                Route::get('/{heroSlide}/edit', 'edit')->name('utama.cms.hero.edit');
                Route::put('/{heroSlide}', 'update')->name('utama.cms.hero.update');
                Route::delete('/{heroSlide}', 'destroy')->name('utama.cms.hero.destroy');
                Route::patch('/{heroSlide}/toggle', 'toggleActive')->name('utama.cms.hero.toggle');
                Route::post('/update-order', 'updateOrder')->name('utama.cms.hero.update-order');
            });

            // CMS Profil PPID
            Route::prefix('profil')->controller(CmsNewsController::class)->group(function () {
                Route::get('/', 'profilIndex')->name('utama.cms.profil.index');
                Route::get('/{pageKey}/edit', 'profilEdit')->name('utama.cms.profil.edit');
                Route::put('/{pageKey}', 'profilUpdate')->name('utama.cms.profil.update');
            });

            // CMS Standar Layanan
            Route::prefix('standar')->controller(CmsNewsController::class)->group(function () {
                Route::get('/', 'standarIndex')->name('utama.cms.standar.index');
                Route::get('/{pageKey}/edit', 'standarEdit')->name('utama.cms.standar.edit');
                Route::put('/{pageKey}', 'standarUpdate')->name('utama.cms.standar.update');
            });

            // Layanan Publik (all OPD)
            Route::prefix('public-services')->controller(PublicServiceController::class)->group(function () {
                Route::get('/', 'index')->name('utama.cms.public-services.index');
                Route::get('/create', 'create')->name('utama.cms.public-services.create');
                Route::post('/', 'store')->name('utama.cms.public-services.store');
                Route::get('/{id}/edit', 'edit')->name('utama.cms.public-services.edit');
                Route::put('/{id}', 'update')->name('utama.cms.public-services.update');
                Route::delete('/{id}', 'destroy')->name('utama.cms.public-services.destroy');
                Route::patch('/{id}/toggle', 'toggleActive')->name('utama.cms.public-services.toggle');
            });
        });
    });

    // ========================================================================
    // SUPER ADMIN (role: super_admin)
    // ========================================================================
    Route::prefix('admin')->middleware('role:super_admin')->group(function () {

        // Manajemen OPD
        Route::resource('opds', OpdController::class)->names([
            'index' => 'admin.opds.index',
            'create' => 'admin.opds.create',
            'store' => 'admin.opds.store',
            'show' => 'admin.opds.show',
            'edit' => 'admin.opds.edit',
            'update' => 'admin.opds.update',
            'destroy' => 'admin.opds.destroy',
        ]);

        // Manajemen Desa
        Route::resource('villages', VillageController::class)->names([
            'index' => 'admin.villages.index',
            'create' => 'admin.villages.create',
            'store' => 'admin.villages.store',
            'show' => 'admin.villages.show',
            'edit' => 'admin.villages.edit',
            'update' => 'admin.villages.update',
            'destroy' => 'admin.villages.destroy',
        ]);

        // Master Kategori
        Route::resource('categories', CategoryController::class)->names([
            'index' => 'admin.categories.index',
            'create' => 'admin.categories.create',
            'store' => 'admin.categories.store',
            'show' => 'admin.categories.show',
            'edit' => 'admin.categories.edit',
            'update' => 'admin.categories.update',
            'destroy' => 'admin.categories.destroy',
        ]);

        // Sub Kategori
        Route::get('categories/{category}/subcategories', [CategoryController::class, 'subCategories'])
            ->name('admin.categories.subcategories');
        Route::post('categories/{category}/subcategories', [CategoryController::class, 'storeSubCategory'])
            ->name('admin.categories.subcategories.store');
        Route::get('subcategories/{subCategory}/edit', [CategoryController::class, 'editSubCategory'])
            ->name('admin.subcategories.edit');
        Route::put('subcategories/{subCategory}', [CategoryController::class, 'updateSubCategory'])
            ->name('admin.subcategories.update');
        Route::delete('subcategories/{subCategory}', [CategoryController::class, 'destroySubCategory'])
            ->name('admin.subcategories.destroy');

        // Manajemen User
        Route::resource('users', UserManagementController::class)->names([
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'show' => 'admin.users.show',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]);

        // Audit Log
        Route::get('audit-logs', [AuditLogController::class, 'index'])->name('admin.audit-logs');
    });

    // ========================================================================
    // PIMPINAN OPD (role: pimpinan) - Read Only
    // ========================================================================
    Route::prefix('pimpinan')->middleware('role:pimpinan')->group(function () {

        Route::get('/', [PimpinanDashboardController::class, 'index'])->name('pimpinan.dashboard');

        Route::prefix('documents')->controller(PimpinanDocumentController::class)->group(function () {
            Route::get('/', 'index')->name('pimpinan.documents.index');
            Route::get('/{document}', 'show')->name('pimpinan.documents.show');
            Route::get('/{document}/preview', 'preview')->name('pimpinan.documents.preview');
        });

        Route::prefix('laporan')->controller(PimpinanLaporanController::class)->group(function () {
            Route::get('/', 'index')->name('pimpinan.laporan.index');
            Route::post('/generate', 'generate')->name('pimpinan.laporan.generate');
            Route::get('/export-pdf', 'exportPdf')->name('pimpinan.laporan.export-pdf');
            Route::get('/export-excel', 'exportExcel')->name('pimpinan.laporan.export-excel');
        });
    });
});

// ============================================================================
// TEST ROUTE (Hapus di production)
// ============================================================================
Route::get('/test-role', function () {
    if (!auth()->check()) {
        return 'Not logged in';
    }
    return [
        'user' => auth()->user()->name,
        'email' => auth()->user()->email,
        'roles' => auth()->user()->getRoleNames(),
    ];
});