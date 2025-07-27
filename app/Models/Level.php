<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Level extends Model {
    protected $table = 'level';
    protected $primaryKey = 'id_level';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id_level', 'nama_level'];
}
