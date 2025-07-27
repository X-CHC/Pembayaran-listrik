<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Tagihan;
use PDF;

class LaporanController extends Controller
{
    // Laporan semua tagihan 1 pelanggan
    public function pelanggan($id)
    {
        $pelanggan = Pelanggan::with('tagihan')->findOrFail($id);
        $pdf = PDF::loadView('laporan.pelanggan', compact('pelanggan'));
        $idPelanggan = is_object($pelanggan) ? $pelanggan->getAttribute('id_pelanggan') : (is_array($pelanggan) ? $pelanggan['id_pelanggan'] : '');
        return $pdf->download('laporan_tagihan_pelanggan_'.$idPelanggan.'.pdf');
    }

    // Laporan semua tagihan dalam 1 bulan
    public function bulan(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $tagihan = Tagihan::with('pelanggan')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();
        $pdf = PDF::loadView('laporan.bulan', compact('tagihan', 'bulan', 'tahun'));
        return $pdf->download('laporan_tagihan_'.$bulan.'_'.$tahun.'.pdf');
    }

    // Laporan semua tagihan (opsional, bisa filter)
    public function semua(Request $request)
    {
        $tagihan = Tagihan::with('pelanggan')->get();
        $pdf = PDF::loadView('laporan.semua', compact('tagihan'));
        return $pdf->download('laporan_tagihan_semua.pdf');
    }
}
