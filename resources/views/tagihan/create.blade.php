@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Tambah Tagihan</h2>
    <form action="{{ route('tagihan.store') }}" method="POST">
        @csrf
        <!-- ID Tagihan auto increment, tidak perlu input -->
        <div class="mb-3">
            <label for="id_penggunaan" class="form-label">ID Penggunaan</label>
            <select name="id_penggunaan" id="id_penggunaan" class="form-control" required>
                <option value="">Pilih Penggunaan</option>
                @foreach($penggunaans as $p)
                    <option value="{{ $p->id_penggunaan }}" 
                        data-id-pelanggan="{{ $p->id_pelanggan }}"
                        data-nama-pelanggan="{{ optional($p->pelanggan)->nama_pelanggan }}"
                        data-bulan="{{ $p->bulan }}"
                        data-tahun="{{ $p->tahun }}"
                        data-meter-awal="{{ $p->meter_awal }}"
                        data-meter-akhir="{{ $p->meter_akhir }}"
                    >
                        {{ $p->id_penggunaan }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
            <input type="text" id="nama_pelanggan" class="form-control" readonly>
            <input type="hidden" name="id_pelanggan" id="id_pelanggan_hidden">
        </div>
        <!-- ID Pelanggan otomatis dari penggunaan -->
        <div class="mb-3">
            <label for="bulan" class="form-label">Bulan</label>
            <input type="text" name="bulan" id="bulan" class="form-control" required maxlength="10" readonly>
        </div>
        <div class="mb-3">
            <label for="tahun" class="form-label">Tahun</label>
            <input type="text" name="tahun" id="tahun" class="form-control" required maxlength="4" readonly>
        </div>
        <div class="mb-3">
            <label for="jumlah_meter" class="form-label">Jumlah Meter</label>
            <input type="number" step="0.01" name="jumlah_meter" id="jumlah_meter" class="form-control" required readonly>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="lunas">Lunas</option>
                <option value="belum">Belum</option>
                <option value="tunggak">Tunggak</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="tanggal_jatuh_tempo" class="form-label">Tanggal Jatuh Tempo</label>
            <input type="date" name="tanggal_jatuh_tempo" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('tagihan.index') }}" class="btn btn-secondary">Kembali</a>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('id_penggunaan').addEventListener('change', function() {
                var selected = this.options[this.selectedIndex];
                var namaPelanggan = selected.getAttribute('data-nama-pelanggan') || '';
                var idPelanggan = selected.getAttribute('data-id-pelanggan') || '';
                var bulan = selected.getAttribute('data-bulan') || '';
                var tahun = selected.getAttribute('data-tahun') || '';
                var meterAwal = parseFloat(selected.getAttribute('data-meter-awal')) || 0;
                var meterAkhir = parseFloat(selected.getAttribute('data-meter-akhir')) || 0;
                document.getElementById('nama_pelanggan').value = namaPelanggan;
                document.getElementById('id_pelanggan_hidden').value = idPelanggan;
                document.getElementById('bulan').value = bulan;
                document.getElementById('tahun').value = tahun;
                document.getElementById('jumlah_meter').value = meterAkhir - meterAwal;
            });
        });
        </script>
    </form>
</div>
@endsection
