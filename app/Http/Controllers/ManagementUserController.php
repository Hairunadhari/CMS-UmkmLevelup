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
          $data = DB::table('users')
          ->select('id','name','no_wa','email','email_verified_at','created_at')
          ->orderBy('id','desc')
          ->get();

          foreach ($data as $key) {
            $key->encryptId = Crypt::encrypt($key->id);
          }
          return DataTables::of($data)->make(true);
        }
          return view('management-user');
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
}
