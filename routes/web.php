<?php

use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\AuthController;
use App\Http\Controllers\Public\DipController;
use App\Http\Controllers\Public\DirektoriController;
use App\Http\Controllers\Public\ProfilController;
use App\Http\Controllers\Public\StandarLayananController;
use App\Http\Controllers\Dashboard\Pembantu\DashboardController;
use App\Http\Controllers\Dashboard\Pembantu\DocumentController;
use App\Http\Controllers\Dashboard\Pembantu\ProfilOpdController;
use App\Http\Controllers\Dashboard\Pembantu\LegalDocumentController;
use App\Http\Controllers\Dashboard\Utama\MonitoringController;
use App\Http\Controllers\Dashboard\Utama\CmsNewsController;
use App\Http\Controllers\Dashboard\Utama\HeroSlideController;
use App\Http\Controllers\Dashboard\Utama\LaporanController;
use App\Http\Controllers\Dashboard\Utama\DocumentManagementController;
use App\Http\Controllers\Admin\OpdController;
use App\Http\Controllers\Admin\VillageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\AuditLogController;
use Illuminate\Support\Facades\Route;

// ========== PUBLIC ROUTES ==========
Route::get('/', [HomeController::class, 'index'])->name('home');

// ========== PROFIL PPID ==========
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::get('/profil/{section}', [ProfilController::class, 'show'])->name('profil.show');

// ========== STANDAR LAYANAN ==========
Route::get('/standar-layanan', [StandarLayananController::class, 'index'])->name('standar-layanan.index');
Route::get('/standar-layanan/{slug}', [StandarLayananController::class, 'show'])->name('standar-layanan.show');

// ========== DAFTAR INFORMASI PUBLIK (DIP) ==========
Route::get('/dip', [DipController::class, 'index'])->name('dip.index');
Route::get('/dip/category/{slug}', [DipController::class, 'byCategory'])->name('dip.category');
Route::get('/dip/preview/{document}', [DipController::class, 'preview'])->name('dip.preview');
Route::get('/dip/download/{document}', [DipController::class, 'download'])
    ->middleware(['auth'])
    ->name('dip.download');

// ========== DIREKTORI ==========
Route::get('/direktori/opd', [DirektoriController::class, 'opdIndex'])->name('direktori.opd');
Route::get('/direktori/opd/{opd}', [DirektoriController::class, 'opdShow'])->name('direktori.opd.show');
Route::get('/direktori/desa', [DirektoriController::class, 'desaIndex'])->name('direktori.desa');

// ========== AUTH ROUTES ==========
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ========== DASHBOARD ROUTES ==========
Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    
    // ========== DASHBOARD PPID PEMBANTU ==========
    Route::prefix('pembantu')->middleware(['role:ppid_pembantu'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.pembantu');
        
        // Route Dokumen DIP
        Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
        Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
        Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
        Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
        Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
        Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
        Route::patch('/documents/{document}/status', [DocumentController::class, 'updateStatus'])->name('documents.status');
        
        // Route Profil OPD
        Route::get('profil-opd/edit', [ProfilOpdController::class, 'edit'])->name('pembantu.profil-opd.edit');
        Route::put('profil-opd', [ProfilOpdController::class, 'update'])->name('pembantu.profil-opd.update');
        
        // Route Dasar Hukum (Legal Documents)
        Route::resource('legal-documents', LegalDocumentController::class);
    });
    
    // ========== DASHBOARD PPID UTAMA ==========
    Route::prefix('utama')->middleware(['role:super_admin|ppid_utama|pimpinan'])->group(function () {
        Route::get('/', [MonitoringController::class, 'index'])->name('dashboard.utama');
        
        // CMS Berita
        Route::prefix('cms/news')->group(function () {
            Route::get('/', [CmsNewsController::class, 'index'])->name('utama.cms.news.index');
            Route::get('/create', [CmsNewsController::class, 'create'])->name('utama.cms.news.create');
            Route::post('/', [CmsNewsController::class, 'store'])->name('utama.cms.news.store');
            Route::get('/{news}/edit', [CmsNewsController::class, 'edit'])->name('utama.cms.news.edit');
            Route::put('/{news}', [CmsNewsController::class, 'update'])->name('utama.cms.news.update');
            Route::delete('/{news}', [CmsNewsController::class, 'destroy'])->name('utama.cms.news.destroy');
            Route::patch('/{news}/toggle', [CmsNewsController::class, 'togglePublished'])->name('utama.cms.news.toggle');
        });
        
        // CMS Agenda
        Route::prefix('cms/agenda')->group(function () {
            Route::get('/', [CmsNewsController::class, 'agendaIndex'])->name('utama.cms.agenda.index');
            Route::get('/create', [CmsNewsController::class, 'agendaCreate'])->name('utama.cms.agenda.create');
            Route::post('/', [CmsNewsController::class, 'agendaStore'])->name('utama.cms.agenda.store');
            Route::get('/{news}/edit', [CmsNewsController::class, 'agendaEdit'])->name('utama.cms.agenda.edit');
            Route::put('/{news}', [CmsNewsController::class, 'agendaUpdate'])->name('utama.cms.agenda.update');
            Route::delete('/{news}', [CmsNewsController::class, 'agendaDestroy'])->name('utama.cms.agenda.destroy');
        });

        // CMS Galeri
        Route::prefix('cms/gallery')->group(function () {
            Route::get('/', [CmsNewsController::class, 'galleryIndex'])->name('utama.cms.gallery.index');
            Route::get('/create', [CmsNewsController::class, 'galleryCreate'])->name('utama.cms.gallery.create');
            Route::post('/', [CmsNewsController::class, 'galleryStore'])->name('utama.cms.gallery.store');
            Route::get('/{news}/edit', [CmsNewsController::class, 'galleryEdit'])->name('utama.cms.gallery.edit');
            Route::put('/{news}', [CmsNewsController::class, 'galleryUpdate'])->name('utama.cms.gallery.update');
            Route::delete('/{news}', [CmsNewsController::class, 'galleryDestroy'])->name('utama.cms.gallery.destroy');
        });

        // CMS Infografis
        Route::prefix('cms/infographic')->group(function () {
            Route::get('/', [CmsNewsController::class, 'infographicIndex'])->name('utama.cms.infographic.index');
            Route::get('/create', [CmsNewsController::class, 'infographicCreate'])->name('utama.cms.infographic.create');
            Route::post('/', [CmsNewsController::class, 'infographicStore'])->name('utama.cms.infographic.store');
            Route::get('/{news}/edit', [CmsNewsController::class, 'infographicEdit'])->name('utama.cms.infographic.edit');
            Route::put('/{news}', [CmsNewsController::class, 'infographicUpdate'])->name('utama.cms.infographic.update');
            Route::delete('/{news}', [CmsNewsController::class, 'infographicDestroy'])->name('utama.cms.infographic.destroy');
        });

        // CMS Hero Slider
        Route::prefix('cms/hero')->group(function () {
            Route::get('/', [HeroSlideController::class, 'index'])->name('utama.cms.hero.index');
            Route::get('/create', [HeroSlideController::class, 'create'])->name('utama.cms.hero.create');
            Route::post('/', [HeroSlideController::class, 'store'])->name('utama.cms.hero.store');
            Route::get('/{heroSlide}/edit', [HeroSlideController::class, 'edit'])->name('utama.cms.hero.edit');
            Route::put('/{heroSlide}', [HeroSlideController::class, 'update'])->name('utama.cms.hero.update');
            Route::delete('/{heroSlide}', [HeroSlideController::class, 'destroy'])->name('utama.cms.hero.destroy');
            Route::patch('/{heroSlide}/toggle', [HeroSlideController::class, 'toggleActive'])->name('utama.cms.hero.toggle');
            Route::post('/update-order', [HeroSlideController::class, 'updateOrder'])->name('utama.cms.hero.update-order');
        });

        // CMS Profil PPID
        Route::prefix('cms/profil')->group(function () {
            Route::get('/', [CmsNewsController::class, 'profilIndex'])->name('utama.cms.profil.index');
            Route::get('/{pageKey}/edit', [CmsNewsController::class, 'profilEdit'])->name('utama.cms.profil.edit');
            Route::put('/{pageKey}', [CmsNewsController::class, 'profilUpdate'])->name('utama.cms.profil.update');
        });

        // ========== CMS STANDAR LAYANAN ==========
        Route::prefix('cms/standar')->group(function () {
            Route::get('/', [CmsNewsController::class, 'standarIndex'])->name('utama.cms.standar.index');
            Route::get('/{pageKey}/edit', [CmsNewsController::class, 'standarEdit'])->name('utama.cms.standar.edit');
            Route::put('/{pageKey}', [CmsNewsController::class, 'standarUpdate'])->name('utama.cms.standar.update');
        });

        // Manajemen Dokumen Global
        Route::prefix('documents')->group(function () {
            Route::get('/', [DocumentManagementController::class, 'index'])->name('utama.documents.index');
            Route::get('/{document}/edit', [DocumentManagementController::class, 'edit'])->name('utama.documents.edit');
            Route::put('/{document}', [DocumentManagementController::class, 'update'])->name('utama.documents.update');
            Route::delete('/{document}', [DocumentManagementController::class, 'destroy'])->name('utama.documents.destroy');
            Route::patch('/{document}/force-unpublish', [DocumentManagementController::class, 'forceUnpublish'])->name('utama.documents.force-unpublish');
        });

        // Laporan
        Route::prefix('laporan')->group(function () {
            Route::get('/', [LaporanController::class, 'index'])->name('utama.laporan.index');
            Route::post('/generate', [LaporanController::class, 'generate'])->name('utama.laporan.generate');
        });
    });
});

// ========== SUPER ADMIN ROUTES ==========
Route::prefix('dashboard/admin')->middleware(['auth', 'role:super_admin'])->group(function () {
    
    Route::resource('opds', OpdController::class)->names([
        'index' => 'admin.opds.index',
        'create' => 'admin.opds.create',
        'store' => 'admin.opds.store',
        'edit' => 'admin.opds.edit',
        'update' => 'admin.opds.update',
        'destroy' => 'admin.opds.destroy',
    ]);
    
    Route::resource('villages', VillageController::class)->names([
        'index' => 'admin.villages.index',
        'create' => 'admin.villages.create',
        'store' => 'admin.villages.store',
        'edit' => 'admin.villages.edit',
        'update' => 'admin.villages.update',
        'destroy' => 'admin.villages.destroy',
    ]);
    
    Route::resource('categories', CategoryController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);
    
    Route::resource('users', UserManagementController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
    
    Route::get('audit-logs', [AuditLogController::class, 'index'])->name('admin.audit-logs');

    // Sub Kategori
    Route::get('categories/{category}/subcategories', [CategoryController::class, 'subCategories'])->name('admin.categories.subcategories');
    Route::post('categories/{category}/subcategories', [CategoryController::class, 'storeSubCategory'])->name('admin.categories.subcategories.store');
    Route::get('subcategories/{subCategory}/edit', [CategoryController::class, 'editSubCategory'])->name('admin.subcategories.edit');
    Route::put('subcategories/{subCategory}', [CategoryController::class, 'updateSubCategory'])->name('admin.subcategories.update');
    Route::delete('subcategories/{subCategory}', [CategoryController::class, 'destroySubCategory'])->name('admin.subcategories.destroy');
});

// ========== TEMP TEST ROUTE (Hapus setelah production) ==========
Route::get('/test-role', function() {
    if (!auth()->check()) {
        return 'Not logged in';
    }
    return [
        'user' => auth()->user()->name,
        'email' => auth()->user()->email,
        'roles' => auth()->user()->getRoleNames(),
    ];
});