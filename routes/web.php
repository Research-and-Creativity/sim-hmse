<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PembinaController;
use App\Http\Controllers\ProkerController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\EventController;

/*
|--------------------------------------------------------------------------
| Public Routes — Halaman Publik (Landing Page)
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');

// Event / Proker Publik (dahulu News)
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
Route::post('/events/{id}/register', [EventController::class, 'register'])->name('events.register');

// Legacy redirect news → events
Route::redirect('/news', '/events')->name('news.index');

/*
|--------------------------------------------------------------------------
| Auth Redirect — akan diisi nanti saat modul auth selesai
|--------------------------------------------------------------------------
*/

Route::get('/login', [DashboardController::class, 'loginSelect'])->name('login');
Route::get('/login/{role}', [DashboardController::class, 'loginForm'])->name('login.form')->where('role', 'pengurus|pembina|kaprodi');
Route::post('/login', [DashboardController::class, 'loginSubmit'])->name('login.submit');
Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Dashboard Routes — Halaman Manajemen Internal
|--------------------------------------------------------------------------
*/

Route::prefix('dashboard')->name('dashboard')->middleware(['auth', 'role:admin,pengurus'])->group(function () {

    // Dashboard Overview
    Route::get('/', [DashboardController::class, 'index']);

    // Program Kerja
    Route::prefix('/proker')->name('.proker')->group(function () {
        Route::get('/', [ProkerController::class, 'index'])->name('.index');
        Route::get('/create', [ProkerController::class, 'create'])->name('.create');
        Route::post('/', [ProkerController::class, 'store'])->name('.store');
        Route::get('/{id}/edit', [ProkerController::class, 'edit'])->name('.edit');
        Route::put('/{id}', [ProkerController::class, 'update'])->name('.update');
        Route::get('/{id}', [ProkerController::class, 'show'])->name('.show');
    });

    // Kalender
    Route::get('/calendar', [DashboardController::class, 'calendar'])->name('.calendar');

    // Proposal
    Route::prefix('/proposal')->name('.proposal')->group(function () {
        Route::get('/', [DashboardController::class, 'proposalIndex'])->name('.index');
        Route::get('/create', [DashboardController::class, 'proposalCreate'])->name('.create');
        Route::get('/preview/{id}', [DashboardController::class, 'proposalPreview'])->name('.preview');
        Route::get('/test-download', function() {
            return response()->json(['message' => 'test ok', 'time' => now()]);
        })->name('.test');
        Route::get('/{id}', [DashboardController::class, 'proposalShow'])->name('.show');
    });

    // Keuangan
    Route::prefix('/finance')->name('.finance')->group(function () {
        Route::get('/', [FinanceController::class, 'index'])->name('.index');
        Route::get('/create', [FinanceController::class, 'create'])->name('.create');
        Route::post('/', [FinanceController::class, 'store'])->name('.store');
        Route::get('/{id}/edit', [FinanceController::class, 'edit'])->name('.edit');
        Route::put('/{id}', [FinanceController::class, 'update'])->name('.update');
        Route::delete('/{id}', [FinanceController::class, 'destroy'])->name('.destroy');
        Route::get('/export', [FinanceController::class, 'export'])->name('.export');
        
        // Map internal/proker routes to the same `index` handler which reads `tab` or `proker_id`.
        Route::get('/internal', [FinanceController::class, 'index'])->name('.internal');
        Route::get('/proker', [FinanceController::class, 'index'])->name('.proker');
    });

    // SOTK / Keanggotaan
    Route::prefix('/sotk')->name('.sotk')->group(function () {
        Route::get('/', [DashboardController::class, 'sotkIndex'])->name('.index');
        Route::get('/create', [DashboardController::class, 'sotkCreate'])->name('.create');
        Route::post('/', [DashboardController::class, 'sotkStore'])->name('.store');
        Route::delete('/{id}', [DashboardController::class, 'sotkDestroy'])->name('.destroy');
    });

    // Events / Proker Publik Management
    Route::prefix('/events')->name('.events')->group(function () {
        Route::get('/', [DashboardController::class, 'eventsIndex'])->name('.index');
        // Daftar pendaftar per proker
        Route::get('/{id}/registrations', [DashboardController::class, 'eventRegistrations'])->name('.registrations');
        // Update status pendaftar
        Route::patch('/{id}/registrations/{regId}', [DashboardController::class, 'updateRegistrationStatus'])->name('.registrations.update');
    });

    // Dokumentasi
    Route::prefix('/documents')->name('.documents')->group(function () {
        Route::get('/', [DashboardController::class, 'documentsIndex'])->name('.index');
        Route::post('/', [DashboardController::class, 'documentsStore'])->name('.store');
        Route::get('/{id}/download', [DashboardController::class, 'documentsDownload'])->name('.download');
        Route::delete('/{id}', [DashboardController::class, 'documentsDestroy'])->name('.destroy');
    });

    // Pengaturan
    Route::get('/settings', [DashboardController::class, 'settings'])->name('.settings');

});

/*
|--------------------------------------------------------------------------
| Pembina / Kaprodi Routes
|--------------------------------------------------------------------------
*/
Route::prefix('pembina')->name('pembina.')->middleware(['auth', 'role:pembina,kaprodi'])->group(function () {

    Route::get('/',                   [PembinaController::class, 'dashboard'])->name('dashboard');
    Route::get('/proker',             [PembinaController::class, 'proker'])->name('proker');
    Route::get('/calendar',           [PembinaController::class, 'calendar'])->name('calendar');
    Route::get('/keuangan',           [PembinaController::class, 'keuangan'])->name('keuangan');

    // Proposal
    Route::get('/proposal',           [PembinaController::class, 'proposalIndex'])->name('proposal');
    Route::get('/proposal/{id}',      [PembinaController::class, 'proposalShow'])->name('proposal.show');
    Route::get('/proposal/{id}/preview', [PembinaController::class, 'proposalPreview'])->name('proposal.preview');

    // Notifications
    Route::get('/notifications/unread', [PembinaController::class, 'getUnreadNotifications'])->name('notifications.unread');
    Route::post('/notifications/mark-read', [PembinaController::class, 'markNotificationsRead'])->name('notifications.mark-read');

});

/*
|--------------------------------------------------------------------------
| Proposal Generator Routes
|--------------------------------------------------------------------------
*/
// Public template download (no auth required)
Route::get('/proposals/template/{riskLevel}', [ProposalController::class, 'downloadTemplate'])->name('proposals.download-template');

// Protected proposal routes
Route::prefix('proposals')->name('proposals')->middleware(['auth', 'role:admin,pengurus,pembina,kaprodi'])->group(function () {
    Route::get('/', [ProposalController::class, 'index'])->name('.index');
    Route::get('/create', [ProposalController::class, 'create'])->name('.create');
    Route::post('/', [ProposalController::class, 'store'])->name('.store');
    Route::get('/{proposal}', [ProposalController::class, 'show'])->name('.show');
    Route::get('/{proposal}/edit', [ProposalController::class, 'edit'])->name('.edit');
    Route::put('/{proposal}', [ProposalController::class, 'update'])->name('.update');
    Route::post('/{proposal}/submit', [ProposalController::class, 'submit'])->name('.submit');
    Route::post('/{proposal}/generate-pdf', [ProposalController::class, 'generatePdf'])->name('.generate-pdf');
    Route::get('/{proposal}/download-pdf', [ProposalController::class, 'downloadPdf'])->name('.download-pdf');
    Route::get('/{proposal}/generate-filled', [ProposalController::class, 'generateFilledDocument'])->name('.generate-filled');
    Route::get('/{proposal}/preview-filled', [ProposalController::class, 'previewFilledDocument'])->name('.preview-filled');
    Route::post('/approval/{approval}/approve', [ProposalController::class, 'approve'])->name('.approve');
    Route::post('/approval/{approval}/reject', [ProposalController::class, 'reject'])->name('.reject');
    Route::delete('/{proposal}', [ProposalController::class, 'destroy'])->name('.destroy');
});

Route::middleware('auth')->group(function () {
    Route::post('/proposal/preview', [ProposalController::class, 'preview'])
        ->name('dashboard.proposal.preview.post');

    Route::post('/proposal/download-docx', [ProposalController::class, 'downloadPreviewDocx'])
        ->name('dashboard.proposal.download-docx');
});

// Storage Streaming Proxy (fallback untuk media private storage)
Route::get('/storage-proxy/{path}', [DashboardController::class, 'storageProxy'])
    ->where('path', '.*')
    ->name('storage.proxy');



