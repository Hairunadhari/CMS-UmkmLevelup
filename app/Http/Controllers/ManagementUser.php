<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManagementUser extends Controller
{
    public function management_user(){
        if (request()->ajax()) {
          $data = DB::table('users')
          ->select('users.*')
          ->leftJoin('form_submissions','form_submissions.id_user', '=', 'users.id')
          ->where('users.aktif', 1)
          ->where('form_submissions.id_user', 0)
          ->orWhereNull('form_submissions.id_user')
          ->get();
          return DataTables::of($data)->make(true);
        }
          return view('user');
      }
}
