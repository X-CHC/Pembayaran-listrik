@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Tambah Tarif</h2>
    <form action="{{ route('tarif.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="id_tarif" class="form-label">ID Tarif</label>
            <input type="text" name="id_tarif" class="form-control" required maxlength="10">
        </div>
        <div class="mb-3">
            <label for="daya" class="form-label">Daya</label>
            <input type="text" name="daya" class="form-control" required maxlength="20">
        </div>
        <div class="mb-3">
            <label for="tarifperkwh" class="form-label">Tarif per kWh</label>
            <input type="number" step="0.01" name="tarifperkwh" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="aktif" class="form-label">Status Aktif</label>
            <select name="aktif" class="form-control" required>
                <option value="Y">Y</option>
                <option value="N">N</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('tarif.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
