<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultquestioner extends Model
{
    use HasFactory;


    protected $guarded = [];

    //
    /**
     * Get all of the questioners for the Resultquestioner
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    /**
     * Get the user associated with the Resultquestioner
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(M_user_old::class, 'id', 'm_user_id')
            // ->with(['wilayah_bina', 'fasilitator'])
            ->select('id', 'nama_pelapak', 'nama_toko', 'alamat', 'email', 'kontak', 'no_usaha', 'nama_fasil', 'wilayah_binaan')
            ->where('status_hapus', 0);
    }

    public function users()
    {
        return $this->belongsTo(M_user_old::class, 'm_user_id');
    }
}
