<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//email verification
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// Route Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


// Group Route dengan Middleware Auth untuk Proteksi
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Route Home dan Profile
    Route::get('/home', [ProfileController::class, 'index'])->name('home');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');
    // Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Routes Barang
    Route::prefix('barang')->name('barang.')->group(function () {
        Route::get('/', [BarangController::class, 'index'])->name('index');
        Route::get('create', [BarangController::class, 'create'])->name('create');
        Route::post('/', [BarangController::class, 'store'])->name('store');
        Route::get('{id}/edit', [BarangController::class, 'edit'])->name('edit');
        Route::put('{id}', [BarangController::class, 'update'])->name('update');
        Route::delete('{id}', [BarangController::class, 'destroy'])->name('destroy');
        Route::get('table-data', [BarangController::class, 'tableDataAdmin'])->name('tableDataAdmin');
    });

    // Routes Kategori
    Route::prefix('kategori')->name('kategori.')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('index');
        Route::get('create', [KategoriController::class, 'create'])->name('create');
        Route::post('/', [KategoriController::class, 'store'])->name('store');
        Route::get('{id}/edit', [KategoriController::class, 'edit'])->name('edit');
        Route::put('{id}', [KategoriController::class, 'update'])->name('update');
        Route::delete('{id}', [KategoriController::class, 'destroy'])->name('destroy');
        Route::get('table-data', [KategoriController::class, 'tableDataAdmin'])->name('tableDataAdmin');
    });

    // Routes Lokasi
    Route::prefix('lokasi')->name('lokasi.')->group(function () {
        Route::get('/', [LokasiController::class, 'index'])->name('index');
        Route::get('create', [LokasiController::class, 'create'])->name('create');
        Route::post('/', [LokasiController::class, 'store'])->name('store');
        Route::get('{id}/edit', [LokasiController::class, 'edit'])->name('edit');
        Route::put('{id}', [LokasiController::class, 'update'])->name('update');
        Route::delete('{id}', [LokasiController::class, 'destroy'])->name('destroy');
        Route::get('table-data', [LokasiController::class, 'tableDataAdmin'])->name('tableDataAdmin');
    });

    // Routes Mutasi
    Route::prefix('mutasi')->name('mutasi.')->group(function () {
        Route::get('/', [MutasiController::class, 'index'])->name('index');
        Route::get('create', [MutasiController::class, 'create'])->name('create');
        Route::post('/', [MutasiController::class, 'store'])->name('store');
        Route::get('{id}/edit', [MutasiController::class, 'edit'])->name('edit');
        Route::put('{id}', [MutasiController::class, 'update'])->name('update');
        Route::delete('{id}', [MutasiController::class, 'destroy'])->name('destroy');
        Route::get('table-data', [MutasiController::class, 'tableDataAdmin'])->name('tableDataAdmin');
    });

   // Routes User
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('{user}', [UserController::class, 'update'])->name('update');
        Route::get('table-data', [UserController::class, 'tableDataAdmin'])->name('tableDataAdmin');
    });


});
