<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard Admin - SIREGA</title>

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

        .menu-card{
            transition:.3s;
            cursor:pointer;
        }

        .menu-card:hover{
            transform:translateY(-5px);
            box-shadow:0 10px 20px rgba(0,0,0,.2);
        }

        .icon{
            font-size:55px;
        }
    </style>

</head>
<body>

@if(!session('login'))
<script>
    window.location.href="/login";
</script>
@endif

<nav class="navbar navbar-expand-lg navbar-dark">

    <div class="container">

        <a href="/dashboard" class="navbar-brand fw-bold fs-4">
            ⚽ SIREGA - Admin
        </a>

        <div class="ms-auto">

            <span class="text-white me-3">
                Halo, Bestaria 
                <strong>{{ session('nama') }}</strong>
                (Admin)
            </span>

            <a href="/logout" class="btn btn-light">
                Logout
            </a>

        </div>

    </div>

</nav>

<div class="container mt-5">

    @if(session('success'))

    <div class="alert alert-success">

        {{ session('success') }}

    </div>

    @endif

    <div class="card mb-4">

        <div class="card-body">

            <h2 class="fw-bold">
                Selamat Datang, Bestaria 
                <span class="text-success">{{ session('nama') }}</span>
                (Admin)
            </h2>

            <p class="mb-2">
                Role :
                <span class="badge bg-success">
                    Bestaria Admin
                </span>
            </p>

            <p class="text-muted">
                Silakan pilih menu yang ingin dikelola.
            </p>

        </div>

    </div>

    <div class="row">

        <div class="col-md-6 mb-4">

            <div class="card menu-card">

                <div class="card-body text-center">

                    <div class="icon">
                        ⚽
                    </div>

                    <h4 class="mt-3">
                        Data Lapangan
                    </h4>

                    <p class="text-muted">
                        Kelola data lapangan futsal.
                    </p>

                    <a href="/lapangan" class="btn btn-success">
                        Masuk
                    </a>

                </div>

            </div>

        </div>

        <div class="col-md-6 mb-4">

            <div class="card menu-card">

                <div class="card-body text-center">

                    <div class="icon">
                        📅
                    </div>

                    <h4 class="mt-3">
                        Data Reservasi
                    </h4>

                    <p class="text-muted">
                        Kelola reservasi pelanggan.
                    </p>

                    <a href="/reservasi" class="btn btn-primary">
                        Masuk
                    </a>

                </div>

            </div>

        </div>

    </div>

    <div class="card">

        <div class="card-body">

            <h4 class="mb-3">
                Informasi Sistem
            </h4>

            <table class="table table-bordered">

                <tr>
                    <th width="250">Nama Sistem</th>
                    <td>SIREGA - Sistem Reservasi Lapangan Futsal</td>
                </tr>

                <tr>
                    <th>Login Sebagai</th>
                    <td>{{ session('nama') }} (Bestaria Admin)</td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td>{{ session('email') }}</td>
                </tr>

                <tr>
                    <th>Role</th>
                    <td>Admin</td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge bg-success">
                            Aktif
                        </span>
                    </td>
                </tr>

            </table>

        </div>

    </div>

</div>

</body>
</html>