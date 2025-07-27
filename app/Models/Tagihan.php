<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Tagihan extends Model {
    protected $table = 'tagihan';
    protected $primaryKey = 'id_tagihan';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id_tagihan','id_penggunaan','id_pelanggan','bulan','tahun','jumlah_meter','status','tanggal_jatuh_tempo','tanggal_dibuat'
    ];

    // Relasi ke pelanggan
    public function pelanggan() {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    // Relasi ke pembayaran
    public function pembayaran() {
        return $this->hasMany(Pembayaran::class, 'id_tagihan', 'id_tagihan');
    }

    // Relasi ke penggunaan
    public function penggunaan() {
        return $this->belongsTo(Penggunaan::class, 'id_penggunaan', 'id_penggunaan');
    }
}
