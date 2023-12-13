<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeknologiController extends Controller
{
    public function sosialmedia(){
        $instagram = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"21f77341-fa46-45d9-bac6-1a04d3cf3764":true%'])
            ->select(DB::raw('COUNT(DISTINCT profil_user.id_user) AS total_user'))
            ->first();

        $instagram_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"21f77341-fa46-45d9-bac6-1a04d3cf3764":true%'])
            ->groupBy('m_provinsi.nama_provinsi')
            ->select('m_provinsi.nama_provinsi', DB::raw('COUNT(DISTINCT users.id) AS total_user'))
            ->get();


        $tiktok = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"f02eebeb-d578-4c39-a383-984e33dceea7":true%'])
            ->select(DB::raw('COUNT(DISTINCT profil_user.id_user) AS total_user'))
            ->first();

        $tiktok_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"f02eebeb-d578-4c39-a383-984e33dceea7":true%'])
            ->groupBy('m_provinsi.nama_provinsi')
            ->select('m_provinsi.nama_provinsi', DB::raw('COUNT(DISTINCT users.id) AS total_user'))
            ->get();


        $facebook = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"8285d9a0-e209-4bf4-a858-21c942efc67d":true%'])
            ->select(DB::raw('COUNT(DISTINCT profil_user.id_user) AS total_user'))
            ->first();

        $facebook_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"8285d9a0-e209-4bf4-a858-21c942efc67d":true%'])
            ->groupBy('m_provinsi.nama_provinsi')
            ->select('m_provinsi.nama_provinsi', DB::raw('COUNT(DISTINCT users.id) AS total_user'))
            ->get();


        $twitter = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%twitter.com%'])
            ->select(DB::raw('COUNT(DISTINCT profil_user.id_user) AS total_user'))
            ->first();
    
        $twitter_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%twitter.com%'])
            ->groupBy('m_provinsi.nama_provinsi')
            ->select('m_provinsi.nama_provinsi', DB::raw('COUNT(DISTINCT users.id) AS total_user'))
            ->get();

        return response()->json(['instagram'=>$instagram, 'instagram_per_daerah'=>$instagram_per_daerah, 'tiktok'=>$tiktok, 'tiktok_per_daerah'=>$tiktok_per_daerah, 'facebook'=>$facebook, 'facebook_per_daerah'=>$facebook_per_daerah, 'twitter'=>$twitter, 'twitter_per_daerah'=>$twitter_per_daerah]);
    }

    public function marketplace(){
        $shopee = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"7e7d93fe-f890-4912-b5f7-8cec9aeb07f9":true%'])
            ->select(DB::raw('COUNT(DISTINCT profil_user.id_user) AS total_user'))
            ->first();

        $shopee_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"7e7d93fe-f890-4912-b5f7-8cec9aeb07f9":true%'])
            ->groupBy('m_provinsi.nama_provinsi')
            ->select('m_provinsi.nama_provinsi', DB::raw('COUNT(DISTINCT users.id) AS total_user'))
            ->get();


        $tokopedia = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"52747ee5-a58c-4eef-ba80-747b19fd454f":true%'])
            ->select(DB::raw('COUNT(DISTINCT profil_user.id_user) AS total_user'))
            ->first();

        $tokopedia_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"52747ee5-a58c-4eef-ba80-747b19fd454f":true%'])
            ->groupBy('m_provinsi.nama_provinsi')
            ->select('m_provinsi.nama_provinsi', DB::raw('COUNT(DISTINCT users.id) AS total_user'))
            ->get();


        $lazada = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"4899bd76-84fe-4d3b-b026-98369b812b16":true%'])
            ->select(DB::raw('COUNT(DISTINCT profil_user.id_user) AS total_user'))
            ->first();

        $lazada_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"4899bd76-84fe-4d3b-b026-98369b812b16":true%'])
            ->groupBy('m_provinsi.nama_provinsi')
            ->select('m_provinsi.nama_provinsi', DB::raw('COUNT(DISTINCT users.id) AS total_user'))
            ->get();


        $blibli = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"933d946d-6b6d-401f-93ce-796b7d53eefe":true%'])
            ->select(DB::raw('COUNT(DISTINCT profil_user.id_user) AS total_user'))
            ->first();

        $blibli_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"933d946d-6b6d-401f-93ce-796b7d53eefe":true%'])
            ->groupBy('m_provinsi.nama_provinsi')
            ->select('m_provinsi.nama_provinsi', DB::raw('COUNT(DISTINCT users.id) AS total_user'))
            ->get();


        $bukalapak = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"43a9fd21-c843-46ab-873b-32c9e2cf07e9":true%'])
            ->select(DB::raw('COUNT(DISTINCT profil_user.id_user) AS total_user'))
            ->first();

        $bukalapak_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"43a9fd21-c843-46ab-873b-32c9e2cf07e9":true%'])
            ->groupBy('m_provinsi.nama_provinsi')
            ->select('m_provinsi.nama_provinsi', DB::raw('COUNT(DISTINCT users.id) AS total_user'))
            ->get();

        return response()->json(['shopee'=>$shopee, 'shopee_per_daerah'=>$shopee_per_daerah, 'tokopedia'=>$tokopedia, 'tokopedia_per_daerah'=>$tokopedia_per_daerah, 'lazada'=>$lazada, 'lazada_per_daerah'=>$lazada_per_daerah, 'blibli'=>$blibli, 'blibli_per_daerah'=>$blibli_per_daerah, 'bukalapak'=>$bukalapak, 'bukalapak_per_daerah'=>$bukalapak_per_daerah]);
    }
}
