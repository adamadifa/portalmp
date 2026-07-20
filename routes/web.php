<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AngkutanController;
use App\Http\Controllers\TujuanangkutanController;
use App\Http\Controllers\BarangpembelianController;
use App\Http\Controllers\BarangproduksiController;
use App\Http\Controllers\SaldoawalgudangjadiController;
use App\Http\Controllers\SamutasiproduksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Roles & Permissions management
    Route::resource('roles', RoleController::class);
    Route::get('/roles/{id}/createrolepermission', [RoleController::class, 'createrolepermission'])->name('roles.createrolepermission');
    Route::post('/roles/{id}/storerolepermission', [RoleController::class, 'storerolepermission'])->name('roles.storerolepermission');

    // Users management
    Route::resource('users', UserController::class);

    // Master Data - Produk
    Route::resource('produk', ProdukController::class);

    // Master Data - Pelanggan
    Route::resource('pelanggan', PelangganController::class);

    // Master Data - Supplier
    Route::resource('supplier', SupplierController::class);

    // Master Data - Angkutan
    Route::resource('angkutan', AngkutanController::class);

    // Master Data - Tujuan Angkutan
    Route::resource('tujuanangkutan', TujuanangkutanController::class);

    // Master Data - Barang
    Route::resource('barangpembelian', BarangpembelianController::class);
    Route::post('/barangpembelian/getbarangbykategori', [BarangpembelianController::class, 'getbarangbykategori']);
    Route::get('/barangpembelian/{kode_group}/getbarangjson', [BarangpembelianController::class, 'getbarangjson'])->name('barangpembelian.getbarangjson');

    // Master Data - Barang Produksi
    Route::resource('barangproduksi', BarangproduksiController::class);

    // Gudang Jadi - Saldo Awal / Mutasi Produk
    Route::resource('sagudangjadi', SaldoawalgudangjadiController::class);
    Route::post('/sagudangjadi/getdetailsaldo', [SaldoawalgudangjadiController::class, 'getdetailsaldo'])->name('sagudangjadi.getdetailsaldo');

    // Produksi - Saldo Awal Mutasi Produksi
    Route::get('/samutasiproduksi', [SamutasiproduksiController::class, 'index'])->name('samutasiproduksi.index');
    Route::get('/samutasiproduksi/create', [SamutasiproduksiController::class, 'create'])->name('samutasiproduksi.create');
    Route::post('/samutasiproduksi', [SamutasiproduksiController::class, 'store'])->name('samutasiproduksi.store');
    Route::delete('/samutasiproduksi/{kode_saldo_awal}', [SamutasiproduksiController::class, 'destroy'])->name('samutasiproduksi.destroy');
    Route::get('/samutasiproduksi/{kode_saldo_awal}/show', [SamutasiproduksiController::class, 'show'])->name('samutasiproduksi.show');
    Route::post('/samutasiproduksi/getdetailsaldo', [SamutasiproduksiController::class, 'getdetailsaldo'])->name('samutasiproduksi.getdetailsaldo');
});

require __DIR__.'/auth.php';
