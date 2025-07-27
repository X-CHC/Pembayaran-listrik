@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Data Tarif</h2>
    <!-- Tidak ada laporan PDF untuk tarif, jika ingin bisa ditambah -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('tarif.create') }}" class="btn btn-primary mb-3">Tambah Tarif</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Tarif</th>
                <th>Daya</th>
                <th>Tarif per kWh</th>
                <th>Aktif</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tarifs as $tarif)
            <tr>
                <td>{{ $tarif->id_tarif }}</td>
                <td>{{ $tarif->daya }}</td>
                <td>{{ number_format($tarif->tarifperkwh,2) }}</td>
                <td>{{ $tarif->aktif }}</td>
                <td>
                    <a href="{{ route('tarif.edit', $tarif->id_tarif) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('tarif.destroy', $tarif->id_tarif) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus tarif ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
