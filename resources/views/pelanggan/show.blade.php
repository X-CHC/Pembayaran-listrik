@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Detail Pelanggan</h2>
    <div class="card mb-4 shadow rounded-4 border-0">
        <div class="card-header bg-primary text-white rounded-top-4 fw-bold fs-5">
            <i class="bi bi-person-badge me-2"></i>Informasi Pelanggan #{{ $pelanggan->id_pelanggan }}
        </div>
        <div class="card-body bg-light rounded-bottom-4">
            <div class="row mb-2 g-3 align-items-stretch">
                <div class="col-12">
                    <table class="table table-borderless w-100 align-middle mb-0">
                        <tr>
                            <th class="text-start text-secondary" style="width:30%">ID Pelanggan</th>
                            <td style="width:20%" class="fw-semibold">{{ $pelanggan->id_pelanggan }}</td>
                            <th class="text-start text-secondary" style="width:20%">Tarif</th>
                            <td style="width:30%" class="fw-semibold">
                                <span class="badge bg-info text-dark me-1">{{ $pelanggan->tarif->daya ?? '-' }}</span>
                                <span class="text-muted small">(Rp {{ number_format($pelanggan->tarif->tarifperkwh ?? 0, 2) }}/kWh)</span>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-start text-secondary">Username</th>
                            <td class="fw-semibold">{{ $pelanggan->username }}</td>
                            <th class="text-start text-secondary">Status</th>
                            <td>
                                <span class="badge {{ $pelanggan->status_aktif == 'aktif' ? 'bg-success' : 'bg-secondary' }} px-3 py-2 fs-6">
                                    {{ ucfirst($pelanggan->status_aktif) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-start text-secondary">Nama Lengkap</th>
                            <td class="fw-semibold">{{ $pelanggan->nama_pelanggan }}</td>
                            <th class="text-start text-secondary">Tanggal Daftar</th>
                            <td class="fw-semibold">{{ $pelanggan->tanggal_daftar }}</td>
                        </tr>
                        <tr>
                            <th class="text-start text-secondary">Alamat</th>
                            <td class="fw-semibold">{{ $pelanggan->alamat }}</td>
                            <th class="text-start text-secondary">Nomor KWH</th>
                            <td class="fw-semibold">{{ $pelanggan->nomor_kwh }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="mt-3 d-flex gap-2">
                <a href="{{ route('pelanggan.index') }}" class="btn btn-outline-secondary rounded-pill px-4">Kembali ke Daftar</a>
                <a href="{{ route('pelanggan.edit', $pelanggan->id_pelanggan) }}" class="btn btn-primary rounded-pill px-4">Edit Data</a>
            </div>
        </div>
    </div>

    <div class="card shadow rounded-4 border-0 mt-4">
        <div class="card-header bg-info text-white rounded-top-4 fw-bold fs-5">
            <i class="bi bi-clock-history me-2"></i>Riwayat Pembayaran - <span class="fw-normal">{{ $pelanggan->nama_pelanggan }}</span>
        </div>
        <div class="card-body p-0 bg-light rounded-bottom-4">
            <form method="GET" class="p-3 pb-0 d-flex align-items-center" style="gap:1rem;">
                <label for="sort" class="mb-0">Urutkan:</label>
                <select name="sort" id="sort" class="form-select w-auto" onchange="this.form.submit()">
                    <option value="bulan_asc" {{ request('sort')=='bulan_asc' ? 'selected' : '' }}>Bulan ↑</option>
                    <option value="bulan_desc" {{ request('sort')=='bulan_desc' ? 'selected' : '' }}>Bulan ↓</option>
                    <option value="tahun_asc" {{ request('sort')=='tahun_asc' ? 'selected' : '' }}>Tahun ↑</option>
                    <option value="tahun_desc" {{ request('sort')=='tahun_desc' ? 'selected' : '' }}>Tahun ↓</option>
                    <option value="tanggal_asc" {{ request('sort')=='tanggal_asc' ? 'selected' : '' }}>Tanggal Bayar ↑</option>
                    <option value="tanggal_desc" {{ request('sort')=='tanggal_desc' ? 'selected' : '' }}>Tanggal Bayar ↓</option>
                </select>
            </form>
            <div class="table-responsive">
                <table class="table table-striped mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Jumlah Meter</th>
                            <th>Status</th>
                            <th>Tanggal Bayar</th>
                            <th>Total Bayar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $riwayat = $riwayatPembayaran;
                        if(request('sort')=='bulan_asc') $riwayat = $riwayat->sortBy('bulan');
                        elseif(request('sort')=='bulan_desc') $riwayat = $riwayat->sortByDesc('bulan');
                        elseif(request('sort')=='tahun_asc') $riwayat = $riwayat->sortBy('tahun');
                        elseif(request('sort')=='tahun_desc') $riwayat = $riwayat->sortByDesc('tahun');
                        elseif(request('sort')=='tanggal_asc') $riwayat = $riwayat->sortBy('tanggal_pembayaran');
                        elseif(request('sort')=='tanggal_desc') $riwayat = $riwayat->sortByDesc('tanggal_pembayaran');
                        @endphp
                        @forelse($riwayat as $bayar)
                        <tr>
                            <td>{{ $bayar->jumlah_meter }}</td>
                            <td>
                                <span class="badge 
                                    @if($bayar->status == 'lunas') bg-success 
                                    @elseif($bayar->status == 'tunggak') bg-danger 
                                    @else bg-warning text-dark @endif">
                                    {{ ucfirst($bayar->status) }}
                                </span>
                            </td>
                            <td>{{ $bayar->tanggal_pembayaran ? date('d/m/Y', strtotime($bayar->tanggal_pembayaran)) : '-' }}</td>
                            <td>Rp {{ number_format($bayar->total_bayar, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada pembayaran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
