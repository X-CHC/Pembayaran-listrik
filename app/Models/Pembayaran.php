<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Pembayaran extends Model {
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id_pembayaran','id_tagihan','id_pelanggan','tanggal_pembayaran','bulan_bayar','tahun_bayar','biaya_admin','total_bayar','id_user','metode_pembayaran','bukti_pembayaran'
    ];

    // Relasi ke tagihan
    public function tagihan() {
        return $this->belongsTo(Tagihan::class, 'id_tagihan', 'id_tagihan');
    }

    // Relasi ke pelanggan
    public function pelanggan() {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    // Relasi ke user (admin)
    public function user() {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
