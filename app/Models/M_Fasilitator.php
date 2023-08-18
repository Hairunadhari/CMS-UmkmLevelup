<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_Fasilitator extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'm_fasilitator';

    public function wilayah_binaan()
    {
        return $this->belongsTo(m_Wilayah_Binaan::class, 'id_wilayah_binaan', 'id');
    }

    public function pelatihan()
    {
        return $this->hasMany(Pelatihan::class, 'id_fasil');
    }

    public function kujungan_umkm()
    {
        return $this->hasMany(KunjunganUmkm::class, 'id_fasil');
    }

    public function kujungan_stakeholder()
    {
        return $this->hasMany(KunjunganStakholder::class, 'id_fasil');
    }

    public function users()
    {
        return $this->hasMany(M_user_old::class, 'nama_fasil', 'id');
    }
}
