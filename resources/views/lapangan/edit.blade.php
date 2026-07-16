<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Lapangan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#eef2f7;
        }

        .card{
            border:none;
            border-radius:15px;
            box-shadow:0 5px 15px rgba(0,0,0,.15);
        }

        img{
            width:220px;
            border-radius:10px;
        }
    </style>

</head>

<body>

<div class="container mt-5">

<div class="card">

<div class="card-header bg-warning">

<h3>Edit Data Lapangan</h3>

</div>

<div class="card-body">

@if ($errors->any())

<div class="alert alert-danger">

<ul class="mb-0">

@foreach ($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif

<form action="/lapangan/update/{{ $lapangan['id'] }}"
      method="POST"
      enctype="multipart/form-data">

@csrf

<div class="mb-3">

<label class="form-label">

Nama Lapangan

</label>

<input
type="text"
name="nama_lapangan"
class="form-control"
value="{{ $lapangan['nama_lapangan'] }}"
required>

</div>

<div class="mb-3">

<label class="form-label">

Harga Per Jam

</label>

<input
type="number"
name="harga_per_jam"
class="form-control"
value="{{ $lapangan['harga_per_jam'] }}"
required>

</div>

<div class="mb-3">

<label class="form-label">

Foto Saat Ini

</label>

<br>

@if(file_exists(public_path('gambar/'.$lapangan['foto'])))

<img src="{{ asset('gambar/'.$lapangan['foto']) }}">

@else

<p class="text-danger">

Foto tidak ditemukan

</p>

@endif

</div>

<div class="mb-3">

<label class="form-label">

Ganti Foto (Opsional)

</label>

<input
type="file"
name="foto"
class="form-control">

<small class="text-muted">

Kosongkan jika tidak ingin mengganti foto.

</small>

</div>

<button class="btn btn-warning">

Update Data

</button>

<a href="/lapangan" class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

</body>

</html>