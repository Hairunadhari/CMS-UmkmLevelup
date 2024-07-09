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
          $date = request('date');
          
          $query = DB::table('users')
          ->select('users.id', 'users.name', 'users.no_wa', 'users.email', 'users.email_verified_at','form_submissions.id as idFormSubmission','m_kelurahan.nama_kelurahan',
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
          if ($id_kab != null) {
            $query->where('profil_user.id_kabupaten', $id_kab);
          }
          
          if ($id_kec != null) {
              $query->where('profil_user.id_kecamatan', $id_kec);
          }
          
          if ($id_kel != null) {
            $query->where('profil_user.id_keluarahan', $id_kel);
          }
          if ($date != null) {
              $query->whereDate('users.created_at', $date);
          }

          // $query->where('users.id','>',9000);
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
        'm_kecamatan.nama_kecamatan','m_kabupaten.nama_kabupaten','users.final_level','users.profil','profil_user.nama_usaha','profil_user.email_usaha','profil_user.nik','profil_user.nib','form_submissions.form_id','form_submissions.data','forms.properties as jsonforms','profil_user.alamat_lengkap','profil_user.jenis_kelamin','profil_user.nama_pemilik')
        ->leftJoin('form_submissions','users.id','=','form_submissions.id_user')
        ->leftJoin('profil_user','users.id', '=', 'profil_user.id_user')
        ->leftJoin('m_kecamatan', function($join) {
          $join->on('profil_user.id_kecamatan', '=', 'm_kecamatan.id_kecamatan');
        })
        ->leftJoin('forms', function($join) {
          $join->on('form_submissions.form_id', '=', 'forms.id');
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
        if ($request->date != null) {
          $query->whereDate('users.created_at', $request->date);
        }
        $data = $query->get();
  
        if (count($data) > 0) {
          $form_id = $data[0]->form_id;
          $logic = DB::table('m_logic_level')->where('id_form', $form_id)->where('aktif', 1)->get();
      }else{
          $logic = '';
          $level = '';
      }
      // dd($data);
      foreach ($data as $value) {
        if ($logic != null or $logic != '') {
              $arr_level = [];
              if ($value->data != null) {
              $data_submission = json_decode($value->data, true);
              foreach ($logic as $data_logic) {
                $arr_logic = json_decode($data_logic->logic, true);
                $expectedLevel = $data_logic->id_level;
                foreach ($arr_logic as $formula) {
                  // dd($data_submission);
                  if ($formula['parameter'] == 'false') {
                    if($data_submission[$formula['input_id']] == null || $data_submission[$formula['input_id']] == ''){
                      $arr_level[] = $expectedLevel;
                    }else{}
                  }elseif ($formula['parameter'] == 'true') {
                      // dd($formula);
                        if($data_submission[$formula['input_id']] != null || $data_submission[$formula['input_id']] != ''){
                          if(array_key_exists("val-param", $formula)){
                            if ($data_submission[$formula['input_id']] == $formula['val-param']) {
                              $arr_level[] = $expectedLevel;
                            }
                          }else{
                            $arr_level[] = $expectedLevel;
                          }
                        }else{}
                    }else{
                    }
                  }
              }
              $arr_level = array_unique($arr_level);
              sort($arr_level);
              if (in_array(1, $arr_level) && in_array(2, $arr_level) && in_array(3, $arr_level) && in_array(4, $arr_level) ) {
                $level = 'Leader';
              }elseif (in_array(1, $arr_level) && in_array(2, $arr_level) && in_array(3, $arr_level)) {
                $level = 'Adopter';
              }
              elseif (in_array(1, $arr_level) && in_array(2, $arr_level)) {
                $level = 'Observer';
              }
              elseif (in_array(1, $arr_level)) {
                $level = 'Beginner';
              }else{
                $level = 'Novice'; 
              }
              $value->id_level = implode(', ', $arr_level);  
              $value->level = $level;  
              $decodeFormid = json_decode($value->jsonforms);  
              $value->formId = $decodeFormid[1]->{"id"};
              $decodeDataSubmissions = json_decode($value->data);
              $value->decodeData = $decodeDataSubmissions;
  
              if ($decodeDataSubmissions->{"cc8e0137-5a07-4873-bc54-77e53c7a0b91"} == true) {
                $value->jenis_usaha = $decodeFormid[2]->{"name"};
              }else if ($decodeDataSubmissions->{"7c991113-f761-40c1-9673-3a9164d46852"} == true) {
                $value->jenis_usaha = $decodeFormid[4]->{"name"};
              }else if ($decodeDataSubmissions->{"0d78540f-14c4-4878-9576-77f2a6e3c532"} == true) {
                $value->jenis_usaha = $decodeFormid[6]->{"name"};
              }
              else if ($decodeDataSubmissions->{"da8ee909-8bff-49d9-9514-361713220b18"} == true) {
                $value->jenis_usaha = $decodeFormid[8]->{"name"};
              }
              else if ($decodeDataSubmissions->{"cec6436e-431e-4f82-a3bb-11a6af141484"} == true) {
                $value->jenis_usaha = $decodeFormid[10]->{"name"};
              }else{
                $value->jenis_usaha = '-';
  
              }
            }else {
              $value->id_level = '-';  
              $value->level = '-';  
              $value->jenis_usaha = '-';  
              # code...
            }
            }
      }

      // dd($data);
      // $heading = false;
        $dataHtml = '<table border="1">
        <tr>
        <th class="text-center" scope="col">#</th>
        <th class="text-center" scope="col">Nama Pemilik</th>
        <th class="text-center" scope="col">Nama Usaha</th>
          <th class="text-center" scope="col">Email Usaha</th>
          <th class="text-center" scope="col">Jenis Usaha</th>
          <th class="text-center" scope="col">Alamat Lengkap</th>
          <th class="text-center" scope="col">Jenis Kelamin</th>
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
          <th class="text-center" scope="col">Id Level</th>
          <th class="text-center" scope="col">Level</th>
        </tr>';
            if(!empty($data))
            $no = 1;
              foreach($data as $key => $item) {
                $dataHtml .= "<tr>
                    <td>".$no++."</td>
                    <td>".$item->nama_pemilik."</td>
                    <td>".$item->nama_usaha."</td>
                    <td>".$item->email_usaha."</td>
                    <td>".$item->jenis_usaha."</td>
                    <td>".$item->alamat_lengkap."</td>
                    <td>".$item->jenis_kelamin."</td>
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
                    <td>".$item->id_level."</td>
                    <td>".$item->level."</td>
                </tr>";
              }
            $dataHtml .= '</table>';
            echo $dataHtml;
      }
}
