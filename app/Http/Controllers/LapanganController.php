<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LapanganController extends Controller
{
    // Membaca data dari file JSON
    private function getData()
    {
        $path = storage_path('app/lapangan.json');

        if (!file_exists($path)) {
            file_put_contents($path, json_encode([]));
        }

        $json = file_get_contents($path);

        return json_decode($json, true);
    }

    // Menyimpan data ke file JSON
    private function saveData($data)
    {
        file_put_contents(
            storage_path('app/lapangan.json'),
            json_encode($data, JSON_PRETTY_PRINT)
        );
    }

    // Menampilkan semua data
    public function index()
    {
        $lapangan = $this->getData();

        return view('lapangan.index', compact('lapangan'));
    }

    // Form tambah
    public function create()
    {
        return view('lapangan.create');
    }

    // Simpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_lapangan' => 'required',
            'harga_per_jam' => 'required|numeric',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $this->getData();

        // Upload foto
        $namaFoto = time() . '.' . $request->foto->extension();

        $request->foto->move(
            public_path('gambar'),
            $namaFoto
        );

        // ID otomatis
        $id = empty($data) ? 1 : max(array_column($data, 'id')) + 1;

        $data[] = [
            'id' => $id,
            'nama_lapangan' => $request->nama_lapangan,
            'harga_per_jam' => $request->harga_per_jam,
            'foto' => $namaFoto
        ];

        $this->saveData($data);

        return redirect('/lapangan')
            ->with('success', 'Data lapangan berhasil ditambahkan.');
    }

    // Detail
    public function show($id)
    {
        $data = $this->getData();

        foreach ($data as $item) {

            if ($item['id'] == $id) {

                return view('lapangan.show', [
                    'lapangan' => $item
                ]);
            }
        }

        abort(404);
    }

    // Form Edit
    public function edit($id)
    {
        $data = $this->getData();

        foreach ($data as $item) {

            if ($item['id'] == $id) {

                return view('lapangan.edit', [
                    'lapangan' => $item
                ]);
            }
        }

        abort(404);
    }

    // Update Data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lapangan' => 'required',
            'harga_per_jam' => 'required|numeric'
        ]);

        $data = $this->getData();

        foreach ($data as $key => $item) {

            if ($item['id'] == $id) {

                $data[$key]['nama_lapangan'] = $request->nama_lapangan;
                $data[$key]['harga_per_jam'] = $request->harga_per_jam;

                // Jika upload foto baru
                if ($request->hasFile('foto')) {

                    $namaFoto = time() . '.' . $request->foto->extension();

                    $request->foto->move(
                        public_path('gambar'),
                        $namaFoto
                    );

                    $data[$key]['foto'] = $namaFoto;
                }
            }
        }

        $this->saveData($data);

        return redirect('/lapangan')
            ->with('success', 'Data lapangan berhasil diupdate.');
    }

    // Hapus
    public function destroy($id)
    {
        $data = $this->getData();

        $hasil = [];

        foreach ($data as $item) {

            if ($item['id'] != $id) {

                $hasil[] = $item;
            }
        }

        $this->saveData($hasil);

        return redirect('/lapangan')
            ->with('success', 'Data lapangan berhasil dihapus.');
    }
}