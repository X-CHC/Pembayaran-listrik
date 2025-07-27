@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Edit Penggunaan</h2>
    <form action="{{ route('penggunaan.update', $penggunaan->id_penggunaan) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="id_pelanggan" class="form-label">Pelanggan</label>
            <select name="id_pelanggan" class="form-control" required>
                @foreach($pelanggans as $p)
                    <option value="{{ $p->id_pelanggan }}" @if($penggunaan->id_pelanggan==$p->id_pelanggan) selected @endif>{{ $p->id_pelanggan }} - {{ $p->nama_pelanggan }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="bulan" class="form-label">Bulan</label>
            <input type="text" name="bulan" class="form-control" value="{{ $penggunaan->bulan }}" required maxlength="10">
        </div>
        <div class="mb-3">
            <label for="tahun" class="form-label">Tahun</label>
            <input type="text" name="tahun" class="form-control" value="{{ $penggunaan->tahun }}" required maxlength="4">
        </div>
        <div class="mb-3">
            <label for="meter_awal" class="form-label">Meter Awal</label>
            <input type="number" step="0.01" name="meter_awal" class="form-control" value="{{ $penggunaan->meter_awal }}" required>
        </div>
        <div class="mb-3">
            <label for="meter_akhir" class="form-label">Meter Akhir</label>
            <input type="number" step="0.01" name="meter_akhir" class="form-control" value="{{ $penggunaan->meter_akhir }}" required>
        </div>
        <div class="mb-3">
            <label for="tanggal_catat" class="form-label">Tanggal Catat</label>
            <input type="date" name="tanggal_catat" class="form-control" value="{{ $penggunaan->tanggal_catat }}" required>
        </div>
        <div class="mb-3">
            <label for="status_verifikasi" class="form-label">Status Verifikasi</label>
            <select name="status_verifikasi" class="form-control" required>
                <option value="terverifikasi" @if($penggunaan->status_verifikasi=='terverifikasi') selected @endif>Terverifikasi</option>
                <option value="belum" @if($penggunaan->status_verifikasi=='belum') selected @endif>Belum</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('penggunaan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
