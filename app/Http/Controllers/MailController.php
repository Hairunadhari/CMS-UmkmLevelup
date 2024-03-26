<?php

namespace App\Http\Controllers;

use PDF;
use App\Mail\SendPDFtoMail;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
  public function __construct()
  {
     // Lakukan pengecekan apakah pengguna sudah login
     $this->middleware(function ($request, $next) {
      if (session('id_user') == null) {
          // Jika pengguna tidak login, alihkan ke halaman login
          return redirect('/');
      }

      return $next($request);
  });
  }
    public function send($id){
        $data = DB::table('form_submissions')
        ->leftJoin('users','form_submissions.id_user','=','users.id')
        ->select('users.name','users.email')
        ->where('form_submissions.id', $id)
        ->first();

        $d = DB::table('form_submissions')
        ->leftJoin('users', function($join) {
          $join->on('form_submissions.id_user', '=', 'users.id');
        })
        ->leftJoin('profil_user', function($join) {
          $join->on('form_submissions.id_user', '=', 'profil_user.id_user');
        })
        ->leftJoin('forms', function($join) {
          $join->on('form_submissions.form_id', '=', 'forms.id');
        })
        ->leftJoin('m_kecamatan', function($join) {
          $join->on('profil_user.id_kecamatan', '=', 'm_kecamatan.id_kecamatan');
        })
        ->leftJoin('m_kabupaten', function($join) {
          $join->on('profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten');
        })
        ->leftJoin('m_kelurahan', function($join) {
          $join->on('profil_user.id_keluarahan', '=', 'm_kelurahan.id_kelurahan');
        })
      ->select('form_submissions.*',
      'form_submissions.id as id_submit',
      'form_submissions.updated_at',
      'form_submissions.data',
      'users.email_verified_at',
      'users.id as id_user',
      'users.name',
      'users.email',
      'users.final_level',
      'profil_user.nama_usaha',
      'forms.title',
      'forms.properties',
      'm_kelurahan.nama_kelurahan',
      'm_kecamatan.nama_kecamatan',
      'm_kabupaten.nama_kabupaten',
      'profil_user.email_usaha',
      'profil_user.no_telp',
      'profil_user.no_hp',
      'profil_user.jenis_kelamin',
      'profil_user.nik',
      'profil_user.nib',
      'profil_user.alamat_lengkap')
      ->where('form_submissions.id', $id)
      ->whereNull('forms.deleted_at')
      ->first();

      $datax = array(
        'name'=>$data->name,
        'email'=>$data->email,
        'title'=>"From UMKM Level UP"
    );
// dd($datax);
  
        $pdf = PDF::loadView('generate.pdf', compact('d'));
        $pdf->setPaper('a4', 'landscape');
  
        Mail::send('mail.email-sertifikat', $datax, function($message)use($datax, $pdf) {
            $message->to($datax['email'], $datax['email'])
                    ->subject($datax["title"])
                    ->attachData($pdf->output(), "Sertifikat-UMKM-Level-UP.pdf");
        });
    
        
        return back();

    }
 
}
