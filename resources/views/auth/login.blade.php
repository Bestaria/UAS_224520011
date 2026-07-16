<!DOCTYPE html>
<html>

<head>

<title>Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body style="background:#eef2f7">

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-5">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h3>Login SIREGA</h3>

</div>

<div class="card-body">

@if(session('error'))

<div class="alert alert-danger">

{{ session('error') }}

</div>

@endif

<form action="/login" method="POST">

@csrf

<div class="mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Password</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<button class="btn btn-success w-100">

Login

</button>

</form>

<hr>

<p><b>Admin</b></p>

Email : admin@gmail.com

<br>

Password : 123

<hr>

<p><b>Pelanggan</b></p>

Email : member@gmail.com

<br>

Password : 123

</div>

</div>

</div>

</div>

</div>

</body>

</html>