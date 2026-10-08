<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test-camera', function () {
    return view('test-camera');
});

// Route Tamu (Belum Login)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Route Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Sementara untuk Halaman Setelah Login
Route::get('/admin/dashboard', function () {
    return "Selamat datang di Dashboard Admin Exscurty Test!";
});

Route::get('/participant/exam', [ExamController::class, 'show']);