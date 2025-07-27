<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\PenggunaanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\LaporanController;

// Login Admin
Route::get('/login-admin', [AuthController::class, 'showAdminLogin'])->name('login.admin');
Route::post('/login-admin', [AuthController::class, 'adminLogin'])->name('login.admin');
Route::get('/logout-admin', [AuthController::class, 'adminLogout'])->name('logout.admin');

// Laporan tagihan per pelanggan
Route::get('/laporan/pelanggan/{id}', [LaporanController::class, 'pelanggan'])->name('laporan.pelanggan');
// Laporan tagihan per bulan
Route::get('/laporan/bulan', [LaporanController::class, 'bulan'])->name('laporan.bulan');
// Laporan semua tagihan
Route::get('/laporan/semua', [LaporanController::class, 'semua'])->name('laporan.semua');


// Pendaftaran Pelanggan
use App\Http\Controllers\RegisterPelangganController;
Route::get('/daftar', [RegisterPelangganController::class, 'showForm'])->name('register.pelanggan');
Route::post('/daftar', [RegisterPelangganController::class, 'submit'])->name('register.pelanggan.submit');

// Login Pelanggan
Route::get('/login-pelanggan', [AuthController::class, 'showPelangganLogin'])->name('login.pelanggan');
Route::post('/login-pelanggan', [AuthController::class, 'pelangganLogin'])->name('login.pelanggan');
Route::get('/logout-pelanggan', [AuthController::class, 'pelangganLogout'])->name('logout.pelanggan');

// Group route untuk admin
Route::middleware('admin')->group(function () {
    Route::resource('pembayaran', PembayaranController::class);
    Route::get('pembayaran/{id}', [PembayaranController::class, 'show'])->name('pembayaran.show');
    Route::post('pembayaran/{id}/clear-bukti', [PembayaranController::class, 'clearBukti'])->name('pembayaran.clearBukti');
    Route::resource('tagihan', TagihanController::class);
    Route::resource('penggunaan', PenggunaanController::class);
    Route::get('penggunaan/meter-akhir/{id}', [PenggunaanController::class, 'meterAkhir']);
    Route::resource('pelanggan', PelangganController::class);
    Route::resource('tarif', TarifController::class);
    Route::resource('user', UserController::class);
    Route::resource('level', LevelController::class);
    Route::get('/dashboard-admin', [App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard.admin');
});

// Group route untuk pelanggan
Route::middleware('pelanggan')->group(function () {
    Route::get('/dashboard-pelanggan', [App\Http\Controllers\PelangganDashboardController::class, 'index'])->name('dashboard.pelanggan');
    // Tambahkan route pembayaran/tagihan khusus pelanggan di sini jika perlu
});

// Redirect root ke login admin
Route::get('/', function () {
    return redirect()->route('login.admin');
});
