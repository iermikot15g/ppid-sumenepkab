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

// ============================================================================
// PUBLIC ROUTES - Dapat diakses tanpa login
// ============================================================================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ============================================================================
// PROFIL PPID - Halaman profil PPID Kabupaten Sumenep
// ============================================================================
Route::get('/profil', [ProfilController::class, 'index'])->name('profil');
Route::get('/profil/{section}', [ProfilController::class, 'show'])->name('profil.show');

// ============================================================================
// STANDAR LAYANAN - Halaman standar layanan PPID
// ============================================================================
Route::get('/standar-layanan', [StandarLayananController::class, 'index'])->name('standar-layanan.index');
Route::get('/standar-layanan/{slug}', [StandarLayananController::class, 'show'])->name('standar-layanan.show');

// ============================================================================
// DAFTAR INFORMASI PUBLIK (DIP) - Halaman pencarian dokumen publik
// ============================================================================
Route::get('/dip', [DipController::class, 'index'])->name('dip.index');
Route::get('/dip/category/{slug}', [DipController::class, 'byCategory'])->name('dip.category');
Route::get('/dip/preview/{document}', [DipController::class, 'preview'])->name('dip.preview');
Route::get('/dip/download/{document}', [DipController::class, 'download'])
    ->middleware(['auth'])
    ->name('dip.download');

// ============================================================================
// INFOGRAFIS - Halaman khusus menampilkan semua infografis yang dipublish
// ============================================================================
Route::get('/infografis', [PublicInfografisController::class, 'index'])->name('infografis.index');

// ============================================================================
// GALERI FOTO - Halaman khusus menampilkan semua galeri foto yang dipublish
// ============================================================================
Route::get('/galeri', [\App\Http\Controllers\Public\GaleriController::class, 'index'])->name('galeri.index');

// ============================================================================
// AGENDA KEGIATAN - Halaman khusus menampilkan semua agenda yang dipublish
// ============================================================================
Route::get('/agenda', [\App\Http\Controllers\Public\AgendaController::class, 'index'])->name('agenda.index');
Route::get('/agenda/filter/{status}', [\App\Http\Controllers\Public\AgendaController::class, 'filter'])->name('agenda.filter');

// ============================================================================
// DIREKTORI - Halaman daftar PPID Pembantu (OPD) dan PPID Desa
// ============================================================================
Route::get('/direktori/opd', [DirektoriController::class, 'opdIndex'])->name('direktori.opd');
Route::get('/direktori/opd/{opd}', [DirektoriController::class, 'opdShow'])->name('direktori.opd.show');
Route::get('/direktori/desa', [DirektoriController::class, 'desaIndex'])->name('direktori.desa');

// ============================================================================
// AUTH ROUTES - Login, Register, Logout
// ============================================================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================================================
// DASHBOARD ROUTES - Semua route yang memerlukan autentikasi
// ============================================================================
Route::prefix('dashboard')->middleware(['auth'])->group(function () {
    
    // ========================================================================
    // DASHBOARD PPID PEMBANTU - Untuk Operator OPD
    // ========================================================================
    Route::prefix('pembantu')->middleware(['role:ppid_pembantu'])->group(function () {
        
        // Dashboard utama PPID Pembantu
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard.pembantu');
        
        // ====================================================================
        // DOKUMEN DIP - CRUD dokumen informasi publik milik OPD sendiri
        // ====================================================================
        Route::prefix('documents')->group(function () {
            Route::get('/', [DocumentController::class, 'index'])->name('documents.index');
            Route::get('/create', [DocumentController::class, 'create'])->name('documents.create');
            Route::post('/', [DocumentController::class, 'store'])->name('documents.store');
            Route::get('/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
            Route::put('/{document}', [DocumentController::class, 'update'])->name('documents.update');
            Route::delete('/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
            Route::patch('/{document}/status', [DocumentController::class, 'updateStatus'])->name('documents.status');
        });
        
        // ====================================================================
        // CMS PPID PEMBANTU - Content Management System untuk OPD
        // ====================================================================
        Route::prefix('cms')->group(function () {
            
            // ================================================================
            // CMS PROFIL OPD - Kelola profil OPD (Tentang, Tugas Fungsi, Struktur, Dasar Hukum, Media Sosial)
            // ================================================================
            Route::prefix('profil')->group(function () {
                Route::get('/', [CmsProfilOpdController::class, 'index'])->name('pembantu.cms.profil.index');
                
                // Tentang OPD (Visi Misi, Profil, Alamat, Kontak, Logo, Google Maps)
                Route::get('/tentang', [CmsProfilOpdController::class, 'editTentang'])->name('pembantu.cms.profil.tentang');
                Route::put('/tentang', [CmsProfilOpdController::class, 'updateTentang'])->name('pembantu.cms.profil.update-tentang');
                
                // Tugas dan Fungsi
                Route::get('/tugas-fungsi', [CmsProfilOpdController::class, 'editTugasFungsi'])->name('pembantu.cms.profil.tugas-fungsi');
                Route::put('/tugas-fungsi', [CmsProfilOpdController::class, 'updateTugasFungsi'])->name('pembantu.cms.profil.update-tugas-fungsi');
                
                // Struktur Organisasi
                Route::get('/struktur', [CmsProfilOpdController::class, 'editStruktur'])->name('pembantu.cms.profil.struktur');
                Route::put('/struktur', [CmsProfilOpdController::class, 'updateStruktur'])->name('pembantu.cms.profil.update-struktur');
                
                // Dasar Hukum
                Route::get('/dasar-hukum', [CmsProfilOpdController::class, 'editDasarHukum'])->name('pembantu.cms.profil.dasar-hukum');
                Route::put('/dasar-hukum', [CmsProfilOpdController::class, 'updateDasarHukum'])->name('pembantu.cms.profil.update-dasar-hukum');
                
                // ================================================================
                // MEDIA SOSIAL - Kelola link media sosial OPD
                // ================================================================
                Route::get('/media-sosial', [CmsProfilOpdController::class, 'editMediaSosial'])->name('pembantu.cms.profil.media-sosial');
                Route::put('/media-sosial', [CmsProfilOpdController::class, 'updateMediaSosial'])->name('pembantu.cms.profil.update-media-sosial');
            });
            
            // ================================================================
            // CMS AGENDA - Kelola agenda kegiatan OPD
            // ================================================================
            Route::prefix('agenda')->group(function () {
                Route::get('/', [AgendaController::class, 'index'])->name('pembantu.cms.agenda.index');
                Route::get('/create', [AgendaController::class, 'create'])->name('pembantu.cms.agenda.create');
                Route::post('/', [AgendaController::class, 'store'])->name('pembantu.cms.agenda.store');
                Route::get('/{id}/edit', [AgendaController::class, 'edit'])->name('pembantu.cms.agenda.edit');
                Route::put('/{id}', [AgendaController::class, 'update'])->name('pembantu.cms.agenda.update');
                Route::delete('/{id}', [AgendaController::class, 'destroy'])->name('pembantu.cms.agenda.destroy');
                Route::patch('/{id}/toggle', [AgendaController::class, 'togglePublished'])->name('pembantu.cms.agenda.toggle');
            });
            
            // ================================================================
            // CMS INFOGRAFIS - Kelola infografis OPD
            // ================================================================
            Route::prefix('infographic')->group(function () {
                Route::get('/', [InfografisController::class, 'index'])->name('pembantu.cms.infographic.index');
                Route::get('/create', [InfografisController::class, 'create'])->name('pembantu.cms.infographic.create');
                Route::post('/', [InfografisController::class, 'store'])->name('pembantu.cms.infographic.store');
                Route::get('/{id}/edit', [InfografisController::class, 'edit'])->name('pembantu.cms.infographic.edit');
                Route::put('/{id}', [InfografisController::class, 'update'])->name('pembantu.cms.infographic.update');
                Route::delete('/{id}', [InfografisController::class, 'destroy'])->name('pembantu.cms.infographic.destroy');
                Route::patch('/{id}/toggle', [InfografisController::class, 'togglePublished'])->name('pembantu.cms.infographic.toggle');
            });

            // ================================================================
            // LAYANAN PUBLIK OPD - Kelola website layanan publik OPD
            // ================================================================
            Route::prefix('services')->group(function () {
                Route::get('/', [OpdServiceController::class, 'index'])->name('pembantu.cms.services.index');
                Route::get('/create', [OpdServiceController::class, 'create'])->name('pembantu.cms.services.create');
                Route::post('/', [OpdServiceController::class, 'store'])->name('pembantu.cms.services.store');
                Route::get('/{service}/edit', [OpdServiceController::class, 'edit'])->name('pembantu.cms.services.edit');
                Route::put('/{service}', [OpdServiceController::class, 'update'])->name('pembantu.cms.services.update');
                Route::delete('/{service}', [OpdServiceController::class, 'destroy'])->name('pembantu.cms.services.destroy');
                Route::patch('/{service}/toggle', [OpdServiceController::class, 'toggleActive'])->name('pembantu.cms.services.toggle');
            });
        });
    });
    
    // ========================================================================
    // DASHBOARD PPID UTAMA - Untuk PPID Utama, Super Admin, Pimpinan
    // ========================================================================
    Route::prefix('utama')->middleware(['role:super_admin|ppid_utama|pimpinan'])->group(function () {
        
        // Dashboard monitoring
        Route::get('/', [MonitoringController::class, 'index'])->name('dashboard.utama');
                
        // ====================================================================
        // CMS AGENDA - Kelola agenda kegiatan
        // ====================================================================
        Route::prefix('cms/agenda')->group(function () {
            Route::get('/', [CmsNewsController::class, 'agendaIndex'])->name('utama.cms.agenda.index');
            Route::get('/create', [CmsNewsController::class, 'agendaCreate'])->name('utama.cms.agenda.create');
            Route::post('/', [CmsNewsController::class, 'agendaStore'])->name('utama.cms.agenda.store');
            Route::get('/{news}/edit', [CmsNewsController::class, 'agendaEdit'])->name('utama.cms.agenda.edit');
            Route::put('/{news}', [CmsNewsController::class, 'agendaUpdate'])->name('utama.cms.agenda.update');
            Route::delete('/{news}', [CmsNewsController::class, 'agendaDestroy'])->name('utama.cms.agenda.destroy');
        });

        // ====================================================================
        // CMS GALERI - Kelola galeri foto
        // ====================================================================
        Route::prefix('cms/gallery')->group(function () {
            Route::get('/', [CmsNewsController::class, 'galleryIndex'])->name('utama.cms.gallery.index');
            Route::get('/create', [CmsNewsController::class, 'galleryCreate'])->name('utama.cms.gallery.create');
            Route::post('/', [CmsNewsController::class, 'galleryStore'])->name('utama.cms.gallery.store');
            Route::get('/{news}/edit', [CmsNewsController::class, 'galleryEdit'])->name('utama.cms.gallery.edit');
            Route::put('/{news}', [CmsNewsController::class, 'galleryUpdate'])->name('utama.cms.gallery.update');
            Route::delete('/{news}', [CmsNewsController::class, 'galleryDestroy'])->name('utama.cms.gallery.destroy');
        });

        // ====================================================================
        // CMS INFOGRAFIS - Kelola infografis
        // ====================================================================
        Route::prefix('cms/infographic')->group(function () {
            Route::get('/', [CmsNewsController::class, 'infographicIndex'])->name('utama.cms.infographic.index');
            Route::get('/create', [CmsNewsController::class, 'infographicCreate'])->name('utama.cms.infographic.create');
            Route::post('/', [CmsNewsController::class, 'infographicStore'])->name('utama.cms.infographic.store');
            Route::get('/{news}/edit', [CmsNewsController::class, 'infographicEdit'])->name('utama.cms.infographic.edit');
            Route::put('/{news}', [CmsNewsController::class, 'infographicUpdate'])->name('utama.cms.infographic.update');
            Route::delete('/{news}', [CmsNewsController::class, 'infographicDestroy'])->name('utama.cms.infographic.destroy');
        });

        // ====================================================================
        // CMS HERO SLIDER - Kelola slide hero slider di halaman beranda
        // ====================================================================
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

        // ====================================================================
        // CMS PROFIL PPID - Kelola konten halaman profil PPID
        // ====================================================================
        Route::prefix('cms/profil')->group(function () {
            Route::get('/', [CmsNewsController::class, 'profilIndex'])->name('utama.cms.profil.index');
            Route::get('/{pageKey}/edit', [CmsNewsController::class, 'profilEdit'])->name('utama.cms.profil.edit');
            Route::put('/{pageKey}', [CmsNewsController::class, 'profilUpdate'])->name('utama.cms.profil.update');
        });

        // ====================================================================
        // CMS STANDAR LAYANAN - Kelola konten halaman standar layanan
        // ====================================================================
        Route::prefix('cms/standar')->group(function () {
            Route::get('/', [CmsNewsController::class, 'standarIndex'])->name('utama.cms.standar.index');
            Route::get('/{pageKey}/edit', [CmsNewsController::class, 'standarEdit'])->name('utama.cms.standar.edit');
            Route::put('/{pageKey}', [CmsNewsController::class, 'standarUpdate'])->name('utama.cms.standar.update');
        });

        // ====================================================================
        // MANAJEMEN DOKUMEN GLOBAL - Kelola semua dokumen dari seluruh OPD
        // ====================================================================
        Route::prefix('documents')->group(function () {
            Route::get('/', [DocumentManagementController::class, 'index'])->name('utama.documents.index');
            Route::get('/{document}/edit', [DocumentManagementController::class, 'edit'])->name('utama.documents.edit');
            Route::put('/{document}', [DocumentManagementController::class, 'update'])->name('utama.documents.update');
            Route::delete('/{document}', [DocumentManagementController::class, 'destroy'])->name('utama.documents.destroy');
            Route::patch('/{document}/force-unpublish', [DocumentManagementController::class, 'forceUnpublish'])->name('utama.documents.force-unpublish');
        });

        // ====================================================================
        // LAPORAN - Export laporan statistik dalam format PDF/Excel
        // ====================================================================
        Route::prefix('laporan')->group(function () {
            Route::get('/', [LaporanController::class, 'index'])->name('utama.laporan.index');
            Route::post('/generate', [LaporanController::class, 'generate'])->name('utama.laporan.generate');
        });
    });
});

// ============================================================================
// SUPER ADMIN ROUTES - Manajemen data master (hanya Super Admin)
// ============================================================================
Route::prefix('dashboard/admin')->middleware(['auth', 'role:super_admin'])->group(function () {
    
    // ========================================================================
    // MANAJEMEN OPD - CRUD data OPD/PPID Pembantu
    // ========================================================================
    Route::resource('opds', OpdController::class)->names([
        'index' => 'admin.opds.index',
        'create' => 'admin.opds.create',
        'store' => 'admin.opds.store',
        'edit' => 'admin.opds.edit',
        'update' => 'admin.opds.update',
        'destroy' => 'admin.opds.destroy',
    ]);
    
    // ========================================================================
    // MANAJEMEN DESA - CRUD data desa/PPID Desa
    // ========================================================================
    Route::resource('villages', VillageController::class)->names([
        'index' => 'admin.villages.index',
        'create' => 'admin.villages.create',
        'store' => 'admin.villages.store',
        'edit' => 'admin.villages.edit',
        'update' => 'admin.villages.update',
        'destroy' => 'admin.villages.destroy',
    ]);
    
    // ========================================================================
    // MASTER KATEGORI - CRUD kategori dan sub kategori DIP
    // ========================================================================
    Route::resource('categories', CategoryController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);
    
    // Sub Kategori
    Route::get('categories/{category}/subcategories', [CategoryController::class, 'subCategories'])->name('admin.categories.subcategories');
    Route::post('categories/{category}/subcategories', [CategoryController::class, 'storeSubCategory'])->name('admin.categories.subcategories.store');
    Route::get('subcategories/{subCategory}/edit', [CategoryController::class, 'editSubCategory'])->name('admin.subcategories.edit');
    Route::put('subcategories/{subCategory}', [CategoryController::class, 'updateSubCategory'])->name('admin.subcategories.update');
    Route::delete('subcategories/{subCategory}', [CategoryController::class, 'destroySubCategory'])->name('admin.subcategories.destroy');
    
    // ========================================================================
    // MANAJEMEN USER - CRUD user dan assign role
    // ========================================================================
    Route::resource('users', UserManagementController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
    
    // ========================================================================
    // AUDIT LOG - Melihat riwayat aktivitas pengguna
    // ========================================================================
    Route::get('audit-logs', [AuditLogController::class, 'index'])->name('admin.audit-logs');
});

// ============================================================================
// TEMP TEST ROUTE - Hapus setelah production
// ============================================================================
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