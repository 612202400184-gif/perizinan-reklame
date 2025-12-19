<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $primaryKey = 'id_pembayaran';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pembayaran',
        'id_permohonan',
        'nominal',
        'metode_pembayaran',
        'status_pembayaran'
    ];

    public function permohonan()
    {
        return $this->belongsTo(PermohonanIzin::class, 'id_permohonan', 'id_permohonan');
    }
}
