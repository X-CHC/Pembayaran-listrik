@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Pendaftaran Pelanggan Baru</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('register.pelanggan.submit') }}" method="POST">
        @csrf
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
            <label for="nama_pelanggan" class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_pelanggan" class="form-control" required maxlength="100">
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="id_tarif" class="form-label">Tarif</label>
            <select name="id_tarif" class="form-control" required>
                @foreach($tarifs as $tarif)
                    <option value="{{ $tarif->id_tarif }}">{{ $tarif->daya }} - Rp{{ number_format($tarif->tarifperkwh,2) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Daftar</button>
        <a href="/" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
