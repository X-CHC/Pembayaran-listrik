<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Penggunaan extends Model {
    protected $table = 'penggunaan';
    protected $primaryKey = 'id_penggunaan';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id_penggunaan','id_pelanggan','bulan','tahun','meter_awal','meter_akhir','tanggal_catat','status_verifikasi'
    ];

    public function pelanggan() {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }
}
