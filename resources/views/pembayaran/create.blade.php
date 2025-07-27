@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Tambah Pembayaran</h2>
    <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- ID Pembayaran dihapus, auto-increment di DB -->
        <div class="mb-3">
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif
            <label for="id_tagihan" class="form-label">Tagihan</label>
            <select name="id_tagihan" id="id_tagihan" class="form-control" required>
                <option value="">Pilih Tagihan</option>
                @foreach($tagihans as $tagihan)
                    @if($tagihan->status !== 'lunas')
                        <option value="{{ $tagihan->id_tagihan }}"
                            data-id-pelanggan="{{ $tagihan->id_pelanggan }}"
                            data-nama-pelanggan="{{ $tagihan->pelanggan && $tagihan->pelanggan->nama_pelanggan ? $tagihan->pelanggan->nama_pelanggan : '' }}"
                            data-jumlah-meter="{{ $tagihan->jumlah_meter }}"
                            data-tarif="{{ $tagihan->pelanggan && $tagihan->pelanggan->tarif && $tagihan->pelanggan->tarif->tarifperkwh ? (string)$tagihan->pelanggan->tarif->tarifperkwh : '0' }}"
                        >
                            {{ $tagihan->id_tagihan }} - {{ $tagihan->bulan }}/{{ $tagihan->tahun }} ({{ $tagihan->status }})
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
            <input type="text" id="nama_pelanggan" class="form-control" readonly>
            <input type="hidden" name="id_pelanggan" id="id_pelanggan_hidden">
        </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var tagihanSelect = document.getElementById('id_tagihan');
        var submitBtn = document.querySelector('button[type="submit"]');
        tagihanSelect.addEventListener('change', function() {
            var selected = this.options[this.selectedIndex];
            // Cek atribut data-nama-pelanggan, data-id-pelanggan, data-jumlah-meter, data-tarif
            var namaPelanggan = selected.getAttribute('data-nama-pelanggan') || selected.getAttribute('data-nama') || '';
            var idPelanggan = selected.getAttribute('data-id-pelanggan') || selected.getAttribute('data-id_pelanggan') || '';
            var jumlahMeter = parseFloat(selected.getAttribute('data-jumlah-meter') || selected.getAttribute('data-jumlah_meter')) || 0;
            var tarif = parseFloat(selected.getAttribute('data-tarif') || selected.getAttribute('data-tarifperkwh')) || 0;
            var biayaAdmin = 2500;
            document.getElementById('nama_pelanggan').value = namaPelanggan;
            document.getElementById('id_pelanggan_hidden').value = idPelanggan;
            var totalBayar = (jumlahMeter * tarif) + biayaAdmin;
            var totalRounded = 0;
            if (totalBayar > 0) {
                totalRounded = Math.ceil(totalBayar / 1000) * 1000;
            }
            document.getElementById('total_bayar').value = totalRounded > 0 ? totalRounded : '';
        });
        // Bukti pembayaran logic
        document.getElementById('metode_pembayaran').addEventListener('change', function() {
            var metode = this.value;
            var buktiInput = document.getElementById('bukti_pembayaran');
            if(metode === 'tunai') {
                buktiInput.disabled = true;
                buktiInput.value = '';
            } else {
                buktiInput.disabled = false;
            }
        });
    });
    </script>
        <div class="mb-3">
            <label for="tanggal_pembayaran" class="form-label">Tanggal Pembayaran</label>
            <input type="datetime-local" name="tanggal_pembayaran" class="form-control" required value="{{ now()->format('Y-m-d\TH:i') }}">
        </div>
        <div class="mb-3">
            <label for="bulan_bayar" class="form-label">Bulan Bayar</label>
            <input type="text" name="bulan_bayar" class="form-control" required maxlength="10" value="{{ now()->format('m') }}">
        </div>
        <div class="mb-3">
            <label for="tahun_bayar" class="form-label">Tahun Bayar</label>
            <input type="text" name="tahun_bayar" class="form-control" required maxlength="4" value="{{ now()->format('Y') }}">
        </div>
        <div class="mb-3">
            <label for="biaya_admin" class="form-label">Biaya Admin</label>
            <input type="number" step="0.01" name="biaya_admin" class="form-control" required value="2500" readonly>
        </div>
        <div class="mb-3">
            <label for="total_bayar" class="form-label">Total Bayar</label>
            <input type="number" step="0.01" name="total_bayar" id="total_bayar" class="form-control" required readonly>
        </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var tagihanSelect = document.getElementById('id_tagihan');
        tagihanSelect.addEventListener('change', function() {
            var selected = this.options[this.selectedIndex];
            var namaPelanggan = selected.getAttribute('data-nama-pelanggan') || '';
            var idPelanggan = selected.getAttribute('data-id-pelanggan') || '';
            var jumlahMeter = parseFloat(selected.getAttribute('data-jumlah-meter')) || 0;
            var tarif = parseFloat(selected.getAttribute('data-tarif')) || 0;
            var biayaAdmin = 2500;
            document.getElementById('nama_pelanggan').value = namaPelanggan;
            document.getElementById('id_pelanggan_hidden').value = idPelanggan;
            var totalBayar = (jumlahMeter * tarif) + biayaAdmin;
            document.getElementById('total_bayar').value = totalBayar > 0 ? totalBayar : '';
        });
    });
    </script>
        <!-- User field dihapus, user diambil dari session -->
        <div class="mb-3">
            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-control" required>
                <option value="tunai">Tunai</option>
                <option value="transfer">Transfer</option>
                <option value="e-wallet">E-Wallet</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran (gambar, opsional)</label>
            <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control" accept="image/*">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
    <script>
    // Dynamic tagihan dropdown based on pelanggan
    // Load semua tagihan saat halaman dibuka
    document.addEventListener('DOMContentLoaded', function() {
        var tagihanSelect = document.getElementById('id_tagihan');
        var submitBtn = document.querySelector('button[type="submit"]');
        fetch('/api/all-tagihan')
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    tagihanSelect.innerHTML = '<option value="">Tidak ada tagihan</option>';
                    submitBtn.disabled = true;
                } else {
                    tagihanSelect.innerHTML = '<option value="">Pilih Tagihan</option>';
                    data.forEach(function(tagihan) {
                        let statusText = tagihan.status === 'lunas' ? 'LUNAS' : 'BELUM';
                        tagihanSelect.innerHTML += `<option value="${tagihan.id_tagihan}" data-nama="${tagihan.nama_pelanggan}" data-id-pelanggan="${tagihan.id_pelanggan}" data-status="${tagihan.status}">${tagihan.id_tagihan} - ${tagihan.bulan}/${tagihan.tahun} (Rp ${tagihan.total_tagihan}) [${statusText}]</option>`;
                    });
                    submitBtn.disabled = false;
                }
            });
    });
    document.getElementById('id_tagihan').addEventListener('change', function() {
        var selected = this.options[this.selectedIndex];
        var submitBtn = document.querySelector('button[type="submit"]');
        var namaPelanggan = selected.getAttribute('data-nama') || '';
        var idPelanggan = selected.getAttribute('data-id-pelanggan') || '';
        document.getElementById('nama_pelanggan').value = namaPelanggan;
        document.getElementById('id_pelanggan_hidden').value = idPelanggan;
        if(selected.getAttribute('data-status') === 'lunas') {
            submitBtn.disabled = true;
        } else {
            submitBtn.disabled = false;
        }
    });
    // Bukti pembayaran logic
    document.getElementById('metode_pembayaran').addEventListener('change', function() {
        var metode = this.value;
        var buktiInput = document.getElementById('bukti_pembayaran');
        if(metode === 'tunai') {
            buktiInput.disabled = true;
            buktiInput.value = '';
        } else {
            buktiInput.disabled = false;
        }
    });
    </script>
</div>


@endsection
