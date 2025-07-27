<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Tarif;
use Illuminate\Support\Facades\Hash;

class PelangganController extends Controller
{
    public function index()
    {
        $query = Pelanggan::with('tarif');
        if (request()->has('cari') && request('cari') != '') {
            $query->where('nama_pelanggan', 'like', '%' . request('cari') . '%');
        }
        $pelanggans = $query->get();
        return view('pelanggan.index', compact('pelanggans'));
    }

    public function create()
    {
        $tarifs = Tarif::where('aktif', 'Y')->get();
        return view('pelanggan.create', compact('tarifs'));
    }

    public function store(Request $request)
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
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'nomor_kwh' => $request->input('nomor_kwh'),
            'nama_pelanggan' => $request->input('nama_pelanggan'),
            'alamat' => $request->input('alamat'),
            'id_tarif' => $request->input('id_tarif'),
            'status_aktif' => 'aktif',
            'tanggal_daftar' => \Carbon\Carbon::now(),
        ]);
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $tarifs = Tarif::where('aktif', 'Y')->get();
        return view('pelanggan.edit', compact('pelanggan','tarifs'));
    }

    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $request->validate([
            'username' => 'required|max:50|unique:pelanggan,username,'.$id.',id_pelanggan',
            'nomor_kwh' => 'required|max:20|unique:pelanggan,nomor_kwh,'.$id.',id_pelanggan',
            'nama_pelanggan' => 'required|max:100',
            'alamat' => 'required',
            'id_tarif' => 'required|exists:tarif,id_tarif',
            'status_aktif' => 'required|in:aktif,nonaktif',
            'tanggal_daftar' => 'required|date',
        ]);
        $data = [
            'username' => $request->input('username'),
            'nomor_kwh' => $request->input('nomor_kwh'),
            'nama_pelanggan' => $request->input('nama_pelanggan'),
            'alamat' => $request->input('alamat'),
            'id_tarif' => $request->input('id_tarif'),
            'status_aktif' => $request->input('status_aktif'),
            'tanggal_daftar' => $request->input('tanggal_daftar'),
        ];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }
        $pelanggan->update($data);
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diupdate.');
    }

    public function destroy($id)
    {
        Pelanggan::destroy($id);
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
    }

    public function show($id)
    {
        $pelanggan = Pelanggan::with('tarif')->findOrFail($id);
        $riwayatPembayaran = \App\Models\Tagihan::where('tagihan.id_pelanggan', $id)
            ->leftJoin('pembayaran', 'tagihan.id_tagihan', '=', 'pembayaran.id_tagihan')
            ->select(
                'tagihan.bulan',
                'tagihan.tahun',
                'tagihan.jumlah_meter',
                'tagihan.status',
                'pembayaran.tanggal_pembayaran',
                'pembayaran.total_bayar'
            )
            ->orderBy('tagihan.tahun', 'desc')
            ->orderBy('tagihan.bulan', 'desc')
            ->get();
        return view('pelanggan.show', compact('pelanggan', 'riwayatPembayaran'));
    }
}
