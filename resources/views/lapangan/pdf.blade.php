<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">

<style>

body{

font-family: DejaVu Sans;

font-size:14px;

}

table{

width:100%;

border-collapse:collapse;

}

table,th,td{

border:1px solid black;

}

th{

background:#198754;

color:white;

padding:8px;

}

td{

padding:8px;

}

h2{

text-align:center;

}

</style>

</head>

<body>

<h2>

LAPORAN DATA LAPANGAN

</h2>

<table>

<tr>

<th>No</th>

<th>Nama Lapangan</th>

<th>Harga / Jam</th>

</tr>

@foreach($lapangan as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $item['nama_lapangan'] }}</td>

<td>

Rp {{ number_format($item['harga_per_jam'],0,',','.') }}

</td>

</tr>

@endforeach

</table>

</body>

</html>