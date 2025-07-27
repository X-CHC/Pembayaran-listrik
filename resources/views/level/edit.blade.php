@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Edit Level</h2>
    <form action="{{ route('level.update', $level->id_level) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="nama_level" class="form-label">Nama Level</label>
            <input type="text" name="nama_level" class="form-control" value="{{ $level->nama_level }}" required maxlength="50">
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('level.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
