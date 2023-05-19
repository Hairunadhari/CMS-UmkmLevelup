<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Redirector;
use Session;
use Illuminate\Database\Query\Builder;

class KuesionerController extends Controller
{

    use AuthenticatesUsers;


    public function __construct(Redirector $redirect)
    {
        if (!$this->guard()->check() == false) {
            $redirect->to('/login')->send();
        }
    }
    
    public function unVerif()
    {
        $d['data'] = DB::table('form_submissions')
          ->leftJoin('users', function($join) {
            $join->on('form_submissions.id_user', '=', 'users.id');
          })
          ->leftJoin('profil_user', function($join) {
            $join->on('form_submissions.id_user', '=', 'profil_user.id_user');
          })
          ->leftJoin('forms', function($join) {
            $join->on('form_submissions.form_id', '=', 'forms.id');
          })
        ->select('form_submissions.*', 'users.name', 'users.final_level', 'profil_user.nama_usaha', 'profil_user.nama_usaha', 'forms.title')
        ->where('users.aktif', 1)
        ->where(function(Builder $query) {
            $query->where('users.final_level', 0)
                  ->orWhereNull('users.final_level');
        })
        ->whereNull('forms.deleted_at')
        ->get();

        if (count($d['data']) > 0) {
            $form_id = $d['data'][0]->form_id;
            $logic = DB::table('m_logic_level')->where('id_form', $form_id)->where('aktif', 1)->get();
        }else{
            $logic = '';
            $level = '';
        }
        
        foreach ($d['data'] as $value) {
            if ($logic != null or $logic != '') {
                $arr_level = [];
                $data_submission = json_decode($value->data, true);
                foreach ($logic as $data_logic) {
                    $arr_logic = json_decode($data_logic->logic, true);
                    $expectedLevel = $data_logic->id_level;
                    foreach ($arr_logic as $formula) {
                        if ($formula['parameter'] == 'false') {
                            if($data_submission[$formula['input_id']] == null || $data_submission[$formula['input_id']] == ''){
                                $arr_level[] = $expectedLevel;
                            }else{}
                        }elseif ($formula['parameter'] == 'true') {
                            if($data_submission[$formula['input_id']] != null || $data_submission[$formula['input_id']] != ''){
                                $arr_level[] = $expectedLevel;
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
                    $level = ''; 
                }
                // dd(in_array([1,2], $arr_level));
            }
            $value->id_level = implode(', ', $arr_level);  
            $value->level = $level;  
        }
        return view('kuesioner-unverif', $d);
    }

    public function verif()
    {
        $d['data'] = DB::table('form_submissions')
          ->leftJoin('users', function($join) {
            $join->on('form_submissions.id_user', '=', 'users.id');
          })
          ->leftJoin('profil_user', function($join) {
            $join->on('form_submissions.id_user', '=', 'profil_user.id_user');
          })
          ->leftJoin('forms', function($join) {
            $join->on('form_submissions.form_id', '=', 'forms.id');
          })
          ->leftJoin('m_level', function($join) {
            $join->on('m_level.id', '=', 'users.final_level');
          })
        ->select('form_submissions.*', 'users.name', 'users.id as id_user', 'users.final_level', 'profil_user.nama_usaha', 'profil_user.nama_usaha', 'forms.title', 'm_level.level')
        ->where('users.aktif', 1)
        ->where('users.final_level', '!=', 0)
        ->whereNull('forms.deleted_at')
        ->get();

        return view('kuesioner-verif', $d);
    }

    public function doVerif(Request $request)
    {
        // dd($request);
        $affected = DB::table('users')
        ->where('id', $request->id_user)
        ->update(['final_level' => $request->level]);

        if ($affected) {
            return redirect('kuesioner-unverif');
        }
    }
}
