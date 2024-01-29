<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Level extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table ='m_level';

    public function user(){
        return $this->hasMany(M_User::class, 'final_level');
    }
}
