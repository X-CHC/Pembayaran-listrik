@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Edit Tagihan</h2>
    <form action="{{ route('tagihan.update', $tagihan->id_tagihan) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="id_penggunaan" class="form-label">ID Penggunaan</label>
            <select name="id_penggunaan" class="form-control" required>
                @foreach($penggunaans as $p)
                    <option value="{{ $p->id_penggunaan }}" @if($tagihan->id_penggunaan==$p->id_penggunaan) selected @endif>{{ $p->id_penggunaan }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="id_pelanggan" class="form-label">ID Pelanggan</label>
            <select name="id_pelanggan" class="form-control" required>
                @foreach($pelanggans as $p)
                    <option value="{{ $p->id_pelanggan }}" @if($tagihan->id_pelanggan==$p->id_pelanggan) selected @endif>{{ $p->id_pelanggan }} - {{ $p->nama_pelanggan }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="bulan" class="form-label">Bulan</label>
            <input type="text" name="bulan" class="form-control" value="{{ $tagihan->bulan }}" required maxlength="10">
        </div>
        <div class="mb-3">
            <label for="tahun" class="form-label">Tahun</label>
            <input type="text" name="tahun" class="form-control" value="{{ $tagihan->tahun }}" required maxlength="4">
        </div>
        <div class="mb-3">
            <label for="jumlah_meter" class="form-label">Jumlah Meter</label>
            <input type="number" step="0.01" name="jumlah_meter" class="form-control" value="{{ $tagihan->jumlah_meter }}" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-control" required>
                <option value="lunas" @if($tagihan->status=='lunas') selected @endif>Lunas</option>
                <option value="belum" @if($tagihan->status=='belum') selected @endif>Belum</option>
                <option value="tunggak" @if($tagihan->status=='tunggak') selected @endif>Tunggak</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="tanggal_jatuh_tempo" class="form-label">Tanggal Jatuh Tempo</label>
            <input type="date" name="tanggal_jatuh_tempo" class="form-control" value="{{ $tagihan->tanggal_jatuh_tempo }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('tagihan.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
