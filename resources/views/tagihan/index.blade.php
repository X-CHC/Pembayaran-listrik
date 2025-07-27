@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Data Tagihan</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="d-flex align-items-center mb-3" style="gap: 0.5rem;">
        <a href="{{ route('tagihan.create') }}" class="btn btn-primary">Tambah Tagihan</a>
        <a href="{{ route('laporan.semua') }}" class="btn btn-success btn-sm">Cetak Semua Tagihan</a>
        <a href="{{ route('laporan.bulan') }}?bulan={{ date('m') }}&tahun={{ date('Y') }}" class="btn btn-info btn-sm">Cetak Tagihan Bulan Ini</a>
    </div>
    <form method="GET" class="mb-3 d-flex align-items-center" style="gap:1rem;">
        <input type="text" name="search" class="form-control w-auto" placeholder="Cari nama pelanggan..." value="{{ request('search') }}">
        <label for="sort" class="mb-0">Urutkan:</label>
        <select name="sort" id="sort" class="form-select w-auto" onchange="this.form.submit()">
            <option value="nama_asc" {{ request('sort')=='nama_asc' ? 'selected' : '' }}>Nama ↑</option>
            <option value="nama_desc" {{ request('sort')=='nama_desc' ? 'selected' : '' }}>Nama ↓</option>
            <option value="status_asc" {{ request('sort')=='status_asc' ? 'selected' : '' }}>Status ↑</option>
            <option value="status_desc" {{ request('sort')=='status_desc' ? 'selected' : '' }}>Status ↓</option>
            <option value="tempo_asc" {{ request('sort')=='tempo_asc' ? 'selected' : '' }}>Jatuh Tempo ↑</option>
            <option value="tempo_desc" {{ request('sort')=='tempo_desc' ? 'selected' : '' }}>Jatuh Tempo ↓</option>
        </select>
        <button type="submit" class="btn btn-secondary">Cari/Urutkan</button>
    </form>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Pelanggan</th>
                <th>Jumlah Meter</th>
                <th>Status</th>
                <th>Jatuh Tempo</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
            $filtered = $tagihans;
            if(request('search')) {
                $filtered = $filtered->filter(function($t) {
                    return stripos($t->pelanggan->nama_pelanggan ?? '', request('search')) !== false;
                });
            }
            if(request('sort')=='nama_asc') $filtered = $filtered->sortBy(fn($t)=>$t->pelanggan->nama_pelanggan);
            elseif(request('sort')=='nama_desc') $filtered = $filtered->sortByDesc(fn($t)=>$t->pelanggan->nama_pelanggan);
            elseif(request('sort')=='status_asc') $filtered = $filtered->sortBy('status');
            elseif(request('sort')=='status_desc') $filtered = $filtered->sortByDesc('status');
            elseif(request('sort')=='tempo_asc') $filtered = $filtered->sortBy('tanggal_jatuh_tempo');
            elseif(request('sort')=='tempo_desc') $filtered = $filtered->sortByDesc('tanggal_jatuh_tempo');
            @endphp
            @forelse($filtered as $t)
            <tr>
                <td>{{ $t->pelanggan->nama_pelanggan ?? '-' }}</td>
                <td>{{ $t->jumlah_meter }}</td>
                <td>{{ $t->status }}</td>
                <td>{{ $t->tanggal_jatuh_tempo }}</td>
                <td>
                    <a href="{{ route('tagihan.edit', $t->id_tagihan) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('tagihan.destroy', $t->id_tagihan) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus tagihan ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Data tidak ditemukan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
