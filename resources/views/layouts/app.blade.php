<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLN App</title>
    @vite(["resources/css/app.scss", "resources/js/app.js"])
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard.admin') }}">Pembayaran Listrik</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Dashboard nav item removed, brand acts as dashboard link -->
                    <li class="nav-item"><a class="nav-link" href="{{ route('pelanggan.index') }}">Data Pelanggan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('penggunaan.index') }}">Data Penggunaan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pembayaran.index') }}">Riwayat Pembayaran</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('tagihan.index') }}">Data Tagihan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('tarif.index') }}">Data Tarif</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('user.index') }}">Data User</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('level.index') }}">Data Level</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="btn btn-outline-light ms-2" href="{{ route('logout.admin') }}">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main>
        @yield('content')
    </main>
</body>
</html>
