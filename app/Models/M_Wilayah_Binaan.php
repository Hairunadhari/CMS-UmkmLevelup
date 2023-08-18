<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class m_Wilayah_Binaan extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'm_wilayah_binaan';

    public function user()
    {
        return $this->hasMany(M_user_old::class, 'wilayah_binaan', 'id')
            ->where('status_aktif', 1);
    }
}
