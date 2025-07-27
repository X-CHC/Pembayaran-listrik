<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penggunaan;
use App\Models\Pelanggan;

class PenggunaanController extends Controller
{
    public function index()
    {
        $penggunaans = Penggunaan::with('pelanggan')->get();
        return view('penggunaan.index', compact('penggunaans'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::all();
        return view('penggunaan.create', compact('pelanggans'));
    }

    // Tambahan endpoint untuk AJAX meter akhir
    public function meterAkhir($id)
    {
        $penggunaanTerakhir = Penggunaan::where('id_pelanggan', $id)
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->first();
        return response()->json([
            'meter_akhir' => $penggunaanTerakhir ? $penggunaanTerakhir->meter_akhir : 0
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'bulan' => 'required|max:10',
            'tahun' => 'required|max:4',
            'meter_awal' => 'required|numeric',
            'meter_akhir' => 'required|numeric|gte:meter_awal',
            'tanggal_catat' => 'required|date',
            'status_verifikasi' => 'required|in:terverifikasi,belum',
        ]);
        Penggunaan::create([
            'id_pelanggan' => $request->input('id_pelanggan'),
            'bulan' => $request->input('bulan'),
            'tahun' => $request->input('tahun'),
            'meter_awal' => $request->input('meter_awal'),
            'meter_akhir' => $request->input('meter_akhir'),
            'tanggal_catat' => $request->input('tanggal_catat'),
            'status_verifikasi' => $request->input('status_verifikasi'),
        ]);
        return redirect()->route('penggunaan.index')->with('success', 'Data penggunaan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $penggunaan = Penggunaan::findOrFail($id);
        $pelanggans = Pelanggan::all();
        return view('penggunaan.edit', compact('penggunaan','pelanggans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'bulan' => 'required|max:10',
            'tahun' => 'required|max:4',
            'meter_awal' => 'required|numeric',
            'meter_akhir' => 'required|numeric|gte:meter_awal',
            'tanggal_catat' => 'required|date',
            'status_verifikasi' => 'required|in:terverifikasi,belum',
        ]);
        $penggunaan = Penggunaan::findOrFail($id);
        $penggunaan->update([
            'id_pelanggan' => $request->input('id_pelanggan'),
            'bulan' => $request->input('bulan'),
            'tahun' => $request->input('tahun'),
            'meter_awal' => $request->input('meter_awal'),
            'meter_akhir' => $request->input('meter_akhir'),
            'tanggal_catat' => $request->input('tanggal_catat'),
            'status_verifikasi' => $request->input('status_verifikasi'),
        ]);
        return redirect()->route('penggunaan.index')->with('success', 'Data penggunaan berhasil diupdate.');
    }

    public function destroy($id)
    {
        Penggunaan::destroy($id);
        return redirect()->route('penggunaan.index')->with('success', 'Data penggunaan berhasil dihapus.');
    }
}
