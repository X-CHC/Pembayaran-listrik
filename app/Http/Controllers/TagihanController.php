<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Penggunaan;
use App\Models\Pelanggan;

class TagihanController extends Controller
{
    public function index()
    {
        $tagihans = Tagihan::with(['penggunaan', 'pelanggan'])->get();
        return view('tagihan.index', compact('tagihans'));
    }

    public function create()
    {
        $penggunaans = Penggunaan::all();
        $pelanggans = Pelanggan::all();
        return view('tagihan.create', compact('penggunaans', 'pelanggans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_penggunaan' => 'required|exists:penggunaan,id_penggunaan',
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'bulan' => 'required|max:10',
            'tahun' => 'required|max:4',
            'jumlah_meter' => 'required|numeric',
            'status' => 'required|in:lunas,belum,tunggak',
            'tanggal_jatuh_tempo' => 'required|date',
        ]);
        Tagihan::create([
            'id_penggunaan' => $request->input('id_penggunaan'),
            'id_pelanggan' => $request->input('id_pelanggan'),
            'bulan' => $request->input('bulan'),
            'tahun' => $request->input('tahun'),
            'jumlah_meter' => $request->input('jumlah_meter'),
            'status' => $request->input('status'),
            'tanggal_jatuh_tempo' => $request->input('tanggal_jatuh_tempo'),
        ]);
        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $penggunaans = Penggunaan::all();
        $pelanggans = Pelanggan::all();
        return view('tagihan.edit', compact('tagihan','penggunaans','pelanggans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_penggunaan' => 'required|exists:penggunaan,id_penggunaan',
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'bulan' => 'required|max:10',
            'tahun' => 'required|max:4',
            'jumlah_meter' => 'required|numeric',
            'status' => 'required|in:lunas,belum,tunggak',
            'tanggal_jatuh_tempo' => 'required|date',
        ]);
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->update([
            'id_penggunaan' => $request->input('id_penggunaan'),
            'id_pelanggan' => $request->input('id_pelanggan'),
            'bulan' => $request->input('bulan'),
            'tahun' => $request->input('tahun'),
            'jumlah_meter' => $request->input('jumlah_meter'),
            'status' => $request->input('status'),
            'tanggal_jatuh_tempo' => $request->input('tanggal_jatuh_tempo'),
        ]);
        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil diupdate.');
    }

    public function destroy($id)
    {
        Tagihan::destroy($id);
        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil dihapus.');
    }
}
