<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $primaryKey = 'id_dokumen';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_dokumen',
        'id_permohonan',
        'tipe_dokumen',
        'filePath'
    ];

    public function permohonan()
    {
        return $this->belongsTo(PermohonanIzin::class, 'id_permohonan', 'id_permohonan');
    }
}
