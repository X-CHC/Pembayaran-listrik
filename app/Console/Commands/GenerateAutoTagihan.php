<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pelanggan;
use App\Models\Tagihan;
use App\Models\Penggunaan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GenerateAutoTagihan extends Command
{
    protected $signature = 'tagihan:auto-generate';
    protected $description = 'Generate tagihan otomatis untuk pelanggan yang tidak input meteran di akhir bulan';

    public function handle()
    {
        $now = Carbon::now();
        $bulan = $now->format('m');
        $tahun = $now->format('Y');
        $tanggal_jatuh_tempo = $now->copy()->endOfMonth()->format('Y-m-d');

        $pelangganAktif = Pelanggan::where('status_aktif', 'aktif')->get();
        $created = 0;
        foreach ($pelangganAktif as $pelanggan) {
            // Pastikan $idPelanggan langsung di-set di awal
            $idPelanggan = $pelanggan->getAttribute('id_pelanggan');

            // Cek apakah sudah ada tagihan bulan ini
            $tagihanAda = Tagihan::where('id_pelanggan', $idPelanggan)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->exists();
            if ($tagihanAda) continue;

            // Cek apakah ada input penggunaan bulan ini
            $penggunaan = Penggunaan::where('id_pelanggan', $idPelanggan)
                ->where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->first();

            if (!$penggunaan) {
                // Ambil penggunaan terakhir (jika ada)
                $penggunaanTerakhir = Penggunaan::where('id_pelanggan', $idPelanggan)
                    ->orderByDesc('tahun')
                    ->orderByDesc('bulan')
                    ->first();
                $meter_awal = $penggunaanTerakhir ? $penggunaanTerakhir->meter_akhir : 0;
                $meter_akhir = $meter_awal; // Belum input, jadi sama
                // Buat penggunaan baru
                $penggunaanBaru = Penggunaan::create([
                    'id_pelanggan' => $idPelanggan,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'meter_awal' => $meter_awal,
                    'meter_akhir' => $meter_akhir,
                    'tanggal_catat' => $now->format('Y-m-d'),
                    'status_verifikasi' => 'belum',
                ]);
                // Buat tagihan denda 300.000
                Tagihan::create([
                    'id_penggunaan' => $penggunaanBaru->id_penggunaan,
                    'id_pelanggan' => $idPelanggan,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'jumlah_meter' => 0,
                    'status' => 'tunggak',
                    'tanggal_jatuh_tempo' => $tanggal_jatuh_tempo,
                    'tanggal_dibuat' => $now->format('Y-m-d'),
                ]);
                $created++;
            }
        }
        $this->info("Tagihan otomatis berhasil dibuat untuk $created pelanggan.");
    }
}
