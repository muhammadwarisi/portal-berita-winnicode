<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\DashboardController as FrontendDashboardController;

Route::get('/', [FrontendDashboardController::class, 'halamanAwal'])->name('homepage');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('login')->group(function () {
    Route::get('/', [AuthController::class, 'halamanLogin'])->name('login');
    Route::post('process', [AuthController::class, 'login'])->name('process.login');
});
Route::get('register', [AuthController::class, 'halamanRegister'])->name('register');
Route::post('process/register', [AuthController::class, 'register'])->name('process.register');
// Route::get('lupa-password',[AuthController::class,'halamanLupaPassword'])->name('lupa-password');
// Route::post('process/lupa-password',[AuthController::class,'kirimEmail'])->name('process.lupa-password');

// Route::get('process/lupa-password/{token}',[AuthController::class,'kirimEmailToken'])->name('process.lupa-password.token');
// Route::post('process/validasi/lupa-password',[AuthController::class,'validasiTokenResetPassword'])->name('process.lupa-password.validasi');

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('artikel')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('index.artikel');
    Route::get('/create', [ArticleController::class, 'create'])->name('create.artikel');
    Route::post('/store/artikel', [ArticleController::class, 'store'])->name('store.artikel');
    Route::get('/{article}', [ArticleController::class, 'show'])->name('article.show');
    Route::get('/article/{id}/edit', [ArticleController::class, 'edit'])->name('edit.artikel');
    Route::put('/article/{id}', [ArticleController::class, 'update'])->name('update.artikel');
    Route::delete('/article/{id}', [ArticleController::class, 'destroy'])->name('delete.artikel');
});
Route::prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index.user');
    Route::post('/store', [UserController::class,'store'])->name('store.user');
    Route::get('/{user}', [UserController::class,'show'])->name('show.user');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('update.user');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('delete.user');
});
Route::resource('/kategori', CategoryController::class);

