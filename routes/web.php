<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use App\Models\PaketAcara;
use App\Models\Klien;
use App\Models\PemesananAcara;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\CrewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Models\Crew;           
use App\Models\PenugasanCrew;

// ==========================================
// PUBLIC & LANDING PAGE ROUTES
// ==========================================

// Route Utama (Landing Page)
Route::get('/', function () {
    $pakets = PaketAcara::all();
    return view('landing.home', compact('pakets'));
})->name('landing');

// Alias Route 'landing.home'
Route::get('/home', function () {
    return redirect()->route('landing');
})->name('landing.home');

Route::get('/about', function () {
    return view('landing.about');
})->name('landing.about');

// Halaman Booking
Route::get('/booking', [BookingController::class, 'index'])->name('landing.booking');

// Submit Form Booking (Tanpa Wajib Login)
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

// ==========================================
// AUTHENTICATION ROUTES
// ==========================================
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================================
// PROTECTED DASHBOARD ROUTES (Perlu Login)
// ==========================================
Route::middleware(['auth'])->group(function () {
    
    // DASHBOARD ADMIN & MANAGEMENT
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/event/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.event.updateStatus');
    
    // TAMBAHKAN ROUTE UPDATE STATUS INI:
    Route::post('/update-status/{id}', [AdminController::class, 'updateStatus'])->name('admin.updateStatus');

    // Route Klien/Event (Admin Side)
    Route::get('/admin/klien', [ClientController::class, 'index'])->name('admin.klien');

    // Rundown Routes
    Route::post('/admin/klien/rundown', [ClientController::class, 'storeRundown'])->name('admin.rundown.store');
    Route::put('/admin/klien/rundown/{id}', [ClientController::class, 'updateRundown'])->name('admin.rundown.update');
    Route::delete('/admin/klien/rundown/{id}', [ClientController::class, 'destroyRundown'])->name('admin.rundown.destroy');

    // Moodboard Routes
    Route::post('/admin/klien/moodboard', [ClientController::class, 'storeMoodboard'])->name('admin.moodboard.store');
    Route::put('/admin/klien/moodboard/{id}', [ClientController::class, 'updateMoodboard'])->name('admin.moodboard.update');
    Route::delete('/admin/klien/moodboard/{id}', [ClientController::class, 'destroyMoodboard'])->name('admin.moodboard.destroy');

    // Catatan Routes
    Route::post('/admin/klien/catatan/{id_pemesanan}', [ClientController::class, 'updateCatatan'])->name('admin.catatan.update');

    // Vendor Routes
    Route::get('/admin/vendor', [VendorController::class, 'index'])->name('admin.vendor');
    Route::post('/admin/vendor', [VendorController::class, 'store'])->name('admin.vendor.store');
    Route::put('/admin/vendor/{id}', [VendorController::class, 'update'])->name('admin.vendor.update');
    Route::delete('/admin/vendor/{id}', [VendorController::class, 'destroy'])->name('admin.vendor.destroy');

    // Keuangan Routes
    Route::get('/admin/keuangan', [FinanceController::class, 'index'])->name('admin.keuangan');
    Route::put('/admin/keuangan/{id_pemesanan}', [FinanceController::class, 'update'])->name('admin.keuangan.update');

    // Crew Routes
    Route::get('/admin/crew', [CrewController::class, 'index'])->name('admin.crew');
    Route::post('/admin/crew', [CrewController::class, 'store'])->name('admin.crew.store');
    Route::put('/admin/crew/{id}', [CrewController::class, 'update'])->name('admin.crew.update');
    Route::delete('/admin/crew/{id}', [CrewController::class, 'destroy'])->name('admin.crew.destroy');

    // User Management Routes
    Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user');
    Route::post('/admin/user', [UserController::class, 'store'])->name('admin.user.store');
    Route::put('/admin/user/{id}', [UserController::class, 'update'])->name('admin.user.update');
    Route::delete('/admin/user/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');

    // DASHBOARD KLIEN
    Route::get('/klien/dashboard', function () {
        $user = auth()->user();
        $klien = Klien::where('id_user', $user->id_user)->first();
        
        $pemesanan = null;
        if ($klien) {
            $pemesanan = PemesananAcara::with('paket')
                        ->where('id_klien', $klien->id_klien)
                        ->latest('tgl_acara')
                        ->first();
        }

        return view('klien.dashboard', compact('klien', 'pemesanan'));
    })->name('klien.dashboard');

    // DETAIL ACARA KLIEN (Rundown, Moodboard, Note & List)
    Route::get('/klien/detail-acara', function () {
        $user = auth()->user();
        $klien = Klien::where('id_user', $user->id_user)->first();
        
        $pemesanan = null;
        if ($klien) {
            $pemesanan = PemesananAcara::with(['rundown', 'moodboard'])
                        ->where('id_klien', $klien->id_klien)
                        ->latest('tgl_acara')
                        ->first();
        }

        return view('klien.detail-acara', compact('klien', 'pemesanan'));
    })->name('klien.detail-acara');

    // KEUANGAN KLIEN
    Route::get('/klien/keuangan', function () {
        $user = auth()->user();
        $klien = Klien::where('id_user', $user->id_user)->first();
        
        $pemesanan = null;
        if ($klien) {
            $pemesanan = PemesananAcara::with(['paket', 'keuangan', 'pembayaranVendors.vendor'])
                        ->where('id_klien', $klien->id_klien)
                        ->latest('tgl_acara')
                        ->first();
        }

        return view('klien.keuangan', compact('klien', 'pemesanan'));
    })->name('klien.keuangan');

    // DASHBOARD CREW
    Route::get('/crew/dashboard', function () {
        $user = auth()->user();
        
        // Cari data crew berdasarkan id_user yang login
        $crew = Crew::where('id_user', $user->id_user)->first();
        
        $jobdesks = collect();
        if ($crew) {
            // Ambil penugasan crew beserta relasi pemesanan, klien, dan paket
            $jobdesks = PenugasanCrew::with(['pemesanan.klien', 'pemesanan.paket'])
                        ->where('id_crew', $crew->id_crew)
                        ->get();
        }

        return view('crew.dashboard', compact('crew', 'jobdesks'));
    })->name('crew.dashboard');
});

// ROUTE KHUSUS UNTUK MEMBACA FILE STORAGE DI VERCEL & LOCALHOST
Route::get('/storage/{path}', function ($path) {
    $filePath = '/tmp/storage/app/public/' . $path;
    
    if (!file_exists($filePath)) {
        $filePath = storage_path('app/public/' . $path);
    }

    if (!file_exists($filePath)) {
        abort(404);
    }

    $file = file_get_contents($filePath);
    $type = mime_content_type($filePath);

    return Response::make($file, 200)->header("Content-Type", $type);
})->where('path', '.*');