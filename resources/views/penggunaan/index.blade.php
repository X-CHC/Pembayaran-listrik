@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Data Penggunaan</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('penggunaan.create') }}" class="btn btn-primary mb-3">Tambah Penggunaan</a>
    <form method="GET" class="mb-3 d-flex align-items-center" style="gap:1rem;">
        <input type="text" name="search" class="form-control w-auto" placeholder="Cari nama pelanggan..." value="{{ request('search') }}">
        <label for="sort" class="mb-0">Urutkan:</label>
        <select name="sort" id="sort" class="form-select w-auto" onchange="this.form.submit()">
            <option value="nama_asc" {{ request('sort')=='nama_asc' ? 'selected' : '' }}>Nama ↑</option>
            <option value="nama_desc" {{ request('sort')=='nama_desc' ? 'selected' : '' }}>Nama ↓</option>
            <option value="bulan_asc" {{ request('sort')=='bulan_asc' ? 'selected' : '' }}>Bulan ↑</option>
            <option value="bulan_desc" {{ request('sort')=='bulan_desc' ? 'selected' : '' }}>Bulan ↓</option>
            <option value="tahun_asc" {{ request('sort')=='tahun_asc' ? 'selected' : '' }}>Tahun ↑</option>
            <option value="tahun_desc" {{ request('sort')=='tahun_desc' ? 'selected' : '' }}>Tahun ↓</option>
            <option value="tanggal_asc" {{ request('sort')=='tanggal_asc' ? 'selected' : '' }}>Tanggal Catat ↑</option>
            <option value="tanggal_desc" {{ request('sort')=='tanggal_desc' ? 'selected' : '' }}>Tanggal Catat ↓</option>
        </select>
        <button type="submit" class="btn btn-secondary">Cari/Urutkan</button>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pelanggan</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Meter Awal</th>
                <th>Meter Akhir</th>
                <th>Tanggal Catat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
            $filtered = $penggunaans;
            if(request('search')) {
                $filtered = $filtered->filter(function($p) {
                    return stripos(optional($p->pelanggan)->nama_pelanggan ?? '', request('search')) !== false;
                });
            }
            if(request('sort')=='nama_asc') $filtered = $filtered->sortBy(fn($p)=>optional($p->pelanggan)->nama_pelanggan);
            elseif(request('sort')=='nama_desc') $filtered = $filtered->sortByDesc(fn($p)=>optional($p->pelanggan)->nama_pelanggan);
            elseif(request('sort')=='bulan_asc') $filtered = $filtered->sortBy('bulan');
            elseif(request('sort')=='bulan_desc') $filtered = $filtered->sortByDesc('bulan');
            elseif(request('sort')=='tahun_asc') $filtered = $filtered->sortBy('tahun');
            elseif(request('sort')=='tahun_desc') $filtered = $filtered->sortByDesc('tahun');
            elseif(request('sort')=='tanggal_asc') $filtered = $filtered->sortBy('tanggal_catat');
            elseif(request('sort')=='tanggal_desc') $filtered = $filtered->sortByDesc('tanggal_catat');
            @endphp
            @forelse($filtered as $p)
            <tr>
                <td>{{ $p->id_penggunaan }}</td>
                <td>{{ optional($p->pelanggan)->nama_pelanggan ?? '-' }}</td>
                <td>{{ $p->bulan }}</td>
                <td>{{ $p->tahun }}</td>
                <td>{{ $p->meter_awal }}</td>
                <td>{{ $p->meter_akhir }}</td>
                <td>{{ $p->tanggal_catat }}</td>
                <td>{{ $p->status_verifikasi }}</td>
                <td>
                    <a href="{{ route('penggunaan.edit', $p->id_penggunaan) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('penggunaan.destroy', $p->id_penggunaan) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus data ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">Data tidak ditemukan</td>
            </tr>
            @endforelse
</div>
@endsection
