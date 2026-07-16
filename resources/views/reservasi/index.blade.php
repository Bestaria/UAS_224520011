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

        .card{
            border:none;
            border-radius:15px;
            box-shadow:0 5px 15px rgba(0,0,0,.15);
        }

        img{
            width:90px;
            height:90px;
            object-fit:cover;
            border-radius:8px;
        }

    </style>

</head>

<body>

<div class="container mt-5">

<div class="card">

<div class="card-header bg-success text-white">

<div class="d-flex justify-content-between align-items-center">

<h3 class="mb-0">

Data Reservasi

</h3>

<a href="/reservasi/create"
class="btn btn-light">

+ Reservasi Baru

</a>

</div>

</div>

<div class="card-body">

@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

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

<th>Bukti Transfer</th>

<th>Status</th>

<th width="260">

Aksi

</th>

</tr>

</thead>

<tbody>

@if(count($reservasi)>0)

@foreach($reservasi as $item)

<tr>

<td>

{{ $loop->iteration }}

</td>

<td>

{{ $item['nama'] }}

</td>

<td>

{{ $item['lapangan'] }}

</td>

<td>

{{ date('d-m-Y',strtotime($item['tanggal'])) }}

</td>

<td>

{{ $item['durasi'] }} Jam

</td>

<td>

Rp {{ number_format($item['total_bayar'],0,',','.') }}

</td>

<td>

@if(file_exists(public_path('transfer/'.$item['bukti'])))

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

<td>

<a href="/reservasi/status/{{ $item['id'] }}/Dikonfirmasi"
class="btn btn-primary btn-sm">

Konfirmasi

</a>

<a href="/reservasi/status/{{ $item['id'] }}/Selesai"
class="btn btn-success btn-sm">

Selesai

</a>

<a href="/reservasi/status/{{ $item['id'] }}/Dibatalkan"
class="btn btn-danger btn-sm"
onclick="return confirm('Batalkan reservasi ini?')">

Batalkan

</a>

</td>

</tr>

@endforeach

@else

<tr>

<td colspan="9" class="text-center">

Belum ada data reservasi.

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