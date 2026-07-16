<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <title>Data Reservasi</title>

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

        img{
            width:90px;
            height:90px;
            object-fit:cover;
            border-radius:10px;
        }

    </style>

</head>

<body>

<nav class="navbar navbar-dark">

<div class="container">

<span class="navbar-brand">

⚽ SIREGA - Sistem Reservasi Lapangan

</span>

<div>

<span class="text-white me-3">

Halo,

<b>{{ session('nama') }}</b>

({{ session('role') }})

</span>

@if(session('role')=='admin')

<a href="/dashboard" class="btn btn-light btn-sm me-2">

Dashboard

</a>

@else

<a href="/lapangan" class="btn btn-warning btn-sm me-2">

Data Lapangan

</a>

@endif

<a href="/logout" class="btn btn-danger btn-sm">

Logout

</a>

</div>

</div>

</nav>


<div class="container mt-4">

<div class="card">

<div class="card-header bg-success text-white">

<div class="d-flex justify-content-between align-items-center">

<h3 class="mb-0">

Data Reservasi

</h3>

@if(session('role')!='admin')

<a href="/reservasi/create" class="btn btn-light">

+ Reservasi Baru

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

@if(session('error'))

<div class="alert alert-danger">

{{ session('error') }}

</div>

@endif

<table class="table table-bordered table-hover align-middle">

<thead class="table-success">

<tr>

<th>No</th>

<th>Nama</th>

<th>Lapangan</th>

<th>Tanggal</th>

<th>Durasi</th>

<th>Total Bayar</th>

<th>Bukti</th>

<th>Status</th>

@if(session('role')=='admin')
<th width="250">Aksi</th>
@endif

</tr>

</thead>

<tbody>

@forelse($reservasi as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $item['nama'] }}</td>

<td>{{ $item['lapangan'] }}</td>

<td>{{ date('d-m-Y',strtotime($item['tanggal'])) }}</td>

<td>{{ $item['durasi'] }} Jam</td>

<td>

Rp {{ number_format($item['total_bayar'],0,',','.') }}

</td>

<td>

@if(!empty($item['bukti']) && file_exists(public_path('transfer/'.$item['bukti'])))

<img src="{{ asset('transfer/'.$item['bukti']) }}">

@else

Tidak Ada

@endif

</td>

<td>

@if($item['status']=="Menunggu Konfirmasi")

<span class="badge bg-warning text-dark">

Menunggu Konfirmasi

</span>

@elseif($item['status']=="Dikonfirmasi")

<span class="badge bg-primary">

Dikonfirmasi

</span>

@elseif($item['status']=="Selesai")

<span class="badge bg-success">

Selesai

</span>

@else

<span class="badge bg-danger">

Dibatalkan

</span>

@endif

</td>

@if(session('role')=='admin')

<td>

@if($item['status']=="Menunggu Konfirmasi")

<a href="/reservasi/status/{{ $item['id'] }}/Dikonfirmasi"
class="btn btn-primary btn-sm">

Konfirmasi

</a>

<a href="/reservasi/status/{{ $item['id'] }}/Dibatalkan"
class="btn btn-danger btn-sm"
onclick="return confirm('Batalkan reservasi ini?')">

Batalkan

</a>

@endif


@if($item['status']=="Dikonfirmasi")

<a href="/reservasi/status/{{ $item['id'] }}/Selesai"
class="btn btn-success btn-sm">

Selesai

</a>

@endif

@if(
$item['status']=="Selesai" ||
$item['status']=="Dibatalkan"
)

<span class="text-muted">

Tidak ada aksi

</span>

@endif

</td>

@endif

</tr>

@empty

<tr>

<td colspan="{{ session('role')=='admin' ? 9 : 8 }}" class="text-center">

Belum ada data reservasi.

</td>

</tr>

@endforelse

</tbody>

</table>

<div class="mt-3">

<a href="/lapangan" class="btn btn-secondary">

Kembali

</a>

</div>

</div>

</div>

</div>

</body>
</html>