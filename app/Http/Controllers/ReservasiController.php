<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    /**
     * Membaca data reservasi
     */
    private function getData()
    {
        $path = storage_path('app/reservasi.json');

        if (!file_exists($path)) {
            file_put_contents($path, json_encode([]));
        }

        $data = json_decode(file_get_contents($path), true);

        return is_array($data) ? $data : [];
    }

    /**
     * Menyimpan data reservasi
     */
    private function saveData($data)
    {
        file_put_contents(
            storage_path('app/reservasi.json'),
            json_encode($data, JSON_PRETTY_PRINT)
        );
    }

    /**
     * Simpan Reservasi
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required',
            'lapangan'  => 'required',
            'tanggal'   => 'required|date',
            'durasi'    => 'required|numeric|min:1',
            'harga'     => 'required|numeric',
            'bukti'     => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $harga = $request->harga;

        // Sabtu & Minggu tambah 50%
        $hari = date('N', strtotime($request->tanggal));

        if ($hari == 6 || $hari == 7) {
            $harga = $harga * 1.5;
        }

        // Hitung total
        $total = $harga * $request->durasi;

        // Diskon 10% jika minimal 3 jam
        if ($request->durasi >= 3) {
            $total = $total * 0.9;
        }

        // Upload bukti transfer
        $namaFile = time().'.'.$request->bukti->extension();

        $request->bukti->move(
            public_path('transfer'),
            $namaFile
        );

        $data = $this->getData();

        $id = empty($data)
            ? 1
            : max(array_column($data, 'id')) + 1;

        $data[] = [
            'id'             => $id,
            'nama'           => session('nama'),
            'email'          => session('email'),
            'lapangan'       => $request->lapangan,
            'tanggal'        => $request->tanggal,
            'durasi'         => $request->durasi,
            'harga_per_jam'  => $harga,
            'total_bayar'    => $total,
            'bukti'          => $namaFile,
            'status'         => 'Menunggu Konfirmasi'
        ];

        $this->saveData($data);

        return redirect('/reservasi')
            ->with(
                'success',
                'Reservasi berhasil dibuat. Total Bayar Rp ' .
                number_format($total, 0, ',', '.')
            );
    }

    /**
     * Data Reservasi
     */
    public function index()
    {
        $reservasi = $this->getData();

        // Member hanya melihat reservasi miliknya
        if (session('role') != 'admin') {

            $reservasi = array_filter($reservasi, function ($item) {
                return isset($item['email']) &&
                       $item['email'] == session('email');
            });

        }

        return view('reservasi.index', compact('reservasi'));
    }

    /**
     * Pesanan Saya
     */
    public function pesananSaya()
    {
        $data = $this->getData();

        $reservasi = [];

        foreach ($data as $item) {

            if (
                isset($item['email']) &&
                $item['email'] == session('email')
            ) {

                $reservasi[] = $item;
            }
        }

        return view('reservasi.pesanan', compact('reservasi'));
    }

    /**
     * Update Status Reservasi
     */
    public function status($id, $status)
    {
        // Hanya Admin yang boleh mengubah status
        if (session('role') != 'admin') {
            abort(403);
        }

        $data = $this->getData();

        foreach ($data as $key => $item) {

            if ($item['id'] == $id) {

                // Status akhir tidak boleh diubah
                if (
                    $item['status'] == 'Selesai' ||
                    $item['status'] == 'Dibatalkan'
                ) {

                    return back()->with(
                        'error',
                        'Status reservasi tidak dapat diubah lagi.'
                    );
                }

                // Menunggu → Dikonfirmasi / Dibatalkan
                if (
                    $item['status'] == 'Menunggu Konfirmasi' &&
                    in_array($status, ['Dikonfirmasi', 'Dibatalkan'])
                ) {

                    $data[$key]['status'] = $status;
                }

                // Dikonfirmasi → Selesai
                elseif (
                    $item['status'] == 'Dikonfirmasi' &&
                    $status == 'Selesai'
                ) {

                    $data[$key]['status'] = 'Selesai';
                }

                break;
            }
        }

        $this->saveData($data);

        return redirect('/reservasi')
            ->with(
                'success',
                'Status reservasi berhasil diperbarui.'
            );
    }
}