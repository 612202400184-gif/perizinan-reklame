<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanIzin extends Model
{
    use HasFactory;

    protected $table = 'permohonan_izins';
    protected $primaryKey = 'id_permohonan';
    public $incrementing = false; // Karena PK adalah String (REG-xxxx)
    protected $keyType = 'string';

    protected $fillable = [
        'id_permohonan',
        'tanggal_pengajuan',
        'status'
    ];

    // Relasi: Satu permohonan memiliki banyak dokumen
    public function dokumens()
    {
        return $this->hasMany(Dokumen::class, 'id_permohonan', 'id_permohonan');
    }

    // Relasi: Satu permohonan memiliki satu hasil survey
    public function survey()
    {
        return $this->hasOne(Survey::class, 'id_permohonan', 'id_permohonan');
    }

    // Relasi: Satu permohonan memiliki satu data izin
    public function izin()
    {
        return $this->hasOne(Izin::class, 'id_permohonan', 'id_permohonan');
    }

    // Relasi: Satu permohonan memiliki satu data pembayaran
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_permohonan', 'id_permohonan');
    }
}
