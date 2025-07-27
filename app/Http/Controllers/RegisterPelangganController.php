<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Tarif;
use Illuminate\Support\Facades\Hash;

class RegisterPelangganController extends Controller
{
    public function showForm()
    {
        $tarifs = Tarif::where('aktif', 'Y')->get();
        return view('auth.register_pelanggan', compact('tarifs'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'username' => 'required|max:50|unique:pelanggan,username',
            'password' => 'required|min:6',
            'nomor_kwh' => 'required|max:20|unique:pelanggan,nomor_kwh',
            'nama_pelanggan' => 'required|max:100',
            'alamat' => 'required',
            'id_tarif' => 'required|exists:tarif,id_tarif',
        ]);
        Pelanggan::create([
            'id_pelanggan' => null, // auto jika pakai auto increment
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'nomor_kwh' => $request->input('nomor_kwh'),
            'nama_pelanggan' => $request->input('nama_pelanggan'),
            'alamat' => $request->input('alamat'),
            'id_tarif' => $request->input('id_tarif'),
            'status_aktif' => 'aktif',
            'tanggal_daftar' => now(),
        ]);
        return redirect()->route('register.pelanggan')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
}
