<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TugasController;
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

// Route::get('/dashboard', function () {
//     return view('index');
// });


Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:admin', 'admin.role:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.index'); // Buat file Blade ini
        })->name('admin.dashboard');
        Route::post('/check-username', [GuruController::class, 'checkUsername'])->name('check.username');

        Route::get('/siswa/dashboard', [SiswaController::class, 'index'])->name('siswa.dashboard');
        Route::get('/siswa/tambah', [SiswaController::class, 'tambahSiswa'])->name('siswa.tambah');
        Route::post('/siswa/tambah', [SiswaController::class, 'tambahSiswaStore'])->name('siswa.store');
        Route::post('/check-siswa', [SiswaController::class, 'checkUsername'])->name('siswa.check');

        //mapel
        Route::get('/mapel/tambah', [SiswaController::class, 'tambahMapel'])->name('mapel.tambah');
        Route::POST('/mapel/tambah', [SiswaController::class, 'tambahMapelStore'])->name('mapel.store');


        //tugas
        Route::get('/tugas/dashboard', [TugasController::class, 'index'])->name('tugas.dashboard');
        Route::get('/tugas/tambah', [TugasController::class, 'create'])->name('tugas.tambah');
        Route::post('/tugas/tambah', [TugasController::class, 'store'])->name('tugas.store');

        Route::get('/guru/dashboard', [GuruController::class, 'index'])->name('guru.dashboard');
        Route::get('/guru/tambah', [GuruController::class, 'create'])->name('guru.tambah');
        Route::post('/guru/tambah/coy', [GuruController::class, 'store'])->name('guru.store');
        //kelas
        Route::get('/kelas/dashboard', [SiswaController::class, 'indexKelas'])->name('kelas.index');
        Route::get('/kelas/tambah', [SiswaController::class, 'tambahKelas'])->name('kelas.tambah');
        Route::post('/kelas/tambah', [SiswaController::class, 'tambahKelasStore'])->name('kelas.store');
        //jurusan
        Route::get('/jurusan/tambah', [SiswaController::class, 'tambahJurusan'])->name('jurusan.tambah');
        Route::POST('/jurusan/tambah', [SiswaController::class, 'tambahJurusanStore'])->name('jurusan.store');
        //group / kelompok
        Route::get('/group/dashboard', [SiswaController::class, 'indexGroup'])->name('group.index');
        Route::get('/group/tambah', [SiswaController::class, 'tambahgroup'])->name('group.tambah');
        Route::POST('/group/tambah', [SiswaController::class, 'tambahgroupStore'])->name('group.store');
    });

});


Route::middleware(['auth:admin', 'admin.role:guru'])->group(function () {

});

Route::middleware(['auth:admin', 'admin.role:siswa'])->group(function () {
    Route::get('/halaman/siswa', [SiswaController::class, 'halamanSiswa'])->name('siswa.index');
    Route::get('/tugas', [TugasController::class, 'tugasSiswa'])->name('tugas.siswa');
    Route::post('/tugas/{id}/upload', [TugasController::class, 'uploadJawaban'])->name('upload.jawaban');
    Route::post('/tugas/{id}/diskusi', [DiskusiController::class, 'kirimPesan'])->name('diskusi.kirim');

});
// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
