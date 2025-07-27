<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Pelanggan;
use App\Models\Tagihan;
use App\Models\Pembayaran;

class PelangganDashboardController extends Controller
{
    public function index()
    {
        $id = session('pelanggan.id_pelanggan');
        $pelanggan = Pelanggan::with('tarif')->find($id);
        $tagihan = Tagihan::where('id_pelanggan', $id)->orderBy('tanggal_jatuh_tempo', 'desc')->get();
        $pembayaran = Pembayaran::where('id_pelanggan', $id)->orderBy('tanggal_pembayaran', 'desc')->get();
        return view('dashboard_pelanggan', compact('pelanggan', 'tagihan', 'pembayaran'));
    }
}
