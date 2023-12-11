<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\M_User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function countuser(){
        $countUser = DB::table('profil_user')->whereNotNull('jenis_kelamin')->count();
        $countPria = DB::table('profil_user')->where('jenis_kelamin','Like', '%pria%')->count();
        $countPerempuan = DB::table('profil_user')->where('jenis_kelamin', 'Like','%perempuan%')->orwhere('jenis_kelamin', 'Like','%wanita%')->count();
        return response()->json(['total_user' => $countUser, 'total_laki-laki' => $countPria, 'total_perempuan' => $countPerempuan]);
    }

    public function skalausaha(){
        $skalaultramikro =  DB::table('form_submissions')
        ->where('data', 'LIKE', '%Ultra Mikro%')
        ->count();


        $skalamikro =  DB::table('form_submissions')
        ->where('data', 'LIKE', '%Mikro%')
        ->where('data', 'NOT LIKE', '%Ultra Mikro%')
        ->count();

        $skalamenengah = DB::table('form_submissions')
        ->where('data', 'LIKE', '%Menengah%')
        ->count();

        $skalabesar = DB::table('form_submissions')
        ->where('data', 'LIKE', '%Besar%')
        ->count();
        return response()->json(['ultra_mikro'=>$skalaultramikro, 'mikro'=>$skalamikro, 'menengah'=>$skalamenengah, 'besar'=>$skalabesar]);
    }

    public function levelumkm(){
        $beginner = User::with('level')->wherehas('level', function($query){
            $query->where('level', 'LIKE', '%Beginner%');
        })->count();

        $observer = User::with('level')->wherehas('level', function($query){
            $query->where('level', 'LIKE', '%Observer%');
        })->count();

        $adopter = User::with('level')->wherehas('level', function($query){
            $query->where('level', 'LIKE', '%Adopter%');
        })->count();

        // 192.168.100.133
        // php artisan serve --host=192.168.100.133 --port=8000

        $leader = User::with('level')->wherehas('level', function($query){
            $query->where('level', 'LIKE', '%Leader%');
        })->count();

        $novice = User::with('level')->wherehas('level', function($query){
            $query->where('level', 'LIKE', '%Novice%');
        })->count();

        return response()->json(['beginner'=>$beginner, 'observer'=>$observer, 'adopter'=>$adopter, 'leader'=>$leader, 'novice'=>$novice]);
    }
}
