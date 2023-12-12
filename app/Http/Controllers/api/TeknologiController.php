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
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%instagram.com%'])
            ->select(DB::raw('COUNT(DISTINCT profil_user.id_user) AS total_user'))
            ->first();

        $instagram_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%instagram.com%'])
            ->groupBy('m_provinsi.nama_provinsi')
            ->select('m_provinsi.nama_provinsi', DB::raw('COUNT(DISTINCT users.id) AS total_user'))
            ->get();


        $tiktok = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%tiktok.com%'])
            ->select(DB::raw('COUNT(DISTINCT profil_user.id_user) AS total_user'))
            ->first();

        $tiktok_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%tiktok.com%'])
            ->groupBy('m_provinsi.nama_provinsi')
            ->select('m_provinsi.nama_provinsi', DB::raw('COUNT(DISTINCT users.id) AS total_user'))
            ->get();


        $facebook = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%facebook.com%'])
            ->select(DB::raw('COUNT(DISTINCT profil_user.id_user) AS total_user'))
            ->first();

        $facebook_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%facebook.com%'])
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
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%shopee.com%'])
            ->select(DB::raw('COUNT(DISTINCT profil_user.id_user) AS total_user'))
            ->first();

        $shopee_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%shopee.com%'])
            ->groupBy('m_provinsi.nama_provinsi')
            ->select('m_provinsi.nama_provinsi', DB::raw('COUNT(DISTINCT users.id) AS total_user'))
            ->get();


        $tokopedia = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%tokopedia.com%'])
            ->select(DB::raw('COUNT(DISTINCT profil_user.id_user) AS total_user'))
            ->first();

        $tokopedia_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%tokopedia.com%'])
            ->groupBy('m_provinsi.nama_provinsi')
            ->select('m_provinsi.nama_provinsi', DB::raw('COUNT(DISTINCT users.id) AS total_user'))
            ->get();


        $lazada = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%lazada.com%'])
            ->select(DB::raw('COUNT(DISTINCT profil_user.id_user) AS total_user'))
            ->first();

        $lazada_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%lazada.com%'])
            ->groupBy('m_provinsi.nama_provinsi')
            ->select('m_provinsi.nama_provinsi', DB::raw('COUNT(DISTINCT users.id) AS total_user'))
            ->get();


        $blibli = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%blibli.com%'])
            ->select(DB::raw('COUNT(DISTINCT profil_user.id_user) AS total_user'))
            ->first();

        $blibli_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%blibli.com%'])
            ->groupBy('m_provinsi.nama_provinsi')
            ->select('m_provinsi.nama_provinsi', DB::raw('COUNT(DISTINCT users.id) AS total_user'))
            ->get();


        $bukalapak = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%bukalapak.com%'])
            ->select(DB::raw('COUNT(DISTINCT profil_user.id_user) AS total_user'))
            ->first();

        $bukalapak_per_daerah = DB::table('users')
            ->join('profil_user', 'users.id', '=', 'profil_user.id_user')
            ->join('form_submissions', 'users.id', '=', 'form_submissions.id_user')
            ->join('m_provinsi', 'profil_user.id_provinsi', '=', 'm_provinsi.id_provinsi')
            ->whereRaw("LOWER(form_submissions.data) LIKE ?", ['%bukalapak.com%'])
            ->groupBy('m_provinsi.nama_provinsi')
            ->select('m_provinsi.nama_provinsi', DB::raw('COUNT(DISTINCT users.id) AS total_user'))
            ->get();

        return response()->json(['shopee'=>$shopee, 'shopee_per_daerah'=>$shopee_per_daerah, 'tokopedia'=>$tokopedia, 'tokopedia_per_daerah'=>$tokopedia_per_daerah, 'lazada'=>$lazada, 'lazada_per_daerah'=>$lazada_per_daerah, 'blibli'=>$blibli, 'blibli_per_daerah'=>$blibli_per_daerah, 'bukalapak'=>$bukalapak, 'bukalapak_per_daerah'=>$bukalapak_per_daerah]);
    }
}
