@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Detail Pembayaran</h2>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-6"><b>Nama Pelanggan:</b> {{ $pembayaran->pelanggan->nama_pelanggan ?? $pembayaran->pelanggan->username ?? '-' }}</div>
                <div class="col-md-6"><b>Tanggal Bayar:</b> {{ $pembayaran->tanggal_pembayaran ? \Carbon\Carbon::parse($pembayaran->tanggal_pembayaran)->format('d F Y') : ($pembayaran->bulan_bayar . ' ' . $pembayaran->tahun_bayar) }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6"><b>Tarif per kWh:</b> Rp {{ number_format($pembayaran->pelanggan->tarif->tarifperkwh ?? 0, 0, ',', '.') }}</div>
                <div class="col-md-6"><b>Pemakaian (kWh):</b> {{ $pembayaran->tagihan->jumlah_meter ?? '-' }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6"><b>Total Tagihan:</b> Rp {{ number_format($pembayaran->tagihan->total_tagihan ?? ($pembayaran->tagihan->jumlah_meter * ($pembayaran->pelanggan->tarif->tarifperkwh ?? 0)), 0, ',', '.') }}</div>
                <div class="col-md-6"><b>Total Bayar:</b> Rp {{ number_format($pembayaran->total_bayar, 0, ',', '.') }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6"><b>Status:</b> {{ $pembayaran->status ?? '-' }}</div>
                <div class="col-md-6"><b>Metode Pembayaran:</b> {{ $pembayaran->metode_pembayaran }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6"><b>Admin/Operator/Manajer:</b> {{ $pembayaran->user->nama_admin ?? '-' }}</div>
                <div class="col-md-6"><b>Bukti Pembayaran:</b><br>
                    @if($pembayaran->bukti_pembayaran)
                        <img src="{{ asset('storage/bukti_pembayaran/' . basename($pembayaran->bukti_pembayaran)) }}" alt="Bukti Pembayaran" style="max-width:200px;max-height:200px;">
                        <br>
                        <a href="{{ asset('storage/bukti_pembayaran/' . basename($pembayaran->bukti_pembayaran)) }}" target="_blank" class="btn btn-primary btn-sm mt-2" style="width:100%">Lihat Foto (Fullscreen)</a>
                    @else
                        <span class="text-muted">Tidak ada bukti pembayaran</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if($pembayaran->status == 'Menunggu ACC')
    <form action="{{ route('pembayaran.acc', $pembayaran->id_pembayaran) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">ACC Pembayaran</button>
    </form>
    @endif
    <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
