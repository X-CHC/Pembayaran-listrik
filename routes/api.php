
<?php
use Illuminate\Support\Facades\Route;
use App\Models\Tagihan;

Route::get('/tagihan-by-pelanggan/{id}', function($id) {
    $tagihans = Tagihan::where('id_pelanggan', $id)
        ->where('status', '!=', 'lunas')
        ->with(['pelanggan.tarif'])
        ->get();
    // Format for dropdown: id_tagihan, bulan, tahun, total_tagihan, nama_pelanggan
    $result = $tagihans->map(function($t) {
        $total = 0;
        if (property_exists($t, 'total_tagihan') && $t->total_tagihan) {
            $total = $t->total_tagihan;
        } else {
            $tarif = $t->pelanggan && $t->pelanggan->tarif ? $t->pelanggan->tarif->tarifperkwh : 0;
            $total = $t->jumlah_meter * $tarif;
        }
        return [
            'id_tagihan' => $t->id_tagihan,
            'bulan' => $t->bulan,
            'tahun' => $t->tahun,
            'total_tagihan' => $total,
            'nama_pelanggan' => $t->pelanggan->nama_pelanggan ?? '-',
        ];
    });
    return response()->json($result);
});
// API untuk semua tagihan (dropdown pembayaran)

Route::get('/api/all-tagihan', function() {
    // Ambil tagihan dengan status belum atau tunggak (bisa dibayar)
    $tagihans = Tagihan::with('pelanggan')
        ->whereIn('status', ['belum', 'tunggak'])
        ->get();
    $result = $tagihans->map(function($t) {
        $total = 0;
        $tarif = $t->pelanggan && $t->pelanggan->tarif ? $t->pelanggan->tarif->tarifperkwh : 0;
        $total = $t->jumlah_meter * $tarif;
        return [
            'id_tagihan' => $t->id_tagihan,
            'id_pelanggan' => $t->id_pelanggan,
            'bulan' => $t->bulan,
            'tahun' => $t->tahun,
            'total_tagihan' => $total,
            'status' => $t->status,
            'nama_pelanggan' => $t->pelanggan->nama_pelanggan ?? '-',
        ];
    });
    return response()->json($result);
});
// API untuk semua tagihan pelanggan (termasuk lunas/belum)

Route::get('/all-tagihan-by-pelanggan/{id}', function($id) {
    $tagihans = Tagihan::where('id_pelanggan', $id)
        ->with(['pelanggan.tarif'])
        ->get();
    $result = $tagihans->map(function($t) {
        $total = 0;
        if (property_exists($t, 'total_tagihan') && $t->total_tagihan) {
            $total = $t->total_tagihan;
        } else {
            $tarif = $t->pelanggan && $t->pelanggan->tarif ? $t->pelanggan->tarif->tarifperkwh : 0;
            $total = $t->jumlah_meter * $tarif;
        }
        return [
            'id_tagihan' => $t->id_tagihan,
            'bulan' => $t->bulan,
            'tahun' => $t->tahun,
            'total_tagihan' => $total,
            'status' => $t->status,
            'nama_pelanggan' => $t->pelanggan->nama_pelanggan ?? '-',
        ];
    });
    return response()->json($result);
});
// API untuk mendapatkan tagihan berdasarkan id pelanggan

Route::get('/tagihan-by-pelanggan/{id}', function($id) {
    $tagihans = Tagihan::where('id_pelanggan', $id)
        ->where('status', '!=', 'lunas')
        ->with(['pelanggan.tarif'])
        ->get();
    $result = $tagihans->map(function($t) {
        $total = 0;
        if (property_exists($t, 'total_tagihan') && $t->total_tagihan) {
            $total = $t->total_tagihan;
        } else {
            $tarif = $t->pelanggan && $t->pelanggan->tarif ? $t->pelanggan->tarif->tarifperkwh : 0;
            $total = $t->jumlah_meter * $tarif;
        }
        return [
            'id_tagihan' => $t->id_tagihan,
            'bulan' => $t->bulan,
            'tahun' => $t->tahun,
            'total_tagihan' => $total,
            'nama_pelanggan' => $t->pelanggan->nama_pelanggan ?? '-',
        ];
    });
    return response()->json($result);
});