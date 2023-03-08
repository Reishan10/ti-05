<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\KategoriController;
use App\Http\Controllers\Backend\MahasiswaController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('frontend.beranda');
});

Auth::routes();

/*------------------------------------------
Superadmin Routes List
--------------------------------------------*/
Route::middleware(['auth', 'user-access:superadmin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Kategori
    Route::resource('kategori', KategoriController::class);
    Route::post('kategori/delete-multiple-kategori', [KategoriController::class, 'deleteMultiple'])->name('delete-multiple-kategori');

    // Tag
    Route::resource('tag', TagController::class);
    Route::post('tag/delete-multiple-tag', [TagController::class, 'deleteMultiple'])->name('delete-multiple-tag');

    // Posts
    Route::post('post/delete-multiple-post', [PostController::class, 'deleteMultiple'])->name('delete-multiple-post');
    Route::get('post', [PostController::class, 'index'])->name('post.index');
    Route::get('post/create', [PostController::class, 'create'])->name('post.create');
    Route::post('post', [PostController::class, 'store'])->name('post.store');
    Route::get('post/{post}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::post('post/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('post/{post}', [PostController::class, 'destroy'])->name('post.destroy');

    // Mahasiswa
    Route::post('mahasiswa/delete-multiple-mahasiswa', [MahasiswaController::class, 'deleteMultiple'])->name('delete-multiple-mahasiswa');
    Route::get('mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::get('mahasiswa/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
    Route::post('mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
    Route::get('mahasiswa/{mahasiswa}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
    Route::post('mahasiswa/{mahasiswa}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
    Route::delete('mahasiswa/{mahasiswa}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');

    // User
    Route::post('pengguna/delete-multiple-pengguna', [UserController::class, 'deleteMultiple'])->name('delete-multiple-pengguna');
    Route::get('pengguna', [UserController::class, 'index'])->name('pengguna.index');
    Route::post('pengguna', [UserController::class, 'store'])->name('pengguna.store');
    Route::get('pengguna/{pengguna}/edit', [UserController::class, 'edit'])->name('pengguna.edit');
    Route::delete('pengguna/{pengguna}', [UserController::class, 'destroy'])->name('pengguna.destroy');
});

/*------------------------------------------
Admin Routes List
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {
    // Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
    return "Admin";
});
