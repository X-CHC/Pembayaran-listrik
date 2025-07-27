<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarif;

class TarifController extends Controller
{
    public function index()
    {
        $tarifs = Tarif::all();
        return view('tarif.index', compact('tarifs'));
    }

    public function create()
    {
        return view('tarif.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_tarif' => 'required|max:10|unique:tarif,id_tarif',
            'daya' => 'required|max:20',
            'tarifperkwh' => 'required|numeric',
            'aktif' => 'required|in:Y,N',
        ]);
        Tarif::create([
            'id_tarif' => $request->input('id_tarif'),
            'daya' => $request->input('daya'),
            'tarifperkwh' => $request->input('tarifperkwh'),
            'aktif' => $request->input('aktif'),
        ]);
        return redirect()->route('tarif.index')->with('success', 'Tarif berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tarif = Tarif::findOrFail($id);
        return view('tarif.edit', compact('tarif'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'daya' => 'required|max:20',
            'tarifperkwh' => 'required|numeric',
            'aktif' => 'required|in:Y,N',
        ]);
        $tarif = Tarif::findOrFail($id);
        $tarif->update([
            'daya' => $request->input('daya'),
            'tarifperkwh' => $request->input('tarifperkwh'),
            'aktif' => $request->input('aktif'),
        ]);
        return redirect()->route('tarif.index')->with('success', 'Tarif berhasil diupdate.');
    }

    public function destroy($id)
    {
        Tarif::destroy($id);
        return redirect()->route('tarif.index')->with('success', 'Tarif berhasil dihapus.');
    }
}
