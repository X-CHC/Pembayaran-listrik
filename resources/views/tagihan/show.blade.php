@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Detail Tagihan</h2>
    <div class="card mb-4 shadow rounded-4 border-0">
        <div class="card-header bg-primary text-white rounded-top-4 fw-bold fs-5">
            <i class="bi bi-file-earmark-text me-2"></i>Informasi Tagihan
        </div>
        <div class="card-body bg-light rounded-bottom-4">
            <table class="table table-borderless w-100 align-middle mb-0">
                <tr>
                    <th class="text-start text-secondary" style="width:30%">Nama Pelanggan</th>
                    <td style="width:70%" class="fw-semibold">{{ $tagihan->pelanggan->nama_pelanggan ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-start text-secondary">Jumlah Meter</th>
                    <td class="fw-semibold">{{ $tagihan->jumlah_meter }} kWh</td>
                </tr>
                <tr>
                    <th class="text-start text-secondary">Total Tagihan</th>
                    <td class="fw-semibold">Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th class="text-start text-secondary">Status</th>
                    <td>
                        <span class="badge {{ empty($tagihan->bukti_bayar) ? 'bg-danger' : 'bg-success' }} px-3 py-2 fs-6">
                            {{ empty($tagihan->bukti_bayar) ? 'Belum Lunas' : 'Lunas' }}
                        </span>
                    </td>
                </tr>
            </table>
            <div class="mt-3 d-flex gap-2">
                <a href="{{ route('tagihan.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Kembali ke Daftar</a>
            </div>
        </div>
    </div>
</div>
@endsection
