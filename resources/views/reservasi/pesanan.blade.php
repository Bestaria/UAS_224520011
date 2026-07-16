<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <title>Pesanan Saya</title>

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

        .table img{
            width:120px;
            height:90px;
            object-fit:cover;
            border-radius:10px;
        }

    </style>

</head>

<body>

<div class="container mt-5">

<div class="card">

<div class="card-header bg-success text-white d-flex justify-content-between">

<h3>Pesanan Saya</h3>

<a href="/lapangan" class="btn btn-light">

Kembali

</a>

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

<th>Lapangan</th>

<th>Tanggal</th>

<th>Durasi</th>

<th>Total Bayar</th>

<th>Bukti Transfer</th>

<th>Status</th>

</tr>

</thead>

<tbody>

@if(count($reservasi)>0)

@foreach($reservasi as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $item['lapangan'] }}</td>

<td>{{ $item['tanggal'] }}</td>

<td>{{ $item['durasi'] }} Jam</td>

<td>

Rp {{ number_format($item['total_bayar'],0,',','.') }}

</td>

<td>

@if(!empty($item['bukti']) && file_exists(public_path('transfer/'.$item['bukti'])))

<img src="{{ asset('transfer/'.$item['bukti']) }}">

@else

Tidak ada

@endif

</td>

<td>

@if($item['status']=="Menunggu Konfirmasi")

<span class="badge bg-warning text-dark">

{{ $item['status'] }}

</span>

@elseif($item['status']=="Dikonfirmasi")

<span class="badge bg-primary">

{{ $item['status'] }}

</span>

@elseif($item['status']=="Selesai")

<span class="badge bg-success">

{{ $item['status'] }}

</span>

@else

<span class="badge bg-danger">

{{ $item['status'] }}

</span>

@endif

</td>

</tr>

@endforeach

@else

<tr>

<td colspan="7" class="text-center">

Belum ada reservasi.

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