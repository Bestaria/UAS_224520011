<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SIREGA - Data Lapangan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background:#eef2f7;
        }

        .navbar{
            background:#198754;
        }

        .card{
            border:none;
            border-radius:15px;
            box-shadow:0 5px 15px rgba(0,0,0,.15);
        }

        .table img{
            width:110px;
            height:80px;
            object-fit:cover;
            border-radius:10px;
        }

        .table th,
        .table td{
            vertical-align:middle;
        }

        .btn{
            border-radius:8px;
        }

    </style>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark">

<div class="container">

<a class="navbar-brand fw-bold fs-2">

⚽ SIREGA - Sistem Reservasi Lapangan Futsal

</a>

<div class="ms-auto">

@if(session('login'))

<span class="text-white me-3">

Halo,
<b>{{ session('nama') }}</b>

@if(session('role')=='admin')
(Admin)
@else
(Member)
@endif

</span>

@if(session('role')=='admin')

<a href="/dashboard"
class="btn btn-light btn-sm me-2">

Dashboard

</a>

@else

<a href="/reservasi/create"
class="btn btn-warning btn-sm me-2">

Reservasi

</a>

@endif

<a href="/logout"
class="btn btn-danger btn-sm">

Logout

</a>

@endif

</div>

</div>

</nav>

<div class="container mt-5">

<div class="card">

<div class="card-header bg-success text-white">

<div class="d-flex justify-content-between align-items-center">

<h4 class="mb-0">

Data Lapangan

</h4>

@if(session('role')=='admin')

<a href="/lapangan/create"
class="btn btn-light">

+ Tambah Lapangan

</a>

@endif

</div>

</div>

<div class="card-body">

@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif

<table class="table table-bordered table-hover">

<thead class="table-success">

<tr>

<th width="70">No</th>

<th width="150">Foto</th>

<th>Nama Lapangan</th>

<th width="180">Harga / Jam</th>

@if(session('role')=='admin')
<th width="250">Aksi</th>
@endif

</tr>

</thead>

<tbody>

@if(count($lapangan)>0)

@foreach($lapangan as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>

@if(!empty($item['foto']) && file_exists(public_path('gambar/'.$item['foto'])))

<img src="{{ asset('gambar/'.$item['foto']) }}">

@else

<img src="{{ asset('gambar/default.png') }}">

@endif

</td>

<td>

<b>{{ $item['nama_lapangan'] }}</b>

</td>

<td>

Rp {{ number_format($item['harga_per_jam'],0,',','.') }}

</td>

@if(session('role')=='admin')

<td>

<a href="/lapangan/show/{{ $item['id'] }}"
class="btn btn-info btn-sm text-white">

Detail

</a>

<a href="/lapangan/edit/{{ $item['id'] }}"
class="btn btn-warning btn-sm">

Edit

</a>

<a href="/lapangan/delete/{{ $item['id'] }}"
onclick="return confirm('Yakin ingin menghapus data ini?')"
class="btn btn-danger btn-sm">

Hapus

</a>

</td>

@endif

</tr>

@endforeach

@else

<tr>

<td colspan="5"
class="text-center">

Belum ada data lapangan.

</td>

</tr>

@endif

</tbody>

</table>

</div>

</div>

</div>

</body>
</html>