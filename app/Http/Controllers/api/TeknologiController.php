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
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"21f77341-fa46-45d9-bac6-1a04d3cf3764":true%'])
            ->select(DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->first();

        $instagram_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"21f77341-fa46-45d9-bac6-1a04d3cf3764":true%'])
            ->groupBy('m_provinsi.nama_provinsi','m_kabupaten.nama_kabupaten')
            ->select('m_provinsi.nama_provinsi', 'm_kabupaten.nama_kabupaten', DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->get();


        $tiktok = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"f02eebeb-d578-4c39-a383-984e33dceea7":true%'])
            ->select(DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->first();

        $tiktok_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"f02eebeb-d578-4c39-a383-984e33dceea7":true%'])
            ->groupBy('m_provinsi.nama_provinsi','m_kabupaten.nama_kabupaten')
            ->select('m_provinsi.nama_provinsi', 'm_kabupaten.nama_kabupaten', DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->get();


        $facebook = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"8285d9a0-e209-4bf4-a858-21c942efc67d":true%'])
            ->select(DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->first();

        $facebook_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"8285d9a0-e209-4bf4-a858-21c942efc67d":true%'])
            ->groupBy('m_provinsi.nama_provinsi','m_kabupaten.nama_kabupaten')
            ->select('m_provinsi.nama_provinsi', 'm_kabupaten.nama_kabupaten', DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->get();


        $lainnya = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"bc329487-d123-4f53-ac72-e2c343422ff1":true%'])
            ->select(DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->first();

        $lainnya_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"bc329487-d123-4f53-ac72-e2c343422ff1":true%'])
            ->groupBy('m_provinsi.nama_provinsi','m_kabupaten.nama_kabupaten')
            ->select('m_provinsi.nama_provinsi', 'm_kabupaten.nama_kabupaten', DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->get();

        return response()->json(['instagram'=>$instagram, 'instagram_per_daerah'=>$instagram_per_daerah, 'tiktok'=>$tiktok, 'tiktok_per_daerah'=>$tiktok_per_daerah, 'facebook'=>$facebook, 'facebook_per_daerah'=>$facebook_per_daerah, 'lainnya'=>$lainnya, 'lainnya_per_daerah'=>$lainnya_per_daerah]);
    }

    public function marketplace(){
        $shopee = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"7e7d93fe-f890-4912-b5f7-8cec9aeb07f9":true%'])
            ->select(DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->first();

        $shopee_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"7e7d93fe-f890-4912-b5f7-8cec9aeb07f9":true%'])
            ->groupBy('m_provinsi.nama_provinsi','m_kabupaten.nama_kabupaten')
            ->select('m_provinsi.nama_provinsi', 'm_kabupaten.nama_kabupaten', DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->get();


        $tokopedia = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"52747ee5-a58c-4eef-ba80-747b19fd454f":true%'])
            ->select(DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->first();

        $tokopedia_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"52747ee5-a58c-4eef-ba80-747b19fd454f":true%'])
            ->groupBy('m_provinsi.nama_provinsi','m_kabupaten.nama_kabupaten')
            ->select('m_provinsi.nama_provinsi', 'm_kabupaten.nama_kabupaten', DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->get();


        $lazada = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"4899bd76-84fe-4d3b-b026-98369b812b16":true%'])
            ->select(DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->first();

        $lazada_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"4899bd76-84fe-4d3b-b026-98369b812b16":true%'])
            ->groupBy('m_provinsi.nama_provinsi','m_kabupaten.nama_kabupaten')
            ->select('m_provinsi.nama_provinsi', 'm_kabupaten.nama_kabupaten', DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->get();


        $blibli = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"933d946d-6b6d-401f-93ce-796b7d53eefe":true%'])
            ->select(DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->first();

        $blibli_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"933d946d-6b6d-401f-93ce-796b7d53eefe":true%'])
            ->groupBy('m_provinsi.nama_provinsi','m_kabupaten.nama_kabupaten')
            ->select('m_provinsi.nama_provinsi', 'm_kabupaten.nama_kabupaten', DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->get();


        $bukalapak = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"43a9fd21-c843-46ab-873b-32c9e2cf07e9":true%'])
            ->select(DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->first();

        $bukalapak_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"43a9fd21-c843-46ab-873b-32c9e2cf07e9":true%'])
            ->groupBy('m_provinsi.nama_provinsi','m_kabupaten.nama_kabupaten')
            ->select('m_provinsi.nama_provinsi', 'm_kabupaten.nama_kabupaten', DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->get();


        $gofood = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"9fd98221-0e07-4ff7-b30f-348a9bb8fc35":true%'])
            ->select(DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->first();

        $gofood_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"9fd98221-0e07-4ff7-b30f-348a9bb8fc35":true%'])
            ->groupBy('m_provinsi.nama_provinsi','m_kabupaten.nama_kabupaten')
            ->select('m_provinsi.nama_provinsi', 'm_kabupaten.nama_kabupaten', DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->get();


        $shopeefood = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"8acf25cb-2477-462f-8468-6bf514dde2d0":true%'])
            ->select(DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->first();

        $shopeefood_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"8acf25cb-2477-462f-8468-6bf514dde2d0":true%'])
            ->groupBy('m_provinsi.nama_provinsi','m_kabupaten.nama_kabupaten')
            ->select('m_provinsi.nama_provinsi', 'm_kabupaten.nama_kabupaten', DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->get();


        $grabfood = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"d0f5410f-66e2-4a93-ae25-19f1dbd6d401":true%'])
            ->select(DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->first();

        $grabfood_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->join('m_kabupaten', 'profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%"d0f5410f-66e2-4a93-ae25-19f1dbd6d401":true%'])
            ->groupBy('m_provinsi.nama_provinsi','m_kabupaten.nama_kabupaten')
            ->select('m_provinsi.nama_provinsi', 'm_kabupaten.nama_kabupaten', DB::raw('COUNT(profil_user.id_user) AS total_user'))
            ->get();

        return response()->json(['shopee'=>$shopee, 'shopee_per_daerah'=>$shopee_per_daerah, 'tokopedia'=>$tokopedia, 'tokopedia_per_daerah'=>$tokopedia_per_daerah, 'lazada'=>$lazada, 'lazada_per_daerah'=>$lazada_per_daerah, 'blibli'=>$blibli, 'blibli_per_daerah'=>$blibli_per_daerah, 'bukalapak'=>$bukalapak, 'bukalapak_per_daerah'=>$bukalapak_per_daerah, 'gofood'=>$gofood, 'gofood_per_daerah'=>$gofood_per_daerah, 'shopeefood'=>$shopeefood, 'shopeefood_per_daerah'=>$shopeefood_per_daerah, 'grabfood'=>$grabfood, 'grabfood_per_daerah'=>$grabfood_per_daerah]);
    }
}
