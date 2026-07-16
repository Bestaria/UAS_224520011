<?php

use Illuminate\Support\Facades\Route;

Route::get('/lapangan', function () {
    return response()->json([
        [
            'id' => 1,
            'nama_lapangan' => 'Lapangan Futsal A',
            'harga_per_jam' => 100000,
            'foto' => 'lapanganA.jpg'
        ],
        [
            'id' => 2,
            'nama_lapangan' => 'Lapangan Futsal B',
            'harga_per_jam' => 120000,
            'foto' => 'lapanganB.jpg'
        ]
    ]);
});

Route::post('/login', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Login berhasil',
        'token' => 'token123456'
    ]);
});

Route::get('/reservasi', function () {
    return response()->json([
        [
            'id' => 1,
            'nama_member' => 'Budi',
            'lapangan' => 'Lapangan Futsal A',
            'tanggal' => '2026-07-20',
            'durasi' => 2,
            'total_bayar' => 200000,
            'status' => 'Menunggu Konfirmasi'
        ]
    ]);
});