<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\DaftarController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WhatsappMessage;
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

Route::get('/', [HomeController::class, 'index']);

Route::post('daftar', [DaftarController::class, 'baru'])->name('daftar.baru');
Route::post('dafar/verification', [DaftarController::class, 'verifikasi'])->name('daftar.verifikasi');

Route::post('simpan', [HomeController::class, 'simpan'])->name('simpan');
Route::get('peserta', [WhatsappMessage::class, 'peserta'])->name('update_peserta');

Route::get('gambar', [AdminController::class, 'gambar']);

Route::get('/admin', [AdminController::class, 'index'])->name('admin');
Route::get('/admin/peserta', [AdminController::class, 'rekap'])->name('admin.peserta');
Route::get('/admin/daftar_peserta', [AdminController::class, 'daftar_peserta'])->name('admin.daftar_peserta');