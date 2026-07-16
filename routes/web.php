<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\LoginController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/lapangan', [LapanganController::class, 'index']);
Route::post('/reservasi', [ReservasiController::class, 'store']);
Route::post('/login', [LoginController::class, 'login']);

Route::get('/login',[LoginController::class,'index']);
Route::get('/logout',[LoginController::class,'logout']);

Route::get('/lapangan/create', [LapanganController::class, 'create']);
Route::post('/lapangan/store', [LapanganController::class, 'store']);
Route::get('/lapangan/show/{id}', [LapanganController::class, 'show']);
Route::get('/lapangan/edit/{id}', [LapanganController::class, 'edit']);
Route::post('/lapangan/update/{id}', [LapanganController::class, 'update']);
Route::get('/lapangan/delete/{id}', [LapanganController::class, 'destroy']);

Route::get('/reservasi', function () {
    $reservasi = json_decode(
        file_get_contents(storage_path('app/reservasi.json')),
        true
    );
    return view('reservasi.index', compact('reservasi'));
});
Route::post('/reservasi/store', [ReservasiController::class, 'store']);

use Illuminate\Support\Facades\File;

Route::get('/reservasi/create', function () {

    $lapangan = json_decode(
        File::get(storage_path('app/lapangan.json')),
        true
    );

    return view('reservasi.create', compact('lapangan'));

});

Route::get('/reservasi', [ReservasiController::class,'index']);
Route::post('/reservasi/store', [ReservasiController::class,'store']);
Route::get('/reservasi/status/{id}/{status}', [ReservasiController::class,'status']);

Route::get('/dashboard', function () {

    if (!session('login')) {
        return redirect('/login');
    }

    if (session('role') != 'admin') {
        abort(403);
    }
    return view('dashboard');
});

Route::get('/lapangan/pdf', [LapanganController::class,'exportPDF']);
Route::get('/pesanan', [ReservasiController::class, 'pesananSaya']);
