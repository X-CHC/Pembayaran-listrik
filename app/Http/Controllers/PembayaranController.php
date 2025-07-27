<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::with(['tagihan', 'pelanggan', 'user'])->get();
        return view('pembayaran.index', compact('pembayarans'));
    }

    public function create()
    {
        $tagihans = Tagihan::all();
        $pelanggans = Pelanggan::all();
        $users = User::all();
        return view('pembayaran.create', compact('tagihans', 'pelanggans', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_tagihan' => 'required|exists:tagihan,id_tagihan',
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'tanggal_pembayaran' => 'required|date',
            'bulan_bayar' => 'required|max:10',
            'tahun_bayar' => 'required|max:4',
            'biaya_admin' => 'required|numeric',
            'total_bayar' => 'required|numeric',
            'metode_pembayaran' => 'required|in:tunai,transfer,e-wallet',
            'bukti_pembayaran' => 'nullable|file|image|max:2048',
        ]);

        $buktiPath = null;
        if ($request->metode_pembayaran === 'tunai') {
            $buktiPath = '-';
        } elseif ($request->hasFile('bukti_pembayaran')) {
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        Pembayaran::create([
            'id_tagihan' => $request->input('id_tagihan'),
            'id_pelanggan' => $request->input('id_pelanggan'),
            'tanggal_pembayaran' => $request->input('tanggal_pembayaran'),
            'bulan_bayar' => $request->input('bulan_bayar'),
            'tahun_bayar' => $request->input('tahun_bayar'),
            'biaya_admin' => $request->input('biaya_admin'),
            'total_bayar' => $request->input('total_bayar'),
            'id_user' => session('admin.id_user'), 
            'metode_pembayaran' => $request->input('metode_pembayaran'),
            'bukti_pembayaran' => $buktiPath,
        ]);
        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $tagihans = Tagihan::all();
        $pelanggans = Pelanggan::all();
        $users = User::all();
        return view('pembayaran.edit', compact('pembayaran','tagihans','pelanggans','users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_tagihan' => 'required|exists:tagihan,id_tagihan',
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'tanggal_pembayaran' => 'required|date',
            'bulan_bayar' => 'required|max:10',
            'tahun_bayar' => 'required|max:4',
            'biaya_admin' => 'required|numeric',
            'total_bayar' => 'required|numeric',
            'id_user' => 'required|exists:user,id_user',
            'metode_pembayaran' => 'required|in:tunai,transfer,e-wallet',
            'bukti_pembayaran' => 'nullable|max:255',
        ]);
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update([
            'id_tagihan' => $request->input('id_tagihan'),
            'id_pelanggan' => $request->input('id_pelanggan'),
            'tanggal_pembayaran' => $request->input('tanggal_pembayaran'),
            'bulan_bayar' => $request->input('bulan_bayar'),
            'tahun_bayar' => $request->input('tahun_bayar'),
            'biaya_admin' => $request->input('biaya_admin'),
            'total_bayar' => $request->input('total_bayar'),
            'id_user' => $request->input('id_user'),
            'metode_pembayaran' => $request->input('metode_pembayaran'),
            'bukti_pembayaran' => $request->input('bukti_pembayaran'),
        ]);
        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil diupdate.');
    }

    public function show($id)
    {
        $pembayaran = Pembayaran::with(['tagihan', 'pelanggan', 'user'])->findOrFail($id);
        return view('pembayaran.show', compact('pembayaran'));
    }

    public function acc($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->status = 'Lunas';
        $pembayaran->save();
        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil di-ACC dan dinyatakan Lunas.');
    }

    public function destroy($id)
    {
        Pembayaran::destroy($id);
        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil dihapus.');
    }
}
