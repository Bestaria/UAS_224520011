<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Reservasi Lapangan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background:#eef2f7;
        }

        .card{
            border:none;
            border-radius:15px;
            box-shadow:0px 5px 15px rgba(0,0,0,.15);
        }
    </style>

</head>

<body>

<div class="container mt-5">

<div class="card">

<div class="card-header bg-success text-white">

<h3>Form Reservasi Lapangan</h3>

</div>

<div class="card-body">

@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif

@if($errors->any())

<div class="alert alert-danger">

<ul class="mb-0">

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif

<form action="/reservasi/store"
      method="POST"
      enctype="multipart/form-data">

@csrf

<div class="mb-3">

<label class="form-label">

Nama Pemesan

</label>

<input
type="text"
name="nama"
class="form-control"
value="{{ old('nama') }}"
required>

</div>

<div class="mb-3">

<label class="form-label">

Pilih Lapangan

</label>

<select
name="lapangan"
id="lapangan"
class="form-select"
onchange="ubahHarga()"
required>

<option value="">

-- Pilih Lapangan --

</option>

@foreach($lapangan as $item)

<option
value="{{ $item['nama_lapangan'] }}"
data-harga="{{ $item['harga_per_jam'] }}"
{{ old('lapangan') == $item['nama_lapangan'] ? 'selected' : '' }}>

{{ $item['nama_lapangan'] }}
- Rp {{ number_format($item['harga_per_jam'],0,',','.') }}/Jam

</option>

@endforeach

</select>

</div>

<div class="mb-3">

<label class="form-label">

Tanggal Reservasi

</label>

<input
type="date"
name="tanggal"
class="form-control"
value="{{ old('tanggal') }}"
required>

</div>

<div class="mb-3">

<label class="form-label">

Durasi (Jam)

</label>

<input
type="number"
name="durasi"
class="form-control"
min="1"
value="{{ old('durasi') }}"
required>

</div>

<div class="mb-3">

<label class="form-label">

Harga per Jam

</label>

<input
type="number"
name="harga"
id="harga"
class="form-control"
readonly>

</div>

<div class="mb-3">

<label class="form-label">

Upload Bukti Transfer

</label>

<input
type="file"
name="bukti"
class="form-control"
accept=".jpg,.jpeg,.png"
required>

</div>

<div class="alert alert-info">

<b>Ketentuan Reservasi</b>

<ul class="mb-0">

<li>Reservasi hari <b>Sabtu dan Minggu</b> dikenakan tambahan <b>50%</b> dari harga normal.</li>

<li>Reservasi minimal <b>3 jam</b> mendapatkan diskon <b>10%</b>.</li>

<li>Status awal reservasi adalah <b>Menunggu Konfirmasi</b>.</li>

</ul>

</div>

<button
type="submit"
class="btn btn-success">

Simpan Reservasi

</button>

<a href="/reservasi"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

<script>

function ubahHarga(){

    let select = document.getElementById('lapangan');

    if(select.selectedIndex > 0){

        let harga = select.options[select.selectedIndex].getAttribute('data-harga');

        document.getElementById('harga').value = harga;

    }else{

        document.getElementById('harga').value = '';

    }

}

window.onload = ubahHarga;

</script>

</body>

</html>