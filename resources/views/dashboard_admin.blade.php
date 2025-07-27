@extends('layouts.app')
@section('content')

<div class="container mt-4">
    <h2>Dashboard Admin</h2>
    <div class="alert alert-info">Selamat datang, {{ session('admin.nama_admin') ?? session('admin.username') }}</div>
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Pelanggan</h5>
                    <p class="card-text display-6">{{ $totalPelanggan ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Pembayaran</h5>
                    <p class="card-text display-6">Rp {{ number_format($totalPembayaran ?? 0, 2) }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h4>Pelanggan Terbaru</h4>
            <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">Pendaftaran Pelanggan</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Tarif</th>
                    <th>Status</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pelangganTerbaru as $p)
                <tr>
                    <td>{{ $p->id_pelanggan }}</td>
                    <td>{{ $p->nama_pelanggan }}</td>
                    <td>{{ $p->tarif->daya ?? '-' }}</td>
                    <td>{{ $p->status_aktif }}</td>
                    <td><a href="{{ route('pelanggan.show', $p->id_pelanggan) }}" class="btn btn-info btn-sm">Detail</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('logout.admin') }}" class="btn btn-danger">Logout</a>
</div>
@endsection
