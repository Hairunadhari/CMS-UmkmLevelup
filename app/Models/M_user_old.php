<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_user_old extends Model
{
    use HasFactory;

    protected $table = 'm_users';

    protected $guarded = [];
    protected $hidden = [
        // 'password',
        'remember_token',
        'token_jwt',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the province that owns the m_User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function resultQuestioner()
    {
        return $this->hasMany(Resultquestioner::class, 'm_user_id');
    }

    public function resultPostest()
    {
        return $this->hasMany(ResultPostTest::class, 'm_user_id');
    }


    public function province()
    {
        return $this->belongsTo(Province::class, 'kode_prop', 'NO_PROP');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'kode_kota', 'KODE');
    }

    /**
     * Get the jenis_usaha that owns the m_User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenis_usaha()
    {
        return $this->belongsTo(JenisUsaha::class, 'm_jenis_usaha_id', 'id')
            ->where('status_hapus', 0);
    }

    public function jenis_umkm()
    {
        return $this->belongsTo(JenisUmkm::class, 'm_jenis_umkm_id', 'id')
            ->where('status_hapus', 0);
    }

    /**
     * Get the umkm that owns the m_User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function umkm()
    {
        return $this->belongsTo(M_UMKM::class, 'id', 'id_user')
            ->where('status_hapus', 0);
    }

    public function wilayah_bina()
    {
        return $this->belongsTo(M_Wilayah_Binaan::class, 'wilayah_binaan', 'id')
            ->where('status_aktif', 1);
    }

    public function fasilitator()
    {
        return $this->belongsTo(M_Fasilitator::class, 'nama_fasil', 'id')
            ->where('status_aktif', 1);
    }
    public function resultQuestion()
    {
        return $this->hasOne(Resultquestioner::class, 'm_user_id', 'id');
    }

    public function resultQuestionPostest()
    {
        return $this->hasOne(ResultPostTest::class, 'm_user_id', 'id');
    }


    public function resultAnswerPostest()
    {
        return $this->hasMany(QuestionerPostTest::class, 'm_user_id', 'id');
    }

    public function resultUploadPostest()
    {
        return $this->hasOne(QuestionerUpload::class, 'm_user_id', 'id');
    }

    public function questioners()
    {
        return $this->hasMany(Questioner::class, 'm_user_id', 'id');
    }


    public function questionerUploads()
    {
        return $this->hasMany(QuestionerUpload::class, 'm_user_id', 'id');
    }

    public function newQuestionerUploads()
    {
        return $this->hasMany(NewQuestionerUpload::class, 'm_user_id', 'id');
    }

    public function newAnswerPostest()
    {
        return $this->hasMany(NewQuestionerPostTest::class, 'm_user_id', 'id');
    }

    public function newResultPostest()
    {
        return $this->hasMany(NewResultPostTest::class, 'm_user_id', 'id');
    }
}
