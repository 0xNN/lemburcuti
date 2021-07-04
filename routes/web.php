<?php

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

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

	Route::get('pegawai/populate_user', [App\Http\Controllers\PegawaiController::class, 'populate_user'])->name('pegawai.populate_user');
	Route::get('pegawai/data/result', [App\Http\Controllers\PegawaiController::class, 'get_pegawai'])->name('pegawai.get_pegawai');
	Route::get('pengajuan_lembur/data/print/{id}', [App\Http\Controllers\PengajuanLemburController::class, 'print'])->name('pengajuan_lembur.print');
	Route::get('pengajuan_cuti/data/print/{id}', [App\Http\Controllers\PengajuanCutiController::class, 'print'])->name('pengajuan_cuti.print');
	Route::get('riwayat_lembur/data/print/{kode_pengajuan}', [App\Http\Controllers\RiwayatPengajuanLemburController::class, 'print'])->name('riwayat_lembur.print');
	Route::get('pegawai/get/unit_kerja/{id}', [App\Http\Controllers\PegawaiController::class, 'get_pegawai_per_unit']);
	Route::get('laporan', [App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
	Route::get('laporan/cuti/print/{jenis_cuti_id?}/{tgl_pengajuan?}', [App\Http\Controllers\LaporanController::class, 'print_cuti'])->name('laporan.print_cuti');
	Route::get('laporan/lembur/print/{unit_kerja_id?}/{tgl_pengajuan?}', [App\Http\Controllers\LaporanController::class, 'print_lembur'])->name('laporan.print_lembur');
	Route::resource('pegawai', App\Http\Controllers\PegawaiController::class);
	Route::resource('pendidikan', App\Http\Controllers\PendidikanController::class);
	Route::resource('jabatan', App\Http\Controllers\JabatanController::class);
	Route::resource('bank_legacy', App\Http\Controllers\BankLegacyController::class);
	Route::resource('jenis_cuti', App\Http\Controllers\JenisCutiController::class);
	Route::resource('jenis_cuti_extra', App\Http\Controllers\JenisCutiExtraController::class);
	Route::resource('jurusan', App\Http\Controllers\JurusanController::class);
	Route::resource('maksimum_cuti', App\Http\Controllers\MaksimumCutiController::class);
	Route::resource('penempatan', App\Http\Controllers\PenempatanController::class);
	Route::resource('unit_kerja', App\Http\Controllers\UnitKerjaController::class);
	Route::resource('pengajuan_lembur', App\Http\Controllers\PengajuanLemburController::class);
	Route::resource('pengajuan_cuti', App\Http\Controllers\PengajuanCutiController::class);
	Route::resource('rencana_cuti', App\Http\Controllers\RencanaCutiController::class);
	Route::resource('riwayat_lembur', App\Http\Controllers\RiwayatPengajuanLemburController::class);
	Route::resource('riwayat_cuti', App\Http\Controllers\RiwayatPengajuanCutiController::class);
	Route::resource('status_pegawai', App\Http\Controllers\StatusPegawaiController::class);
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

