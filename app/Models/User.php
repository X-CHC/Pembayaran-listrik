<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'nama_admin',
        'id_level',
        'last_login',
        'created_at',
    ];

    protected $hidden = [
        'password',
    ];

    protected $primaryKey = 'id_user';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'user';

    // Relasi ke pembayaran
    public function pembayaran() {
        return $this->hasMany(Pembayaran::class, 'id_user', 'id_user');
    }

    // Relasi ke level
    public function level() {
        return $this->belongsTo(Level::class, 'id_level', 'id_level');
    }
}
