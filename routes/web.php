<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StatistikController;
use App\Http\Middleware\AdminMiddleware; // ⬅️ Tambahkan ini untuk pakai class middleware langsung

// Welcome page
Route::get('/', function () {
    return view('home.welcome');
})->name('home');

Route::get('/about', function () { 
    return view('home.about');
})->name('about');

Route::get('/kontak', function () {
    return view('home.kontak');
})->name('kontak');

// Admin logout route
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// User form routes
Route::get('/form', [UserController::class, 'form'])->name('user.form');

Route::post('/tamu', [HomeController::class, 'store'])->name('tamu.store');
Route::delete('/tamu/{id}', [HomeController::class, 'destroy'])->name('tamu.destroy');



// Admin Auth Routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Panel (protected by middleware - gunakan class langsung, bukan alias)
Route::prefix('admin')->middleware(AdminMiddleware::class)->group(function () {
    Route::get('/', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/statistik', [StatistikController::class, 'index'])->name('admin.statistik');
    
    // Statistik Routes
    Route::get('/statistik/filter-date', [StatistikController::class, 'filterDate'])->name('admin.statistik.filter-date');
    Route::get('/statistik/filter', [StatistikController::class, 'filter'])->name('admin.statistik.filter');
    Route::post('/statistik/export', [StatistikController::class, 'export'])->name('export.tamu');
    Route::get('/tamu/{id}', [StatistikController::class, 'detail'])->name('admin.tamu.detail');
    Route::get('/tamu/{id}/print', [StatistikController::class, 'print'])->name('admin.tamu.print');
});
