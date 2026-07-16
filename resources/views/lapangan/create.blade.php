<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Lapangan</title>

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

        #preview{
            width:220px;
            height:150px;
            object-fit:cover;
            border-radius:10px;
            border:2px solid #ddd;
            display:none;
        }

    </style>

</head>

<body>

<div class="container mt-5">

<div class="card">

<div class="card-header bg-success text-white">

<h3>Tambah Data Lapangan</h3>

</div>

<div class="card-body">

@if ($errors->any())

<div class="alert alert-danger">

<ul class="mb-0">

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif

<form action="/lapangan/store"
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
placeholder="Masukkan nama lapangan"
value="{{ old('nama_lapangan') }}"
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
placeholder="Contoh : 100000"
value="{{ old('harga_per_jam') }}"
required>

</div>

<div class="mb-3">

<label class="form-label">

Upload Foto Lapangan

</label>

<input
type="file"
name="foto"
class="form-control"
accept="image/*"
onchange="previewImage(event)"
required>

</div>

<div class="mb-3 text-center">

<img id="preview">

</div>

<div class="mt-4">

<button type="submit" class="btn btn-success">

Simpan Data

</button>

<a href="/lapangan" class="btn btn-secondary">

Kembali

</a>

</div>

</form>

</div>

</div>

</div>

<script>

function previewImage(event){

    const preview=document.getElementById('preview');

    preview.src=URL.createObjectURL(event.target.files[0]);

    preview.style.display='block';

}

</script>

</body>

</html>