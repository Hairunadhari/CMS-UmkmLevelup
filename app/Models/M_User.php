<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_User extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table ='m_users';

    public function jenisumkm(){
        return $this->belongsTo(M_Jenis_Umkm::class, 'm_jenis_umkm_id');
    }
}
