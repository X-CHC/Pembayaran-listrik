@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Tambah User</h2>
    <form action="{{ route('user.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="id_user" class="form-label">ID User</label>
            <input type="text" name="id_user" class="form-control" required maxlength="10">
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required maxlength="50">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required minlength="6">
        </div>
        <div class="mb-3">
            <label for="nama_admin" class="form-label">Nama Admin</label>
            <input type="text" name="nama_admin" class="form-control" required maxlength="100">
        </div>
        <div class="mb-3">
            <label for="id_level" class="form-label">Level</label>
            <select name="id_level" class="form-control" required>
                <option value="">Pilih Level</option>
                @foreach($levels as $level)
                    <option value="{{ $level->id_level }}">{{ $level->nama_level }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
