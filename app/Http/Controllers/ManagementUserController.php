<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ManagementUserController extends Controller
{
  
    public function management_user(){
     
        if (request()->ajax()) {
          $id_kab = request('id_kab');
          $id_kec = request('id_kec');
          $id_kel = request('id_kel');
          
          $query = DB::table('users')
          ->select('users.id', 'users.name', 'users.no_wa', 'users.email', 'users.email_verified_at', 'users.created_at','form_submissions.id as idFormSubmission','profil_user.id_kecamatan','profil_user.id_keluarahan','m_kelurahan.nama_kelurahan',
          'm_kecamatan.nama_kecamatan', 
          'm_kabupaten.nama_kabupaten','profil_user.id as profId','users.final_level')
          ->leftJoin('form_submissions','users.id','=','form_submissions.id_user')
          ->leftJoin('profil_user','users.id', '=', 'profil_user.id_user')
          ->leftJoin('m_kecamatan', function($join) {
            $join->on('profil_user.id_kecamatan', '=', 'm_kecamatan.id_kecamatan');
          })
          ->leftJoin('m_kabupaten', function($join) {
            $join->on('profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten');
          })
          ->leftJoin('m_kelurahan', function($join) {
            $join->on('profil_user.id_keluarahan', '=', 'm_kelurahan.id_kelurahan');
          })
          ->where('users.aktif',1);
          if ($id_kab) {
            $query->where('profil_user.id_kabupaten', $id_kab);
          }
          
          if ($id_kec) {
              $query->where('profil_user.id_kecamatan', $id_kec);
          }
          
          if ($id_kel) {
            $query->where('profil_user.id_keluarahan', $id_kel);
          }
          $query->where('users.id','<',11000);
          $data = $query->orderBy('users.created_at', 'desc')->get();
        

          foreach ($data as $key) {
            $key->encryptId = Crypt::encrypt($key->id);
          }
          return DataTables::of($data)->make(true);
        }
        $d['kabupaten'] = DB::table('m_kabupaten')
        ->select('id_kabupaten','nama_kabupaten')
        ->where('aktif',1)
        ->get();
          return view('management-user',$d);
      }

      public function password($encryptId){
        $id = Crypt::decrypt($encryptId);
        $data = DB::table('users')
        ->select('id')
        ->where('id',$id)->first();
        return view('password',compact('data'));
      }

      public function update_password(Request $request, $id)
      {
        $validator = Validator::make($request->all(), [
          'password' => 'required', // Tambahkan validasi untuk logo
          'confirm_password' => 'required|same:password', // Tambahkan validasi untuk logo
        ]);
        if($validator->fails()){
            $messages = $validator->messages();
            $alertMessage = $messages->first();
          
            return back()->with('alert',[
              'title'=>'Ada Kesalahan',
              'text'=>$alertMessage,
              'icon'=>'error'
            ]);
        }
        try {
          DB::beginTransaction();
          DB::table('users')->where('id',$id)->update([
            'password'=>Hash::make($request->password)
          ]);
          DB::commit();
        } catch (\Throwable $th) {
          DB::rollBack();
          //throw $th;
          return back()->with('alert',[
            'title'=>'Ada Kesalahan',
            'text'=>$th->getMessage(),
            'icon'=>'error'
          ]);
        }
        return redirect('/management-user')->with('alert',[
          'title'=>'Notifikasi',
          'text'=>'Password berhasil diupdate.',
          'icon'=>'success'
        ]);
      }

      public function verified_email(Request $request, $encryptId)
      {
        try {
          DB::beginTransaction();
          $id = Crypt::decrypt($encryptId);
          $konvers_tanggal = Carbon::parse(now(),'UTC')->setTimezone('Asia/Jakarta');
          $now = $konvers_tanggal->format('Y-m-d H:i:s');

          DB::table('users')->where('id',$id)->update([
            'email_verified_at'=> $now
          ]);
          DB::commit();
        } catch (\Throwable $th) {
          DB::rollBack();
          //throw $th;
          return back()->with('alert',[
            'title'=>'Ada Kesalahan',
            'text'=>$th->getMessage(),
            'icon'=>'error'
          ]);
        }
        return redirect('/management-user')->with('alert',[
          'title'=>'Notifikasi',
          'text'=>'Email terverifikasi.',
          'icon'=>'success'
        ]);
      }

      public function exportUser(Request $request) {
        $filename = "export_user".date('Y-m-d').".xls";		 
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');
        // dd($filename);
  
        $query = DB::table('users')
        ->select('users.id', 'users.name', 'users.no_wa', 'users.email', 'users.email_verified_at', 'users.created_at','form_submissions.id as idsub','profil_user.id_kecamatan','profil_user.id_keluarahan','m_kelurahan.nama_kelurahan',
        'm_kecamatan.nama_kecamatan','m_kabupaten.nama_kabupaten','users.final_level','users.profil','profil_user.nama_usaha','profil_user.email_usaha','profil_user.nik','profil_user.nib')
        ->leftJoin('form_submissions','users.id','=','form_submissions.id_user')
        ->leftJoin('profil_user','users.id', '=', 'profil_user.id_user')
        ->leftJoin('m_kecamatan', function($join) {
          $join->on('profil_user.id_kecamatan', '=', 'm_kecamatan.id_kecamatan');
        })
        ->leftJoin('m_kabupaten', function($join) {
          $join->on('profil_user.id_kabupaten', '=', 'm_kabupaten.id_kabupaten');
        })
        ->leftJoin('m_kelurahan', function($join) {
          $join->on('profil_user.id_keluarahan', '=', 'm_kelurahan.id_kelurahan');
        })
        ->where('users.aktif',1);
        if ($request->id_kab != null) {
          $query->where('profil_user.id_kabupaten', $request->id_kab);
        }
        
        if ($request->id_kec != null) {
            $query->where('profil_user.id_kecamatan', $request->id_kec);
        }
        
        if ($request->id_kel != null) {
          $query->where('profil_user.id_keluarahan', $request->id_kel);
        }
        $data = $query->get();
  
        // $heading = false;
        $dataHtml = '<table border="1">
        <tr>
          <th class="text-center" scope="col">#</th>
          <th class="text-center" scope="col">Nama Bisnis</th>
          <th class="text-center" scope="col">Email Bisnis</th>
          <th class="text-center" scope="col">Nik</th>
          <th class="text-center" scope="col">Nib</th>
          <th class="text-center" scope="col">Email</th>
          <th class="text-center" scope="col">No Wa</th>
          <th class="text-center" scope="col">Created</th>
          <th class="text-center" scope="col">Email Verified</th>
          <th class="text-center" scope="col">Isi Kuesioner</th>
          <th class="text-center" scope="col">Simpan Sementara</th>
          <th class="text-center" scope="col">Isi Profil</th>
          <th class="text-center" scope="col">Kabupaten</th>
          <th class="text-center" scope="col">Kecamatan</th>
          <th class="text-center" scope="col">Kelurahan</th>
        </tr>';
            if(!empty($data))
            $no = 1;
              foreach($data as $key => $item) {
                $dataHtml .= "<tr>
                    <td>".$no++."</td>
                    <td>".$item->nama_usaha."</td>
                    <td>".$item->email_usaha."</td>
                    <td>".($item->nik == null ? '-' : $item->nik)."</td>
                    <td>".$item->nib."</td>
                    <td>".$item->email."</td>
                    <td>".$item->no_wa."</td>
                    <td>".($item->created_at == null ? '-' : $item->created_at)."</td>
                    <td>".($item->email_verified_at == null ? '-' : $item->email_verified_at)."</td>
                    <td>".($item->idsub == null ? 'belum' : 'sudah')."</td>
                    <td>".($item->final_level == 0 ? 'Tidak' : 'Ya')."</td>
                    <td>".($item->profil == null ? 'belum' : 'sudah')."</td>
                    <td>".$item->nama_kabupaten."</td>
                    <td>".$item->nama_kecamatan."</td>
                    <td>".$item->nama_kelurahan."</td>
                </tr>";
              }
            $dataHtml .= '</table>';
            echo $dataHtml;
      }
}
