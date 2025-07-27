@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Edit Pelanggan</h2>
    <form action="{{ route('pelanggan.update', $pelanggan->id_pelanggan) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="{{ $pelanggan->username }}" required maxlength="50">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password (isi jika ingin ganti)</label>
            <input type="password" name="password" class="form-control" minlength="6">
        </div>
        <div class="mb-3">
            <label for="nomor_kwh" class="form-label">Nomor KWH</label>
            <input type="text" name="nomor_kwh" class="form-control" value="{{ $pelanggan->nomor_kwh }}" required maxlength="20">
        </div>
        <div class="mb-3">
            <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" class="form-control" value="{{ $pelanggan->nama_pelanggan }}" required maxlength="100">
        </div>
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" class="form-control" required>{{ $pelanggan->alamat }}</textarea>
        </div>
        <div class="mb-3">
            <label for="id_tarif" class="form-label">Tarif</label>
            <select name="id_tarif" class="form-control" required>
                @foreach($tarifs as $tarif)
                    <option value="{{ $tarif->id_tarif }}" @if($pelanggan->id_tarif==$tarif->id_tarif) selected @endif>{{ $tarif->daya }} - {{ number_format($tarif->tarifperkwh,2) }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="status_aktif" class="form-label">Status</label>
            <select name="status_aktif" class="form-control" required>
                <option value="aktif" @if($pelanggan->status_aktif=='aktif') selected @endif>Aktif</option>
                <option value="nonaktif" @if($pelanggan->status_aktif=='nonaktif') selected @endif>Nonaktif</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="tanggal_daftar" class="form-label">Tanggal Daftar</label>
            <input type="date" name="tanggal_daftar" class="form-control" value="{{ $pelanggan->tanggal_daftar }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
