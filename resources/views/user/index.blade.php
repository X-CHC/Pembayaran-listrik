@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Data User</h2>
    <!-- Tidak ada laporan PDF untuk user, jika ingin bisa ditambah -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <a href="{{ route('user.create') }}" class="btn btn-primary mb-3">Tambah User</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID User</th>
                <th>Username</th>
                <th>Nama Admin</th>
                <th>Level</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id_user }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->nama_admin }}</td>
                <td>{{ $user->id_level }}</td>
                <td>
                    <a href="{{ route('user.edit', $user->id_user) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('user.destroy', $user->id_user) }}" method="POST" style="display:inline-block">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus user ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
