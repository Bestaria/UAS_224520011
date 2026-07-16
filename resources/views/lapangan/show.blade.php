<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <title>Detail Lapangan</title>

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
            width:320px;
            height:220px;
            object-fit:cover;
            border-radius:10px;
        }

    </style>

</head>

<body>

<div class="container mt-5">

<div class="card">

<div class="card-header bg-primary text-white">

<h3>Detail Lapangan</h3>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-5 text-center">

@if(file_exists(public_path('gambar/'.$lapangan['foto'])))

<img src="{{ asset('gambar/'.$lapangan['foto']) }}"
     class="img-thumbnail">

@else

<img src="{{ asset('gambar/default.png') }}"
     class="img-thumbnail">

@endif

</div>

<div class="col-md-7">

<table class="table table-bordered">

<tr>

<th width="180">

ID Lapangan

</th>

<td>

{{ $lapangan['id'] }}

</td>

</tr>

<tr>

<th>

Nama Lapangan

</th>

<td>

{{ $lapangan['nama_lapangan'] }}

</td>

</tr>

<tr>

<th>

Harga per Jam

</th>

<td>

Rp {{ number_format($lapangan['harga_per_jam'],0,',','.') }}

</td>

</tr>

</table>

<a href="/lapangan" class="btn btn-success">

Kembali

</a>

<a href="/lapangan/edit/{{ $lapangan['id'] }}"
class="btn btn-warning">

Edit

</a>

</div>

</div>

</div>

</div>

</div>

</body>

</html>