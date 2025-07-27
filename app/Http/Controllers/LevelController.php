<?php
namespace App\Http\Controllers;
use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index() {
        $levels = Level::all();
        return view('level.index', compact('levels'));
    }
    public function create() {
        return view('level.create');
    }
    public function store(Request $request) {
        $request->validate([
            'id_level' => 'required|unique:level,id_level',
            'nama_level' => 'required',
        ]);
        Level::create($request->all());
        return redirect()->route('level.index')->with('success', 'Level berhasil ditambahkan');
    }
    public function edit($id) {
        $level = Level::findOrFail($id);
        return view('level.edit', compact('level'));
    }
    public function update(Request $request, $id) {
        $request->validate([
            'nama_level' => 'required',
        ]);
        $level = Level::findOrFail($id);
        $level->update($request->all());
        return redirect()->route('level.index')->with('success', 'Level berhasil diupdate');
    }
    public function destroy($id) {
        $level = Level::findOrFail($id);
        $level->delete();
        return redirect()->route('level.index')->with('success', 'Level berhasil dihapus');
    }
}
