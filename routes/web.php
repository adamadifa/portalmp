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
use App\Http\Controllers\BpbjController;
use App\Http\Controllers\FsthpController;
use App\Http\Controllers\LaporanproduksiController;
use App\Http\Controllers\RepackgudangjadiController;
use App\Http\Controllers\RejectgudangjadiController;
use App\Http\Controllers\LainnyagudangjadiController;
use App\Http\Controllers\LaporangudangjadiController;
use App\Http\Controllers\BarangkeluargudangbahanController;
use App\Http\Controllers\BarangmasukgudangbahanController;
use App\Http\Controllers\LaporangudangbahanController;
use App\Http\Controllers\OpnamegudangbahanController;
use App\Http\Controllers\SaldoawalgudangbahanController;
use App\Http\Controllers\SaldoawalhargagudangbahanController;
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

    // Produksi - BPBJ
    Route::get('/bpbj', [BpbjController::class, 'index'])->name('bpbj.index');
    Route::get('/bpbj/create', [BpbjController::class, 'create'])->name('bpbj.create');
    Route::post('/bpbj', [BpbjController::class, 'store'])->name('bpbj.store');
    Route::delete('/bpbj/{no_mutasi}', [BpbjController::class, 'destroy'])->name('bpbj.delete');
    Route::get('/bpbj/{no_mutasi}/show', [BpbjController::class, 'show'])->name('bpbj.show');
    Route::post('/bpbj/storedetailtemp', [BpbjController::class, 'storedetailtemp'])->name('bpbj.storedetailtemp');
    Route::get('/bpbj/{kode_produk}/getdetailtemp', [BpbjController::class, 'getdetailtemp'])->name('bpbj.getdetailtemp');
    Route::post('/bpbj/generatenobpbj', [BpbjController::class, 'generatenobpbj'])->name('bpbj.generatenobpbj');
    Route::post('/bpbj/deletetemp', [BpbjController::class, 'deletetemp'])->name('bpbj.deletetemp');
    Route::post('/bpbj/cekdetailtemp', [BpbjController::class, 'cekdetailtemp'])->name('bpbj.cekdetailtemp');

    // Produksi - FSTHP
    Route::get('/fsthp', [FsthpController::class, 'index'])->name('fsthp.index');
    Route::get('/fsthpgudang', [FsthpController::class, 'index_gudang'])->name('fsthpgudang.index');
    Route::get('/fsthp/create', [FsthpController::class, 'create'])->name('fsthp.create');
    Route::post('/fsthp', [FsthpController::class, 'store'])->name('fsthp.store');
    Route::delete('/fsthp/{no_mutasi}', [FsthpController::class, 'destroy'])->name('fsthp.delete');
    Route::get('/fsthp/{no_mutasi}/show', [FsthpController::class, 'show'])->name('fsthp.show');
    Route::get('/fsthp/{no_mutasi}/approve', [FsthpController::class, 'approve'])->name('fsthp.approve');
    Route::delete('/fsthp/{no_mutasi}/cancel', [FsthpController::class, 'cancel'])->name('fsthp.cancel');
    Route::post('/fsthp/generatenofsthp', [FsthpController::class, 'generatenofsthp'])->name('fsthp.generatenofsthp');

    // Produksi - Laporan
    Route::get('/laporanproduksi', [LaporanproduksiController::class, 'index'])->name('laporanproduksi.index');
    Route::post('/laporanproduksi/cetakmutasiproduksi', [LaporanproduksiController::class, 'cetakmutasiproduksi'])->name('cetakmutasiproduksi');
    Route::post('/laporanproduksi/cetakrekapmutasiproduksi', [LaporanproduksiController::class, 'cetakrekapmutasiproduksi'])->name('cetakrekapmutasiproduksi');

    // Gudang Jadi - Repack
    Route::get('/repackgudangjadi', [RepackgudangjadiController::class, 'index'])->name('repackgudangjadi.index');
    Route::get('/repackgudangjadi/create', [RepackgudangjadiController::class, 'create'])->name('repackgudangjadi.create');
    Route::post('/repackgudangjadi', [RepackgudangjadiController::class, 'store'])->name('repackgudangjadi.store');
    Route::get('/repackgudangjadi/{no_mutasi}/show', [RepackgudangjadiController::class, 'show'])->name('repackgudangjadi.show');
    Route::get('/repackgudangjadi/{no_mutasi}/edit', [RepackgudangjadiController::class, 'edit'])->name('repackgudangjadi.edit');
    Route::post('/repackgudangjadi/{no_mutasi}/update', [RepackgudangjadiController::class, 'update'])->name('repackgudangjadi.update');
    Route::delete('/repackgudangjadi/{no_mutasi}', [RepackgudangjadiController::class, 'destroy'])->name('repackgudangjadi.delete');

    // Gudang Jadi - Reject
    Route::get('/rejectgudangjadi', [RejectgudangjadiController::class, 'index'])->name('rejectgudangjadi.index');
    Route::get('/rejectgudangjadi/create', [RejectgudangjadiController::class, 'create'])->name('rejectgudangjadi.create');
    Route::post('/rejectgudangjadi', [RejectgudangjadiController::class, 'store'])->name('rejectgudangjadi.store');
    Route::get('/rejectgudangjadi/{no_mutasi}/show', [RejectgudangjadiController::class, 'show'])->name('rejectgudangjadi.show');
    Route::get('/rejectgudangjadi/{no_mutasi}/edit', [RejectgudangjadiController::class, 'edit'])->name('rejectgudangjadi.edit');
    Route::post('/rejectgudangjadi/{no_mutasi}/update', [RejectgudangjadiController::class, 'update'])->name('rejectgudangjadi.update');
    Route::delete('/rejectgudangjadi/{no_mutasi}', [RejectgudangjadiController::class, 'destroy'])->name('rejectgudangjadi.delete');

    // Gudang Jadi - Lainnya
    Route::get('/lainnyagudangjadi', [LainnyagudangjadiController::class, 'index'])->name('lainnyagudangjadi.index');
    Route::get('/lainnyagudangjadi/create', [LainnyagudangjadiController::class, 'create'])->name('lainnyagudangjadi.create');
    Route::post('/lainnyagudangjadi', [LainnyagudangjadiController::class, 'store'])->name('lainnyagudangjadi.store');
    Route::get('/lainnyagudangjadi/{no_mutasi}/show', [LainnyagudangjadiController::class, 'show'])->name('lainnyagudangjadi.show');
    Route::get('/lainnyagudangjadi/{no_mutasi}/edit', [LainnyagudangjadiController::class, 'edit'])->name('lainnyagudangjadi.edit');
    Route::post('/lainnyagudangjadi/{no_mutasi}/update', [LainnyagudangjadiController::class, 'update'])->name('lainnyagudangjadi.update');
    Route::delete('/lainnyagudangjadi/{no_mutasi}', [LainnyagudangjadiController::class, 'destroy'])->name('lainnyagudangjadi.delete');

    // Gudang Jadi - Laporan
    Route::get('/laporangudangjadi', [LaporangudangjadiController::class, 'index'])->name('laporangudangjadi.index');
    Route::post('/laporangudangjadi/cetakpersediaan', [LaporangudangjadiController::class, 'cetakpersediaan'])->name('laporangudangjadi.cetakpersediaan');
    Route::post('/laporangudangjadi/cetakrekappersediaan', [LaporangudangjadiController::class, 'cetakrekappersediaan'])->name('laporangudangjadi.cetakrekappersediaan');
    Route::post('/laporangudangjadi/cetakrekaphasilproduksi', [LaporangudangjadiController::class, 'cetakrekaphasilproduksi'])->name('laporangudangjadi.cetakrekaphasilproduksi');
    Route::post('/laporangudangjadi/cetakrekappengeluaran', [LaporangudangjadiController::class, 'cetakrekappengeluaran'])->name('laporangudangjadi.cetakrekappengeluaran');
    Route::post('/laporangudangjadi/cetakrealisasikiriman', [LaporangudangjadiController::class, 'cetakrealisasikiriman'])->name('laporangudangjadi.cetakrealisasikiriman');

    // Gudang Bahan - Barang Masuk
    Route::controller(BarangmasukgudangbahanController::class)->group(function () {
        Route::get('/barangmasukgudangbahan', 'index')->name('barangmasukgudangbahan.index');
        Route::get('/barangmasukgudangbahan/create', 'create')->name('barangmasukgudangbahan.create');
        Route::get('/barangmasukgudangbahan/{no_bukti}/edit', 'edit')->name('barangmasukgudangbahan.edit');
        Route::put('/barangmasukgudangbahan/{no_bukti}/update', 'update')->name('barangmasukgudangbahan.update');
        Route::post('/barangmasukgudangbahan', 'store')->name('barangmasukgudangbahan.store');
        Route::delete('/barangmasukgudangbahan/{no_bukti}', 'destroy')->name('barangmasukgudangbahan.delete');
        Route::get('/barangmasukgudangbahan/{no_bukti}/show', 'show')->name('barangmasukgudangbahan.show');
    });

    // Gudang Bahan - Barang Keluar
    Route::controller(BarangkeluargudangbahanController::class)->group(function () {
        Route::get('/barangkeluargudangbahan', 'index')->name('barangkeluargudangbahan.index');
        Route::get('/barangkeluargudangbahan/create', 'create')->name('barangkeluargudangbahan.create');
        Route::get('/barangkeluargudangbahan/{no_bukti}/edit', 'edit')->name('barangkeluargudangbahan.edit');
        Route::put('/barangkeluargudangbahan/{no_bukti}/update', 'update')->name('barangkeluargudangbahan.update');
        Route::post('/barangkeluargudangbahan', 'store')->name('barangkeluargudangbahan.store');
        Route::delete('/barangkeluargudangbahan/{no_bukti}', 'destroy')->name('barangkeluargudangbahan.delete');
        Route::get('/barangkeluargudangbahan/{no_bukti}/show', 'show')->name('barangkeluargudangbahan.show');
    });

    // Gudang Bahan - Saldo Awal
    Route::controller(SaldoawalgudangbahanController::class)->group(function () {
        Route::get('/sagudangbahan', 'index')->name('sagudangbahan.index');
        Route::get('/sagudangbahan/create', 'create')->name('sagudangbahan.create');
        Route::post('/sagudangbahan', 'store')->name('sagudangbahan.store');
        Route::delete('/sagudangbahan/{kode_saldo_awal}', 'destroy')->name('sagudangbahan.delete');
        Route::get('/sagudangbahan/{kode_saldo_awal}/show', 'show')->name('sagudangbahan.show');
        Route::post('/sagudangbahan/getdetailsaldo', 'getdetailsaldo')->name('sagudangbahan.getdetailsaldo');
    });

    // Gudang Bahan - Saldo Awal Harga
    Route::controller(SaldoawalhargagudangbahanController::class)->group(function () {
        Route::get('/sahargagb', 'index')->name('sahargagb.index');
        Route::get('/sahargagb/create', 'create')->name('sahargagb.create');
        Route::post('/sahargagb', 'store')->name('sahargagb.store');
        Route::delete('/sahargagb/{kode_saldo_awal}', 'destroy')->name('sahargagb.delete');
        Route::get('/sahargagb/{kode_saldo_awal}/show', 'show')->name('sahargagb.show');
        Route::post('/sahargagb/getdetailsaldo', 'getdetailsaldo')->name('sahargagb.getdetailsaldo');
    });

    // Gudang Bahan - Opname
    Route::controller(OpnamegudangbahanController::class)->group(function () {
        Route::get('/opgudangbahan', 'index')->name('opgudangbahan.index');
        Route::get('/opgudangbahan/create', 'create')->name('opgudangbahan.create');
        Route::post('/opgudangbahan', 'store')->name('opgudangbahan.store');
        Route::delete('/opgudangbahan/{kode_opname}', 'destroy')->name('opgudangbahan.delete');
        Route::get('/opgudangbahan/{kode_opname}/show', 'show')->name('opgudangbahan.show');
        Route::get('/opgudangbahan/{kode_opname}/edit', 'edit')->name('opgudangbahan.edit');
        Route::post('/opgudangbahan/getdetailsaldo', 'getdetailsaldo')->name('opgudangbahan.getdetailsaldo');
    });

    // Gudang Bahan - Laporan
    Route::controller(LaporangudangbahanController::class)->group(function () {
        Route::get('/laporangudangbahan', 'index')->name('laporangudangbahan.index');
        Route::post('/laporangudangbahan/cetakbarangmasuk', 'cetakbarangmasuk')->name('laporangudangbahan.cetakbarangmasuk');
        Route::post('/laporangudangbahan/cetakbarangkeluar', 'cetakbarangkeluar')->name('laporangudangbahan.cetakbarangkeluar');
        Route::post('/laporangudangbahan/cetakpersediaan', 'cetakpersediaan')->name('laporangudangbahan.cetakpersediaan');
        Route::post('/laporangudangbahan/cetakrekappersediaan', 'cetakrekappersediaan')->name('laporangudangbahan.cetakrekappersediaan');
        Route::post('/laporangudangbahan/cetakkartugudang', 'cetakkartugudang')->name('laporangudangbahan.cetakkartugudang');
    });
});

require __DIR__.'/auth.php';
