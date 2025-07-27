@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Tambah Penggunaan</h2>
    <form action="{{ route('penggunaan.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="id_pelanggan" class="form-label">Pelanggan</label>
            <select name="id_pelanggan" id="id_pelanggan" class="form-control" required onchange="getMeterAkhir()">
                <option value="">Pilih Pelanggan</option>
                @foreach($pelanggans as $p)
                    <option value="{{ $p->id_pelanggan }}">{{ $p->id_pelanggan }} - {{ $p->nama_pelanggan }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="bulan" class="form-label">Bulan</label>
            <input type="text" name="bulan" class="form-control" required maxlength="10" value="{{ now()->format('m') }}">
        </div>
        <div class="mb-3">
            <label for="tahun" class="form-label">Tahun</label>
            <input type="text" name="tahun" class="form-control" required maxlength="4" value="{{ now()->format('Y') }}">
        </div>
        <div class="mb-3">
            <label for="meter_awal" class="form-label">Meter Awal</label>
            <input type="number" step="0.01" name="meter_awal" id="meter_awal" class="form-control" required readonly>
        </div>
        <div class="mb-3">
            <label for="meter_akhir" class="form-label">Meter Akhir</label>
            <input type="number" step="0.01" name="meter_akhir" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="tanggal_catat" class="form-label">Tanggal Catat</label>
            <input type="date" name="tanggal_catat" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="status_verifikasi" class="form-label">Status Verifikasi</label>
            <select name="status_verifikasi" class="form-control" required>
                <option value="terverifikasi">Terverifikasi</option>
                <option value="belum">Belum</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('penggunaan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
    <script>
    function getMeterAkhir() {
        var id = document.getElementById('id_pelanggan').value;
        if(!id) return document.getElementById('meter_awal').value = '';
        fetch('/penggunaan/meter-akhir/' + id)
            .then(res => res.json())
            .then(data => {
                document.getElementById('meter_awal').value = data.meter_akhir ?? 0;
            });
    }
    </script>
</div>
@endsection
