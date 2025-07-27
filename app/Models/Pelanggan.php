<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Pelanggan extends Model {
    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'id_pelanggan','username','password','nomor_kwh','nama_pelanggan','alamat','id_tarif','status_aktif','tanggal_daftar'
    ];

    // Relasi ke tarif
    public function tarif() {
        return $this->belongsTo(Tarif::class, 'id_tarif', 'id_tarif');
    }

    // Relasi ke tagihan
    public function tagihan() {
        return $this->hasMany(Tagihan::class, 'id_pelanggan', 'id_pelanggan');
    }

    // Relasi ke pembayaran
    public function pembayaran() {
        return $this->hasMany(Pembayaran::class, 'id_pelanggan', 'id_pelanggan');
    }
}
