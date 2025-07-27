@extends('layouts.app_pelanggan')

@section('content')
<div style="background: #1976d2; color: #fff; padding: 18px 0; font-size: 1.5rem; font-weight: bold; letter-spacing: 1px;">
    <div class="container d-flex justify-content-between align-items-center">
        <span>⚡ DASHBOARD PELANGGAN</span>
        <div>
            <span style="font-size: 1rem; font-weight: normal;">Halo, {{ $pelanggan->nama_pelanggan ?? $pelanggan->username }}</span>
            <a href="{{ route('logout.pelanggan') }}" class="ms-3 text-white text-decoration-none fw-bold"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </div>
</div>
<div class="container py-4" style="background:#fff; border-radius:12px; box-shadow:0 2px 8px rgba(0,0,0,0.05);">
    <div class="alert alert-info mb-4">Selamat datang kembali, <b>{{ $pelanggan->nama_pelanggan ?? $pelanggan->username }}</b>! Berikut ringkasan tagihan Anda.</div>

    <!-- Tagihan Terbaru -->
    @php
        $latest = $tagihan->first();
    @endphp
    @if($latest)
    <div class="card mb-4 shadow-sm">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div>
                <div class="fw-bold mb-2" style="font-size: 1.1rem;"><i class="bi bi-file-earmark-text"></i> Tagihan Terbaru Anda</div>
                <div class="mb-1"><span class="text-muted">Periode</span><br><span style="font-size:1.3rem;font-weight:bold">{{ \Carbon\Carbon::create($latest->tahun, $latest->bulan, 1)->translatedFormat('F Y') }}</span></div>
            </div>
            <div class="text-center">
                <div class="mb-1"><span class="text-muted">Total Bayar</span><br><span style="font-size:2rem;font-weight:bold">Rp {{ number_format($latest->total_tagihan ?? $latest->jumlah_meter * ($pelanggan->tarif->tarifperkwh ?? 0), 0, ',', '.') }}</span></div>
                <small class="text-muted">*Sudah termasuk biaya admin</small>
            </div>
            @if(empty($latest->bukti_bayar))
            <div>
                <a href="{{ route('pembayaran.create', ['tagihan_id' => $latest->id_tagihan]) }}" class="btn btn-success btn-lg"><i class="bi bi-credit-card"></i> Bayar Sekarang</a>
            </div>
            @endif
        </div>
    </div>
    @else
    <div class="alert alert-warning">Belum ada tagihan untuk Anda. Silakan hubungi admin jika data belum muncul.</div>
    @endif

    <!-- Riwayat Tagihan -->
    <div class="mb-4">
        <div class="fw-bold mb-2" style="font-size: 1.1rem;"><i class="bi bi-clock-history"></i> Riwayat Tagihan</div>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Periode</th>
                        <th>Pemakaian (kWh)</th>
                        <th>Total Tagihan</th>
                        <th>Status & Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tagihan as $t)
                    <tr>
                        <td>{{ \Carbon\Carbon::create($t->tahun, $t->bulan, 1)->translatedFormat('F Y') }}</td>
                        <td>{{ $t->jumlah_meter }} kWh</td>
                        <td>Rp {{ number_format($t->total_tagihan ?? $t->jumlah_meter * ($pelanggan->tarif->tarifperkwh ?? 0), 0, ',', '.') }}</td>
                        <td>
                            @if(empty($t->bukti_bayar))
                                <span class="badge bg-danger">Belum Lunas</span>
                                <a href="{{ route('pembayaran.create', ['tagihan_id' => $t->id_tagihan]) }}" class="btn btn-success btn-sm ms-2"><i class="bi bi-credit-card"></i> Bayar</a>
                            @else
                                <span class="badge bg-success">Lunas</span>
                            @endif
                            <a href="{{ route('tagihan.show', $t->id_tagihan) }}" class="btn btn-info btn-sm ms-2"><i class="bi bi-file-earmark-text"></i> Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- ...existing code... -->
</div>
</body>
</html>
