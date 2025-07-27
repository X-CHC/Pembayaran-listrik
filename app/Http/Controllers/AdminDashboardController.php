<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Pembayaran;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalPelanggan = Pelanggan::count();
        $totalPembayaran = Pembayaran::sum('total_bayar');
        $pelangganTerbaru = Pelanggan::with('tarif')->orderBy('tanggal_daftar', 'desc')->limit(5)->get();
        return view('dashboard_admin', compact('totalPelanggan', 'totalPembayaran', 'pelangganTerbaru'));
    }
}
