<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    protected $primaryKey = 'id_izin';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_izin',
        'id_permohonan',
        'nomor_izin',
        'tanggal_terbit',
        'masa_berlaku'
    ];

    public function permohonan()
    {
        return $this->belongsTo(PermohonanIzin::class, 'id_permohonan', 'id_permohonan');
    }
}
