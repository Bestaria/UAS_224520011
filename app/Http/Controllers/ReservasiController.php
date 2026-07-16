<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    // Membaca data reservasi
    private function getData()
    {
        $path = storage_path('app/reservasi.json');

        if (!file_exists($path)) {
            file_put_contents($path, json_encode([]));
        }

        return json_decode(file_get_contents($path), true);
    }

    // Menyimpan data reservasi
    private function saveData($data)
    {
        file_put_contents(
            storage_path('app/reservasi.json'),
            json_encode($data, JSON_PRETTY_PRINT)
        );
    }

    // Simpan Reservasi
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'lapangan' => 'required',
            'tanggal' => 'required|date',
            'durasi' => 'required|numeric|min:1',
            'harga' => 'required|numeric',
            'bukti' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Harga awal
        $harga = $request->harga;

        // Cek hari (Sabtu=6, Minggu=7)
        $hari = date('N', strtotime($request->tanggal));

        // Tambahan 50% jika akhir pekan
        if ($hari == 6 || $hari == 7) {
            $harga = $harga * 1.5;
        }

        // Hitung total
        $total = $harga * $request->durasi;

        // Diskon 10% jika durasi minimal 3 jam
        if ($request->durasi >= 3) {
            $total = $total * 0.9;
        }

        // Upload bukti transfer
        $namaFile = time() . '.' . $request->bukti->extension();

        $request->bukti->move(
            public_path('transfer'),
            $namaFile
        );

        // Ambil data lama
        $data = $this->getData();

        // ID otomatis
        $id = empty($data) ? 1 : max(array_column($data, 'id')) + 1;

        // Simpan data baru
        $data[] = [
            'id' => $id,
            'nama' => $request->nama,
            'lapangan' => $request->lapangan,
            'tanggal' => $request->tanggal,
            'durasi' => $request->durasi,
            'harga_per_jam' => $harga,
            'total_bayar' => $total,
            'bukti' => $namaFile,
            'status' => 'Menunggu Konfirmasi'
        ];

        $this->saveData($data);

        return redirect('/reservasi')
            ->with('success', 'Reservasi berhasil dibuat. Total Bayar: Rp ' . number_format($total, 0, ',', '.'));
    }

    // Menampilkan daftar reservasi
    public function index()
    {
        $reservasi = $this->getData();

        return view('reservasi.index', compact('reservasi'));
    }

    // Mengubah status reservasi
    public function status($id, $status)
    {
        $data = $this->getData();

        foreach ($data as $key => $item) {

            if ($item['id'] == $id) {

                $data[$key]['status'] = $status;
            }
        }

        $this->saveData($data);

        return redirect('/reservasi')
            ->with('success', 'Status reservasi berhasil diperbarui.');
    }
}