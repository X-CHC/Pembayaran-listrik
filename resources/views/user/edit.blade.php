@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Edit User</h2>
    <form action="{{ route('user.update', $user->id_user) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="{{ $user->username }}" required maxlength="50">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password (isi jika ingin ganti)</label>
            <input type="password" name="password" class="form-control" minlength="6">
        </div>
        <div class="mb-3">
            <label for="nama_admin" class="form-label">Nama Admin</label>
            <input type="text" name="nama_admin" class="form-control" value="{{ $user->nama_admin }}" required maxlength="100">
        </div>
        <div class="mb-3">
            <label for="id_level" class="form-label">Level</label>
            <select name="id_level" class="form-control" required>
                @foreach($levels as $level)
                    <option value="{{ $level->id_level }}" @if($user->id_level==$level->id_level) selected @endif>{{ $level->nama_level }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
