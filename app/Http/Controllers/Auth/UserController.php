<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
// use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;
use DB;

class UserController extends Controller
{
    /**
     * Get authenticated user.
     *
     */
    public function current(Request $request)
    {
        return new UserResource($request->user());
    }

    public function deleteAccount() {
        $this->middleware('auth');
        if (Auth::user()->admin) {
            return $this->error([
                'message' => 'Cannot delete an admin. Stay with us 🙏'
            ]);
        }
        Auth::user()->delete();
        return $this->success([
           'message' => 'User deleted.'
        ]);
    }

    public function getUsers(){
        $users = DB::table('users')
        ->leftJoin('profil_user','users.id', '=', 'profil_user.id_user')
        ->select(
            'users.name',
            'users.email',
            // DB::raw('(select m_level.level from m_level where m_level.id = users.final_level limit 1) as level'),
            'users.no_wa',
            DB::raw('"" as level'),
            'profil_user.nama_pemilik', 
            DB::raw('(select m_kabupaten.nama_kabupaten from m_kabupaten where m_kabupaten.id_kabupaten = profil_user.id_kabupaten limit 1) as nama_kabupaten'),
            DB::raw('(select m_kecamatan.nama_kecamatan from m_kecamatan where m_kecamatan.id_kecamatan = profil_user.id_kecamatan limit 1) as nama_kecamatan'),
            DB::raw('(select m_kelurahan.nama_kelurahan from m_kelurahan where m_kelurahan.id_kelurahan = profil_user.id_keluarahan limit 1) as nama_kelurahan'),
            DB::raw('(select m_provinsi.nama_provinsi from m_provinsi where m_provinsi.id_provinsi = profil_user.id_provinsi limit 1) as nama_provinsi'),
            'profil_user.nama_usaha',
            'profil_user.email_usaha',
            'profil_user.no_telp',
            'profil_user.no_hp',
            'profil_user.alamat_lengkap',
            'profil_user.jenis_kelamin',
            'profil_user.nik',
            'profil_user.nib',
            
        )
        ->where('aktif', 1)
        ->get();
        return response()->json($users);
    }   

    public function test($id) {
        echo Hashids::encode($id);
        
    }
}
