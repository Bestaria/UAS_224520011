<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class LapanganController extends Controller
{
    /**
     * Membaca data JSON
     */
    private function getData()
    {
        $path = storage_path('app/lapangan.json');

        if (!File::exists($path)) {
            File::put($path, json_encode([], JSON_PRETTY_PRINT));
        }

        $data = json_decode(File::get($path), true);

        return is_array($data) ? $data : [];
    }

    /**
     * Menyimpan data JSON
     */
    private function saveData($data)
    {
        File::put(
            storage_path('app/lapangan.json'),
            json_encode(array_values($data), JSON_PRETTY_PRINT)
        );
    }

    /**
     * Cek Login
     */
    private function checkLogin()
    {
        if (!session('login')) {
            return redirect('/login')->send();
        }
    }

    /**
     * Cek Admin
     */
    private function checkAdmin()
    {
        $this->checkLogin();

        if (session('role') != 'admin') {
            abort(403, 'Anda tidak memiliki hak akses.');
        }
    }

    /**
     * Daftar Lapangan
     */
    public function index()
    {
        $this->checkLogin();

        $lapangan = $this->getData();

        return view('lapangan.index', compact('lapangan'));
    }

    /**
     * Detail Lapangan
     */
    public function show($id)
    {
        $this->checkLogin();

        foreach ($this->getData() as $item) {

            if ($item['id'] == $id) {

                return view('lapangan.show', [
                    'lapangan' => $item
                ]);
            }
        }

        abort(404);
    }

    /**
     * Form Tambah
     */
    public function create()
    {
        $this->checkAdmin();

        return view('lapangan.create');
    }

    /**
     * Simpan Lapangan
     */
    public function store(Request $request)
    {
        $this->checkAdmin();

        $request->validate([
            'nama_lapangan' => 'required',
            'harga_per_jam' => 'required|numeric',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $this->getData();

        $namaFoto = time().'.'.$request->foto->extension();

        $request->foto->move(public_path('gambar'), $namaFoto);

        $id = empty($data)
            ? 1
            : max(array_column($data,'id')) + 1;

        $data[] = [
            'id' => $id,
            'nama_lapangan' => $request->nama_lapangan,
            'harga_per_jam' => $request->harga_per_jam,
            'foto' => $namaFoto
        ];

        $this->saveData($data);

        return redirect('/lapangan')
            ->with('success','Data lapangan berhasil ditambahkan.');
    }

    /**
     * Form Edit
     */
    public function edit($id)
    {
        $this->checkAdmin();

        foreach ($this->getData() as $item) {

            if ($item['id'] == $id) {

                return view('lapangan.edit', [
                    'lapangan' => $item
                ]);
            }
        }

        abort(404);
    }

    /**
     * Update Lapangan
     */
    public function update(Request $request, $id)
    {
        $this->checkAdmin();

        $request->validate([
            'nama_lapangan'=>'required',
            'harga_per_jam'=>'required|numeric',
            'foto'=>'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $this->getData();

        $ditemukan = false;

        foreach ($data as $key => $item) {

            if ($item['id'] == $id) {

                $ditemukan = true;

                $data[$key]['nama_lapangan'] = $request->nama_lapangan;
                $data[$key]['harga_per_jam'] = $request->harga_per_jam;

                if ($request->hasFile('foto')) {

                    $fotoLama = public_path('gambar/'.$item['foto']);

                    if (File::exists($fotoLama)) {
                        File::delete($fotoLama);
                    }

                    $namaFoto = time().'.'.$request->foto->extension();

                    $request->foto->move(
                        public_path('gambar'),
                        $namaFoto
                    );

                    $data[$key]['foto'] = $namaFoto;
                }

                break;
            }
        }

        if (!$ditemukan) {
            abort(404);
        }

        $this->saveData($data);

        return redirect('/lapangan')
            ->with('success','Data lapangan berhasil diperbarui.');
    }

    /**
     * Hapus Lapangan
     */
    public function destroy($id)
    {
        $this->checkAdmin();

        $data = $this->getData();

        $ditemukan = false;

        foreach ($data as $key => $item) {

            if ($item['id'] == $id) {

                $ditemukan = true;

                $foto = public_path('gambar/'.$item['foto']);

                if (File::exists($foto)) {
                    File::delete($foto);
                }

                unset($data[$key]);

                break;
            }
        }

        if (!$ditemukan) {
            abort(404);
        }

        $this->saveData($data);

        return redirect('/lapangan')
            ->with('success','Data lapangan berhasil dihapus.');
    }

    /**
     * Export PDF
     */
    public function exportPDF()
    {
        $this->checkAdmin();

        $lapangan = $this->getData();

        $pdf = Pdf::loadView('lapangan.pdf', compact('lapangan'));

        return $pdf->download('Laporan_Data_Lapangan.pdf');
    }
}