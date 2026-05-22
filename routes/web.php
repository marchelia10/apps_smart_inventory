<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DasboardController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DataBarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\KategoriAlatController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\KelolaPenggunaController;
use App\Http\Controllers\DashboardPenggunaController;
use App\Http\Controllers\DataBarangPenggunaController;


// login
Route::get('/', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

//regis
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
// Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');


//logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Dasboard admin
Route::middleware('auth')->group(function () {
    Route::get('/dasboard-admin', [DasboardController::class, 'index'])->name('dasboard');
    Route::get('/dasboard/almost-out-items', [DasboardController::class, 'getAlmostOutItems']);
});

//Dashboard pengguna
Route::middleware('auth')->group(function () {
    Route::get('/dashboard_pengguna', [DashboardPenggunaController::class, 'index'])->name('dashboard_pengguna');
});
Route::get('/dashboard_pengguna/filter', [DashboardPenggunaController::class, 'filter'])->name('dashboard_pengguna.filter');

//Data barang Admin
Route::get('/data_barang', [DataBarangController::class, 'showAdmin'])->name('data_barang');

// Data Barang Pengguna
Route::get('/databarang-pengguna', [DataBarangController::class, 'showUser'])->name('pengguna.data_barang');
Route::get('/databarang-pengguna/kategori/{kategori}', [DataBarangController::class, 'showByKategori'])->name('pengguna.data_barang.kategori');
Route::post('/data_barang', [DataBarangController::class, 'store'])->name('barang.store');
Route::put('/data_barang/{id}', [DataBarangController::class, 'update'])->name('barang.update');
Route::delete('/data_barang/{id}', [DataBarangController::class, 'destroy'])->name('barang.destroy');
Route::post('/api/save-rfid-tag', [DataBarangController::class, 'saveRfidTag']);
Route::get('/api/check-rfid/{kodeRFID}', [DataBarangController::class, 'checkRFIDExists']);
Route::get('/get-barang-rfid/{kodeRFID}', [DataBarangController::class, 'getBarangByRFID']);
Route::get('/check-rfid/{kodeRFID}', [DataBarangController::class, 'checkRFIDExists']);

// Peminjaman
Route::get('/peminjaman', [PeminjamanController::class, 'show'])->name('peminjaman');
Route::post('/peminjaman/store', [PeminjamanController::class, 'store'])->name('peminjaman.store');
Route::post('/peminjaman/search-rfid', [PeminjamanController::class, 'searchByRfid'])->name('peminjaman.searchByRfid');

// Pengembalian
Route::middleware(['auth'])->group(function () {
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::post('/pengembalian', [PengembalianController::class, 'store'])->name('pengembalian.store');
});

//riwayat admin
Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
Route::get('/riwayat/{id}', [RiwayatController::class, 'show'])->name('riwayat.detail');
Route::get('/riwayat-peminjaman', [RiwayatController::class, 'riwayatPinjam'])->name('riwayat.pinjam');

//Riwayat pengguna
Route::get('/riwayat-pengguna', [PeminjamanController::class, 'riwayatPengguna'])->name('riwayat.pengguna');

//kelola pengguna
Route::get('/kelolapengguna', [KelolaPenggunaController::class, 'index'])->name('kelolapengguna.index');
Route::put('/kelola-pengguna/{id}', [KelolaPenggunaController::class, 'update'])->name('kelolapengguna.update');
Route::delete('/kelola-pengguna/{id}', [KelolaPenggunaController::class, 'destroy'])->name('kelolapengguna.destroy');

//lokasi
Route::get('/lokasi', [LokasiController::class, 'show'])->name('lokasi');
Route::post('/lokasi', [LokasiController::class, 'store'])->name('lokasi.store');
Route::put('/lokasi/{id}', [LokasiController::class, 'update'])->name('lokasi.update');
Route::delete('/lokasi/{id}', [LokasiController::class, 'destroy'])->name('lokasi.destroy');

//kategori
Route::get('/kategori', [KategoriBarangController::class, 'index'])->name('kategori.index');
Route::post('/kategori', [KategoriBarangController::class, 'store'])->name('kategori.store');
Route::put('/kategori/{id}', [KategoriBarangController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/{id}', [KategoriBarangController::class, 'destroy'])->name('kategori.destroy');

// Tampilkan halaman laporan
Route::get('/laporan', [DataBarangController::class, 'index'])->name('laporan');

// Download laporan dalam format PDF (hanya PDF, tanpa parameter format)
Route::get('/laporan/download', [DataBarangController::class, 'downloadLaporan'])->name('laporan.download');

//setting
Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
Route::post('/setting/update', [SettingController::class, 'update'])->name('setting.update');

//Setting pengguna
Route::get('/setting/pengguna', [SettingController::class, 'settingPengguna'])->name('setting.pengguna');
Route::post('/setting/pengguna/update', [SettingController::class, 'updatePengguna'])->name('setting.pengguna.update');

// logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
