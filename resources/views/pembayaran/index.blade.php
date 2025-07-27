@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Data Pembayaran</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('pembayaran.create') }}" class="btn btn-primary">Tambah Pembayaran</a>
        <a href="{{ route('laporan.semua') }}" class="btn btn-success btn-sm">Cetak Semua Tagihan</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Pelanggan</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal Bayar</th>
                <th>Total Bayar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembayarans as $p)
            <tr>
                <td>{{ $p->pelanggan->id_pelanggan ?? '-' }}</td>
                <td>{{ $p->pelanggan->nama_pelanggan ?? $p->pelanggan->username ?? '-' }}</td>
                <td>{{ $p->tanggal_pembayaran ? \Carbon\Carbon::parse($p->tanggal_pembayaran)->format('d F Y') : ($p->bulan_bayar . ' ' . $p->tahun_bayar) }}</td>
                <td>Rp {{ number_format($p->total_bayar, 0, ',', '.') }}</td>
                <td>
                    <span class="badge {{ empty($p->bukti_pembayaran) ? 'bg-warning' : 'bg-success' }}">
                        {{ empty($p->bukti_pembayaran) ? 'Belum Lunas' : 'Lunas' }}
                    </span>
                    <a href="{{ route('pembayaran.show', $p->id_pembayaran) }}" class="btn btn-info btn-sm ms-1">Detail</a>
                    <!-- Tombol ACC dihapus sesuai permintaan -->
                    @if(!empty($p->bukti_pembayaran))
                        <form action="{{ route('pembayaran.clearBukti', $p->id_pembayaran) }}" method="POST" style="display:inline-block">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm ms-1" onclick="return confirm('Hapus bukti pembayaran?')">Hapus Bukti</button>
                        </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
