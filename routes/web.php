<?php

use App\Http\Controllers\Backend\KategoriController;
use App\Http\Controllers\Backend\PostController;
use App\Http\Controllers\Backend\TagController;
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

// Route::get('/tambah-postingan', function () {
//     return view('backend.post.add');
// });

Route::get('/beranda', function () {
    return view('frontend.beranda');
});

Route::get('/dashboard', function () {
    return view('backend.dashboard');
});

// Kategori
Route::resource('kategori', KategoriController::class);
Route::post('kategori/delete-multiple-kategori', [KategoriController::class, 'deleteMultiple'])->name('delete-multiple-kategori');

// Tag
Route::resource('tag', TagController::class);
Route::post('tag/delete-multiple-tag', [TagController::class, 'deleteMultiple'])->name('delete-multiple-tag');

// Posts
Route::resource('post', PostController::class);
// Route::post('tag/delete-multiple-tag', [TagController::class, 'deleteMultiple'])->name('delete-multiple-tag');
