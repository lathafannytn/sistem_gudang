<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mutasi extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tanggal',
        'jenis_mutasi',
        'jumlah',
        'barangs_id',
        'users_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barangs_id');
    }
}

