<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $table = 'm_provinsi_old';

    protected $guarded = [];

    /**
     * Get all of the cities for the Province
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany(City::class, 'NO_PROP', 'NO_PROP');
    }
    
    public function users()
    {
        return $this->hasMany(M_user_old::class, 'kode_prop', 'NO_PROP');
    }


}
