<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $primaryKey = 'id_survey';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_survey',
        'id_permohonan',
        'lokasi',
        'hasil_survey',
        'tanggal_survey'
    ];

    public function permohonan()
    {
        return $this->belongsTo(PermohonanIzin::class, 'id_permohonan', 'id_permohonan');
    }
}
