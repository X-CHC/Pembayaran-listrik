@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Data Level</h2>
    <!-- Tidak ada laporan PDF untuk level, jika ingin bisa ditambah -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('level.create') }}" class="btn btn-primary mb-3">Tambah Level</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Level</th>
                <th>Nama Level</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($levels as $level)
            <tr>
                <td>{{ $level->id_level }}</td>
                <td>{{ $level->nama_level }}</td>
                <td>
                    <a href="{{ route('level.edit', $level->id_level) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('level.destroy', $level->id_level) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus level ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
