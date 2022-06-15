<?php

use App\Http\Controllers\AgamaController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\KodeposController;
use App\Http\Controllers\NeedsController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\PriodikSiswaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::get('/notifikasi', [LoginController::class, 'notifikasi'])->name('notifikasi');
Route::get('/verifikasi/{id}', [LoginController::class, 'verifikasi'])->name('verifikasi');
Route::get('/recovery', [LoginController::class, 'recovery'])->name('recovery');
Route::get('/reverify', [LoginController::class, 'reverify'])->name('reverify');
Route::get('/reset/{id}', [LoginController::class, 'reset'])->name('reset');

Route::group(
    [
        'prefix'     => 'login'
    ],
    function () {
        Route::post('/proses', [LoginController::class, 'authenticate'])->name('login.proses');
        Route::post('/logout', [LoginController::class, 'logout'])->name('login.logout');
        Route::post('/store', [LoginController::class, 'store'])->name('login.store');
        Route::post('/confirmasi', [LoginController::class, 'confirmasi'])->name('login.confirmasi');
        Route::post('/reverifycode', [LoginController::class, 'reverifycode'])->name('login.reverifycode');
        Route::post('/resetcode', [LoginController::class, 'resetcode'])->name('login.resetcode');
        Route::post('/newpassword', [LoginController::class, 'newpassword'])->name('login.newpassword');
        Route::post('/logout', [LoginController::class, 'logout'])->name('login.logout');
    }
);

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/phpinfo', [DashboardController::class, 'phpinfo'])->name('phpinfo');

Route::group(
    [
        'prefix' => 'employee',
        'middleware' => 'auth',
    ],
    function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('employee');
        Route::get('/create', [EmployeeController::class, 'create'])->name('employee.create');
        Route::post('/store', [EmployeeController::class, 'store'])->name('employee.store');
        Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
        Route::post('/update', [EmployeeController::class, 'update'])->name('employee.update');
        Route::delete('/destroy/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
        Route::get('/show/{id}', [EmployeeController::class, 'show'])->name('employee.show');
        Route::post('/dokumen', [EmployeeController::class, 'dokumen'])->name('employee.dokumen');
        Route::get('/ijazah/{id}', [EmployeeController::class, 'ijazah'])->name('employee.ijazah');
        Route::get('/create_ijazah/{id}', [EmployeeController::class, 'create_ijazah'])->name('employee.create_ijazah');
        Route::post('/store_ijazah', [EmployeeController::class, 'store_ijazah'])->name('employee.store_ijazah');
        Route::get('/edit_ijazah/{id}', [EmployeeController::class, 'edit_ijazah'])->name('employee.edit_ijazah');
        Route::post('/update_ijazah', [EmployeeController::class, 'update_ijazah'])->name('employee.update_ijazah');
        Route::post('/show_ijazah', [EmployeeController::class, 'show_ijazah'])->name('employee.show_ijazah');
        Route::delete('/destroy_ijazah', [EmployeeController::class, 'destroy_ijazah'])->name('employee.destroy_ijazah');
        Route::get('/sk/{id}', [EmployeeController::class, 'sk'])->name('employee.sk');
        Route::post('/store_sk', [EmployeeController::class, 'store_sk'])->name('employee.store_sk');
        Route::post('/edit_sk', [EmployeeController::class, 'edit_sk'])->name('employee.edit_sk');
        Route::post('/update_sk', [EmployeeController::class, 'update_sk'])->name('employee.update_sk');
        Route::delete('/destroy_sk', [EmployeeController::class, 'destroy_sk'])->name('employee.destroy_sk');
        Route::get('/child/{id}', [EmployeeController::class, 'child'])->name('employee.child');
        Route::post('/store_child', [EmployeeController::class, 'store_child'])->name('employee.store_child');
        Route::post('/edit_anak', [EmployeeController::class, 'edit_anak'])->name('employee.edit_anak');
        Route::post('/update_anak', [EmployeeController::class, 'update_anak'])->name('employee.update_anak');
        Route::delete('/destroy_anak', [EmployeeController::class, 'destroy_anak'])->name('employee.destroy_anak');
        Route::post('/store_child_dw', [EmployeeController::class, 'store_child_dw'])->name('employee.store_child_dw');
        Route::post('/update_anak_dw', [EmployeeController::class, 'update_anak_dw'])->name('employee.update_anak_dw');
        Route::delete('/destroy_dw', [EmployeeController::class, 'destroy_dw'])->name('employee.destroy_dw');
        Route::get('/riwayat/{id}', [EmployeeController::class, 'riwayat'])->name('employee.riwayat');
        Route::post('/store_riwayat', [EmployeeController::class, 'store_riwayat'])->name('employee.store_riwayat');
        Route::post('/edit_riwayat', [EmployeeController::class, 'edit_riwayat'])->name('employee.edit_riwayat');
        Route::post('/update_riwayat', [EmployeeController::class, 'update_riwayat'])->name('employee.update_riwayat');
        Route::delete('/destroy_riwayat', [EmployeeController::class, 'destroy_riwayat'])->name('employee.destroy_riwayat');
        Route::post('/store_kontak', [EmployeeController::class, 'store_kontak'])->name('employee.store_kontak');
        Route::post('/update_kontak', [EmployeeController::class, 'update_kontak'])->name('employee.update_kontak');
        Route::delete('/destroy_kontak', [EmployeeController::class, 'destroy_kontak'])->name('employee.destroy_kontak');
        Route::post('/dropdown_email_create', [EmployeeController::class, 'dropdown_email_create'])->name('employee.dropdown_email_create');
        Route::post('/dropdown_email', [EmployeeController::class, 'dropdown_email'])->name('employee.dropdown_email');
        Route::post('/get_email', [EmployeeController::class, 'get_email'])->name('employee.get_email');
        Route::post('/cek_ijazah', [EmployeeController::class, 'cek_ijazah'])->name('employee.cek_ijazah');
    }
);

Route::group(
    [
        'prefix'     => 'kodepos',
        'middleware' => 'auth',
    ],
    function () {
        Route::get('/', [KodeposController::class, 'index'])->name('kodepos');
        Route::get('/create', [KodeposController::class, 'create'])->name('kodepos.create');
        Route::post('/store', [KodeposController::class, 'store'])->name('kodepos.store');
        Route::get('/edit/{id}', [KodeposController::class, 'edit'])->name('kodepos.edit');
        Route::post('/update', [KodeposController::class, 'update'])->name('kodepos.update');
        Route::get('/destroy', [KodeposController::class, 'destroy'])->name('kodepos.destroy');
        Route::post('/dropdown', [KodeposController::class, 'dropdown'])->name('kodepos.dropdown');
        Route::post('/provinsi', [KodeposController::class, 'provinsi'])->name('kodepos.dropdown.provinsi');
        Route::post('/kota', [KodeposController::class, 'kota'])->name('kodepos.dropdown.kota');
        Route::post('/kecamatan', [KodeposController::class, 'kecamatan'])->name('kodepos.dropdown.kecamatan');
        Route::post('/kelurahan', [KodeposController::class, 'kelurahan'])->name('kodepos.dropdown.kelurahan');
        Route::get('/data_ajax', [KodeposController::class, 'data_ajax'])->name('kodepos.data_ajax');
        Route::get('/get_villages_by_district/{district}', [KodeposController::class, 'get_villages_by_district'])->name('kodepos.get_villages_by_district');
        Route::get('/get_postal_code_by_village/{village}', [KodeposController::class, 'get_postal_code_by_village'])->name('kodepos.get_postal_code_by_village');
    }
);

Route::group(
    [
        'prefix'     => 'agama',
        'middleware' => 'auth',
    ],
    function () {
        Route::get('/', [AgamaController::class, 'index'])->name('agama');
        Route::get('/create', [AgamaController::class, 'create'])->name('agama.create');
        Route::post('/store', [AgamaController::class, 'store'])->name('agama.store');
        Route::get('/edit/{id}', [AgamaController::class, 'edit'])->name('agama.edit');
        Route::patch('/update/{id}', [AgamaController::class, 'update'])->name('agama.update');
        Route::delete('/destroy', [AgamaController::class, 'destroy'])->name('agama.destroy');
        Route::post('/dropdown', [AgamaController::class, 'dropdown'])->name('agama.dropdown');
    }
);

Route::group(
    ['middleware' => 'auth'],
    function () {
        Route::get('/edit_kesejahteraan/{id}', [SiswaController::class, 'edit_kesejahteraan'])->name('siswa.edit_kesejahteraan');
        Route::get('/index_kesejahteraan_siswa/{id}', [SiswaController::class, 'index_kesejahteraan_siswa'])->name('siswa.index_kesejahteraan_siswa');
        Route::get('/edit_scholarship/{id}', [SiswaController::class, 'edit_scholarship'])->name('siswa.edit_scholarship');
        Route::get('/index_beasiswa_student/{id}', [SiswaController::class, 'index_beasiswa_student'])->name('siswa.index_beasiswa_student');
        Route::get('/edit_performance_student/{id}', [SiswaController::class, 'edit_performance_student'])->name('siswa.edit_performance_student');
        Route::get('/list_performance_students/{id}', [SiswaController::class, 'list_performance_students'])->name('siswa.list_performance_students');
        Route::get('/edit_periodic_student/{id}', [SiswaController::class, 'edit_periodic_student'])->name('siswa.edit_periodic_student');
        Route::get('/edit_parent/{id}', [SiswaController::class, 'edit_parent'])->name('siswa.edit_parent');
        Route::get('/add_periodic_student/{student_id}', [SiswaController::class, 'add_periodic_student'])->name('siswa.add_periodic_student');
        Route::get('/show_periodic/{student_id}', [SiswaController::class, 'show_periodic'])->name('siswa.show_periodic');
        Route::get('/show_parents/{student_id}', [SiswaController::class, 'show_parents'])->name('siswa.show_parents');
        Route::get('/add_parent_student/{student_id}/{wali}', [SiswaController::class, 'add_parent_student'])->name('siswa.add_parent_student');
        Route::get('/data_ajax', [AkunController::class, 'data_ajax'])->name('akun.data_ajax');
        Route::get('/confirmasi/{id}', [AkunController::class, 'confirmasi'])->name('akun.confirmasi');
        Route::post('/store_kesejahteraan', [SiswaController::class, 'store_kesejahteraan'])->name('siswa.store_kesejahteraan');
        Route::post('/store_beasiswa', [SiswaController::class, 'store_beasiswa'])->name('siswa.store_beasiswa');
        Route::post('/store_performances', [SiswaController::class, 'store_performances'])->name('siswa.store_performances');
        Route::post('/store_periodic_student', [SiswaController::class, 'store_periodic_student'])->name('siswa.store_periodic_student');
        Route::post('/store_parent_student', [SiswaController::class, 'store_parent_student'])->name('siswa.store_parent_student');
        Route::patch('/update_kesejahteraan/{id}', [SiswaController::class, 'update_kesejahteraan'])->name('siswa.update_kesejahteraan');
        Route::patch('/update_scholarship/{id}', [SiswaController::class, 'update_scholarship'])->name('siswa.update_scholarship');
        Route::patch('/update_performance_student/{id}', [SiswaController::class, 'update_performance_student'])->name('siswa.update_performance_student');
        Route::patch('/update_student_periodic/{id}', [SiswaController::class, 'update_student_periodic'])->name('siswa.update_student_periodic');
        Route::delete('/destroy_kesejahteraan/{id}', [SiswaController::class, 'destroy_kesejahteraan'])->name('siswa.destroy_kesejahteraan');
        Route::delete('/destroy_scholarship/{id}', [SiswaController::class, 'destroy_scholarship'])->name('siswa.destroy_scholarship');
        Route::delete('/destroy_performance_student/{id}', [SiswaController::class, 'destroy_performance_student'])->name('siswa.destroy_performance_student');
        Route::delete('/destroy_periodic_student/{periodic_id}', [SiswaController::class, 'destroy_periodic_student'])->name('siswa.destroy_periodic_student');
        Route::delete('/destroy_parent/{parent_id}', [SiswaController::class, 'destroy_parent'])->name('siswa.destroy_parent');
        Route::resource('/priodik', PriodikSiswaController::class);
        Route::resource('/parents', ParentController::class);
        Route::resource('/needs', NeedsController::class);
        Route::resource('/siswa', SiswaController::class);
        Route::resource('/akun', AkunController::class);
        Route::patch('/save_confirmasi/{id}', [AkunController::class, 'save_confirmasi'])->name('akun.save_confirmasi');
    }
);
