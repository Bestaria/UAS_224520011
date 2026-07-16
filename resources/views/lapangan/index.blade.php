<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
            width:120px;
            height:85px;
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

<a href="/lapangan" class="navbar-brand fw-bold fs-4">
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

<a href="/dashboard" class="btn btn-light btn-sm me-2">
Dashboard
</a>

@else

<a href="/reservasi/create" class="btn btn-warning btn-sm me-2">
Reservasi
</a>

<a href="/pesanan" class="btn btn-info btn-sm me-2">
Pesanan Saya
</a>

@endif

<a href="/logout" class="btn btn-danger btn-sm">
Logout
</a>

@else

<a href="/login" class="btn btn-light btn-sm">
Login
</a>

@endif

</div>

</div>

</nav>

<div class="container mt-5">

<div class="card">

<div class="card-header bg-success text-white">

<div class="d-flex justify-content-between align-items-center">

<h3 class="mb-0">
Data Lapangan
</h3>

@if(session('role')=='admin')

<div>

<a href="/lapangan/pdf" class="btn btn-danger me-2">
📄 Export PDF
</a>

<a href="/lapangan/create" class="btn btn-light">
+ Tambah Lapangan
</a>

</div>

@endif

</div>

</div>

<div class="card-body">

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<table class="table table-bordered table-hover align-middle">

<thead class="table-success">

<tr>

<th width="60">No</th>

<th width="150">Foto</th>

<th>Nama Lapangan</th>

<th width="180">Harga / Jam</th>

@if(session('role')=='admin')
<th width="250">Aksi</th>
@else
<th width="120">Detail</th>
@endif

</tr>

</thead>

<tbody>

@forelse($lapangan as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>

@if(!empty($item['foto']) && file_exists(public_path('gambar/'.$item['foto'])))

<img src="{{ asset('gambar/'.$item['foto']) }}" alt="Foto Lapangan">

@else

<img src="{{ asset('gambar/default.png') }}" alt="Default">

@endif

</td>

<td>
<strong>{{ $item['nama_lapangan'] }}</strong>
</td>

<td>
Rp {{ number_format($item['harga_per_jam'],0,',','.') }}
</td>

<td>

<a href="/lapangan/show/{{ $item['id'] }}"
class="btn btn-info btn-sm text-white">
Detail
</a>

@if(session('role')=='admin')

<a href="/lapangan/edit/{{ $item['id'] }}"
class="btn btn-warning btn-sm">
Edit
</a>

<a href="/lapangan/delete/{{ $item['id'] }}"
class="btn btn-danger btn-sm"
onclick="return confirm('Yakin ingin menghapus data ini?')">
Hapus
</a>

@endif

</td>

</tr>

@empty

<tr>

<td colspan="{{ session('role')=='admin' ? 5 : 5 }}" class="text-center text-muted">

Belum ada data lapangan.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

</body>
</html>