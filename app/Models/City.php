<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    protected $table = 'm_kabupaten_kota';

    /**
     * Get all of the users for the City
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(M_user_old::class, 'kode_kota', 'KODE');
    } 

    /**
     * Get the province that owns the City
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'NO_PROP', 'NO_PROP');
    }
    
}
