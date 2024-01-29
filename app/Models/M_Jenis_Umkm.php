<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Jenis_Umkm extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table ='m_jenis_umkm';

    public function ukm(){
        return $this->hasMany(M_User::class, 'm_jenis_umkm_id');
    }
}
