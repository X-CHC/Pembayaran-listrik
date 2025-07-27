@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Edit Tarif</h2>
    <form action="{{ route('tarif.update', $tarif->id_tarif) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="daya" class="form-label">Daya</label>
            <input type="text" name="daya" class="form-control" value="{{ $tarif->daya }}" required maxlength="20">
        </div>
        <div class="mb-3">
            <label for="tarifperkwh" class="form-label">Tarif per kWh</label>
            <input type="number" step="0.01" name="tarifperkwh" class="form-control" value="{{ $tarif->tarifperkwh }}" required>
        </div>
        <div class="mb-3">
            <label for="aktif" class="form-label">Status Aktif</label>
            <select name="aktif" class="form-control" required>
                <option value="Y" @if($tarif->aktif=='Y') selected @endif>Y</option>
                <option value="N" @if($tarif->aktif=='N') selected @endif>N</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('tarif.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
