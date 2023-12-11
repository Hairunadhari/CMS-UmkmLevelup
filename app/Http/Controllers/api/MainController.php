<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\M_User;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function countuser(){
        $countUser = DB::table('m_users')->whereNotNull('gender')->count();
        $countPria = DB::table('m_users')->where('gender','Like', '%laki%')->count();
        $countPerempuan = DB::table('m_users')->where('gender', 'Like','%perempuan%')->count();
        return response()->json(['total_user' => $countUser, 'total_laki-laki' => $countPria, 'total_perempuan' => $countPerempuan]);
    }

    public function skalausaha(){
        $skalamikro = M_User::with('jenisumkm')->whereHas('jenisumkm', function($query){
            $query->where('nama_jenis_umkm','Like', '%mikro%');
        })->count();

        $skalakecil = M_User::with('jenisumkm')->whereHas('jenisumkm', function($query){
            $query->where('nama_jenis_umkm','Like', '%kecil%');
        })->count();

        $skalamenengah = M_User::with('jenisumkm')->whereHas('jenisumkm', function($query){
            $query->where('nama_jenis_umkm','Like', '%menengah%');
        })->count();
        return response()->json(['mikro'=>$skalamikro, 'kecil'=>$skalakecil, 'menengah'=>$skalamenengah]);
    }
}
