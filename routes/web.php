<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\dashboard;
use App\Http\Controllers\masterdata\staffController;
use App\Http\Controllers\masterdata\TahunAjaranController;
use App\Http\Controllers\masterdata\KelasController;
use App\Http\Controllers\masterdata\SiswaController;
use App\Http\Controllers\masterdata\naik_KelasController;
use App\Http\Controllers\aturPembayaran\JenisPembayaranController;
use App\Http\Controllers\aturPembayaran\SettingBulananController;
use App\Http\Controllers\aturPembayaran\SettingTahunanController;
use App\Http\Controllers\aturPembayaran\settingPtambahanController;
use App\Http\Controllers\transaksi\CetakStrukController;
use App\Http\Controllers\transaksi\transaksiController;
use App\Http\Controllers\laporan\rekapController;
use App\Http\Controllers\laporan\riwayatTransaksiConteroller;
use App\Http\Controllers\aturPembayaran\metodeController;
use App\Http\Controllers\ExportController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome2');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [dashboard::class, 'index'])->name('dashboard');

    //Staff
    Route::get('staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('staff/store', [StaffController::class, 'store'])->name('staff.store');
    Route::get('staff/edit/{id}', [StaffController::class, 'edit'])->name('staff.edit');
    Route::put('staff/update/{id}', [StaffController::class, 'update'])->name('staff.update');
    Route::delete('staff/destroy/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');

    //tahun ajaran
    Route::get('/tahun_ajaran', [TahunAjaranController::class, 'index'])->name('tahun_ajaran.index');
    Route::post('tahun_ajaran/store', [TahunAjaranController::class, 'store'])->name('tahun_ajaran.store');
    Route::get('tahun_ajaran/create', [TahunAjaranController::class, 'create'])->name('tahun_ajaran.create');
    Route::get('tahun_ajaran/edit/{id}', [TahunAjaranController::class, 'edit'])->name('tahun_ajaran.edit');
    Route::put('tahun_ajaran/update/{id}', [TahunAjaranController::class, 'update'])->name('tahunajaran.update');
    Route::delete('tahun_ajaran/destroy/{id}', [TahunAjaranController::class, 'destroy'])->name('tahun_ajaran.destroy');

    //Kelas
    Route::get('kelas', [KelasController::class, 'DaftarKelas'])->name('kelas.index');
    Route::post('kelas/store', [KelasController::class, 'SimpanKelas'])->name('kelas.store');
    Route::get('kelas/create', [KelasController::class, 'create'])->name('kelas.create');
    Route::get('kelas/edit/{id}', [KelasController::class, 'edit'])->name('kelas.edit');
    Route::put('kelas/update/{id}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('kelas/destroy/{id}', [KelasController::class, 'destroy'])->name('kelas.destroy');

    //Siswa
    Route::get('siswa', [SiswaController::class, 'index'])->name('siswa.index');
    Route::get('siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
    Route::post('siswa/store', [SiswaController::class, 'store'])->name('siswa.store');
    Route::post('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import');
    Route::get('siswa/edit/{nis}', [SiswaController::class, 'edit'])->name('siswa.edit');
    Route::put('siswa/update/{nis}', [SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('siswa/destroy/{nis}', [SiswaController::class, 'destroy'])->name('siswa.destroy');

    //Naik Kelas
    Route::get('/naik-kelas', [naik_KelasController::class, 'index'])->name('naik_kelas.index');
    Route::get('/naik-kelas/siswa/{id}', [naik_KelasController::class, 'getSiswaByKelas']);
    Route::post('/naik-kelas/simpan', [naik_KelasController::class, 'simpan'])->name('naik_kelas.simpan');

    //Jenis Pembayaran
  Route::get('jenis-pembayaran', [JenisPembayaranController::class, 'index'])->name('jenis-pembayaran.index');
  Route::get('jenis-pembayaran/create', [JenisPembayaranController::class, 'create'])->name('jenis-pembayaran.create');
  Route::post('jenis-pembayaran/store', [JenisPembayaranController::class, 'store'])->name('jenis-pembayaran.store');
    Route::get('jenis-pembayaran/edit/{jenis_pembayaran}', [JenisPembayaranController::class, 'edit'])
        ->name('jenis-pembayaran.edit');
    Route::put('jenis-pembayaran/update/{jenis_pembayaran}', [JenisPembayaranController::class, 'update'])->name('jenis-pembayaran.update');
  Route::delete('jenis-pembayaran/destroy/{id}', [JenisPembayaranController::class, 'destroy'])->name('jenis-pembayaran.destroy');

 // Route::resource('jenis-pembayaran', JenisPembayaranController::class)
  //      ->except(['show'])
 //       ->names([
 //           'index' => 'jenis-pembayaran.index',
 //           'create' => 'jenis-pembayaran.create',
 //           'store' => 'jenis-pembayaran.store',
  //          'edit' => 'jenis-pembayaran.edit',
 //           'update' => 'jenis-pembayaran.update',
  //          'destroy' => 'jenis-pembayaran.destroy',
   //     ]);


    //Metode Bayar
    Route::get('metode', [metodeController::class, 'index'])->name('metode.index');
    Route::post('metode/store', [metodeController::class, 'store'])->name('metode.store');
    Route::put('metode/update/{id}', [metodeController::class, 'update'])->name('metode.update');
    Route::delete('metode/destroy/{id}', [metodeController::class, 'destroy'])->name('metode.destroy');


    Route::get('jenis-pembayaran/{id}/setting-tarif', [JenisPembayaranController::class, 'redirectSettingTarif'])->name('jenis-pembayaran.setting-tarif');

    //Route::get('/setting-bulanan/{id}', SettingBulananForm::class)->name('setting-bulanan.form');

    Route::get('setting-bulanan', [SettingBulananController::class, 'index'])->name('setting-bulanan.index');
    Route::post('setting-bulanan/store', [SettingBulananController::class, 'store'])->name('setting-bulanan.store');
    Route::get('setting-bulanan/get-siswa-by-nis', [SettingBulananController::class, 'getByNis'])->name('siswa.getByNis');

    Route::get('setting-bulanan/edit/{id}', [SettingBulananController::class, 'edit'])->name('setting-bulanan.edit');
    Route::put('setting-bulanan/update/{id}', [SettingBulananController::class, 'update'])->name('setting-bulanan.update');
    Route::delete('setting-bulanan/destroy/{nis}/{id}', [SettingBulananController::class, 'destroy'])->name('setting-bulanan.destroy');
    Route::get('/setting-bulanan/show/{nis}', [SettingBulananController::class, 'show'])->name('setting-bulanan.show');


    Route::get('/setting-tahunan', [SettingTahunanController::class, 'index'])->name('setting-tahunan.index');
    Route::get('/setting-tahunan/get-data/{kelasId}', [SettingTahunanController::class, 'getData'])->name('setting-tahunan.get-data');
    Route::post('/setting-tahunan', [SettingTahunanController::class, 'store'])->name('setting-tahunan.store');
    Route::get('/setting-tahunan/edit/{id}', [SettingTahunanController::class, 'edit'])->name('setting-tahunan.edit');
    Route::put('/setting-tahunan/update/{id}', [SettingTahunanController::class, 'update'])->name('setting-tahunan.update');
    Route::delete('/setting-tahunan/destroy/{id}', [SettingTahunanController::class, 'destroy'])->name('setting-tahunan.destroy');
    Route::get('/setting-tahunan/show/{id}', [SettingTahunanController::class, 'show'])->name('setting-tahunan.show');

    Route::post('/setting-tambahan', [settingPtambahanController::class, 'store'])->name('setting-tambahan.tambah');

    Route::get('/kelola-pembayaran', [transaksiController::class, 'index'])->name('kelola-pembayaran.index');
    Route::post('/kelola-pembayaran', [transaksiController::class, 'SimpanTransaksi'])->name('kelola-pembayaran.simpan');

    Route::get('/riwayat-transaksi', [riwayatTransaksiConteroller::class, 'index'])->name('riwayat.index');

    Route::get('/struk/cetak/{id}', [CetakStrukController::class, 'cetakStruk'])->name('cetak-struk');
    Route::get('/struk/unduh/{id}', [CetakStrukController::class, 'unduhStruk'])->name('unduh-struk');

    Route::get('/rekap', [rekapController::class, 'index'])->name('rekap.index');
    Route::get('/export-rekap', [ExportController::class, 'exportRekap'])
        ->name('export.rekap');
});

require __DIR__ . '/auth.php';
