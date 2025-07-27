<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Tarif extends Model {
    protected $table = 'tarif';
    protected $primaryKey = 'id_tarif';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id_tarif','daya','tarifperkwh','aktif','created_at'
    ];

    // Relasi ke pelanggan
    public function pelanggan() {
        return $this->hasMany(Pelanggan::class, 'id_tarif', 'id_tarif');
    }
}
