@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Data Pelanggan</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center" style="gap: 0.5rem;">
            <a href="{{ route('pelanggan.create') }}" class="btn btn-primary">Tambah Pelanggan</a>
            <a href="{{ route('laporan.semua') }}" class="btn btn-success btn-sm">Cetak Semua Tagihan</a>
        </div>
        <form method="GET" action="" class="d-flex" style="gap: 0.5rem;">
            <input type="text" name="cari" class="form-control" placeholder="Cari nama pelanggan..." value="{{ request('cari') }}" style="width: 200px;">
            <button type="submit" class="btn btn-secondary">Cari</button>
            <a href="{{ route('pelanggan.index') }}" class="btn btn-light">Reset</a>
        </form>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nomor KWH</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Tarif</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pelanggans as $p)
            <tr>
                <td>{{ $p->id_pelanggan }}</td>
                <td>{{ $p->username }}</td>
                <td>{{ $p->nomor_kwh }}</td>
                <td>{{ $p->nama_pelanggan }}</td>
                <td>{{ $p->alamat }}</td>
                <td>{{ $p->id_tarif }}</td>
                <td>{{ $p->status_aktif }}</td>
                <td>
                    <a href="{{ route('pelanggan.show', $p->id_pelanggan) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('pelanggan.edit', $p->id_pelanggan) }}" class="btn btn-warning btn-sm ms-1">Edit</a>
                    <form action="{{ route('pelanggan.destroy', $p->id_pelanggan) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus pelanggan ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
