@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Edit Pembayaran</h2>
    <form action="{{ route('pembayaran.update', $pembayaran->id_pembayaran) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="id_tagihan" class="form-label">Tagihan</label>
            <select name="id_tagihan" class="form-control" required>
                @foreach($tagihans as $t)
                    <option value="{{ $t->id_tagihan }}" @if($pembayaran->id_tagihan==$t->id_tagihan) selected @endif>{{ $t->id_tagihan }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="id_pelanggan" class="form-label">Pelanggan</label>
            <select name="id_pelanggan" class="form-control" required>
                @foreach($pelanggans as $p)
                    <option value="{{ $p->id_pelanggan }}" @if($pembayaran->id_pelanggan==$p->id_pelanggan) selected @endif>{{ $p->id_pelanggan }} - {{ $p->nama_pelanggan }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="tanggal_pembayaran" class="form-label">Tanggal Pembayaran</label>
            <input type="datetime-local" name="tanggal_pembayaran" class="form-control" value="{{ $pembayaran->tanggal_pembayaran }}" required>
        </div>
        <div class="mb-3">
            <label for="bulan_bayar" class="form-label">Bulan Bayar</label>
            <input type="text" name="bulan_bayar" class="form-control" value="{{ $pembayaran->bulan_bayar }}" required maxlength="10">
        </div>
        <div class="mb-3">
            <label for="tahun_bayar" class="form-label">Tahun Bayar</label>
            <input type="text" name="tahun_bayar" class="form-control" value="{{ $pembayaran->tahun_bayar }}" required maxlength="4">
        </div>
        <div class="mb-3">
            <label for="biaya_admin" class="form-label">Biaya Admin</label>
            <input type="number" step="0.01" name="biaya_admin" class="form-control" value="{{ $pembayaran->biaya_admin }}" required>
        </div>
        <div class="mb-3">
            <label for="total_bayar" class="form-label">Total Bayar</label>
            <input type="number" step="0.01" name="total_bayar" class="form-control" value="{{ $pembayaran->total_bayar }}" required>
        </div>
        <div class="mb-3">
            <label for="id_user" class="form-label">User</label>
            <select name="id_user" class="form-control" required>
                @foreach($users as $u)
                    <option value="{{ $u->id_user }}" @if($pembayaran->id_user==$u->id_user) selected @endif>{{ $u->id_user }} - {{ $u->username }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
            <select name="metode_pembayaran" class="form-control" required>
                <option value="tunai" @if($pembayaran->metode_pembayaran=='tunai') selected @endif>Tunai</option>
                <option value="transfer" @if($pembayaran->metode_pembayaran=='transfer') selected @endif>Transfer</option>
                <option value="e-wallet" @if($pembayaran->metode_pembayaran=='e-wallet') selected @endif>E-Wallet</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran (opsional)</label>
            <input type="text" name="bukti_pembayaran" class="form-control" value="{{ $pembayaran->bukti_pembayaran }}" maxlength="255">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
