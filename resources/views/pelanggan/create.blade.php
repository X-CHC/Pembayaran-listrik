@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Tambah Pelanggan</h2>
    <form action="{{ route('pelanggan.store') }}" method="POST">
        @csrf
        <!-- ID Pelanggan auto, tidak perlu input di form -->
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required maxlength="50">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required minlength="6">
        </div>
        <div class="mb-3">
            <label for="nomor_kwh" class="form-label">Nomor KWH</label>
            <input type="text" name="nomor_kwh" class="form-control" required maxlength="20">
        </div>
        <div class="mb-3">
            <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" class="form-control" required maxlength="100">
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="id_tarif" class="form-label">Tarif</label>
            <select name="id_tarif" class="form-control" required>
                <option value="">Pilih Tarif</option>
                @foreach($tarifs as $tarif)
                    <option value="{{ $tarif->id_tarif }}">{{ $tarif->daya }} - {{ number_format($tarif->tarifperkwh,2) }}</option>
                @endforeach
            </select>
        </div>
        <!-- Status otomatis aktif, tidak perlu input di form -->
        <!-- Tanggal Daftar auto, tidak perlu input di form -->
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
