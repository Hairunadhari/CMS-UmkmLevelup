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
        ->select('form_submissions.*', 'form_submissions.id as id_submit', 'users.name', 'users.final_level', 'profil_user.nama_usaha', 'profil_user.nama_usaha', 'forms.title')
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

    public function verification($id = null, $name = null)
    {
      if ($id == null) {
        return view('404');
      }
      
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
        ->where(function(Builder $query) {
            $query->where('users.final_level', 0)
                  ->orWhereNull('users.final_level');
        })
        ->whereNull('forms.deleted_at')
        ->first();

        $form = json_decode($d['data']->properties, true);
        $answer = json_decode($d['data']->data, true);
        // dd($answer);
        $d['data']->html = '';
        $initTitle = 0;
        $initTable = 0;
        $len = count($form);
        foreach ($form as $key => $value) {
          if ($value['type'] == 'nf-text'){
            if ($initTitle == 0) {
              $d['data']->html .= '<div class="col-12 mb-2 ml-2"><span style="border-bottom:2px solid #000">'.str_replace("h2>", "h5>", $value['content']).'</span></div>';
              $initTitle = 1;
            }else{
              continue;
            }
          }elseif($value['type'] == 'nf-page-break'){
            if ($initTable == 1) {
              $d['data']->html .= '</table>';
              $initTable = 0;
            }
            $d['data']->html .= '<div class="col-12 mb-4 ml-4" style="border-bottom: 2px solid #999;"></div>';
            $initTitle = 0;
          }else{
            $val = '';
            if (isset($answer[$value['id']])) {
              if (is_array($answer[$value['id']])) {
                if ($value['type'] == 'files') {
                  foreach ($answer[$value['id']] as $ans) {
                    $val .= $ans;
                  }
                }
              }else{

                if ($value['type'] == 'checkbox') {
                  // Checkbox
                 $val = $answer[$value['id']] == true ? '<span class="badge badge-xs badge-success"><i class="fa fa-check"></i></span>' : '<span class="badge badge-xs badge-danger"><i class="fa fa-times"></i></span>';
                }else{
                  // Others
                  $val = $answer[$value['id']];
                }

              }
            }
            if ($initTable == 0) {
              $d['data']->html .= '<table class="table table-bordered mx-4">';
              $initTable = 1;
            }
            $d['data']->html .= '<tr><td style="width:65%; background: #fbfbfb; border: 1px solid #eee !important; font-weight:bold">'.$value['name'].'</td><td style="width:35%;">'.$val.'</td></tr>';
            if ($key == $len -1) {
              $d['data']->html .= '</table>';
            }
          }
        }

        if ($name == null) {
          $d['data']->level = '';
        }else{
          $d['data']->level = base64_decode(urldecode($name));
        }

      return view('verification', $d);
    }

    public function detailData($id = null, $name = null)
    {
      if ($id == null) {
        return view('404');
      }
      
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

        $form = json_decode($d['data']->properties, true);
        $answer = json_decode($d['data']->data, true);
        // dd($answer);
        $d['data']->html = '';
        $initTitle = 0;
        $initTable = 0;
        $len = count($form);
        foreach ($form as $key => $value) {
          if ($value['type'] == 'nf-text'){
            if ($initTitle == 0) {
              $d['data']->html .= '<div class="col-12 mb-2 ml-2"><span style="border-bottom:2px solid #000">'.str_replace("h2>", "h5>", $value['content']).'</span></div>';
              $initTitle = 1;
            }else{
              continue;
            }
          }elseif($value['type'] == 'nf-page-break'){
            if ($initTable == 1) {
              $d['data']->html .= '</table>';
              $initTable = 0;
            }
            $d['data']->html .= '<div class="col-12 mb-4 ml-4" style="border-bottom: 2px solid #999;"></div>';
            $initTitle = 0;
          }else{
            $val = '';
            if (isset($answer[$value['id']])) {
              if (is_array($answer[$value['id']])) {
                // Files
                if ($value['type'] == 'files') {
                  foreach ($answer[$value['id']] as $ans) {
                    $val .= $ans;
                  }
                }
              }else{

                if ($value['type'] == 'checkbox') {
                  // Checkbox
                 $val = $answer[$value['id']] == true ? '<span class="badge badge-xs badge-success"><i class="fa fa-check"></i></span>' : '<span class="badge badge-xs badge-danger"><i class="fa fa-times"></i></span>';
                }else{
                  // Others
                  $val = $answer[$value['id']];
                }

              }
            }


            if ($initTable == 0) {
              $d['data']->html .= '<table class="table table-bordered mx-4">';
              $initTable = 1;
            }
            $d['data']->html .= '<tr><td style="width:65%; background: #fbfbfb; border: 1px solid #eee !important; font-weight:bold">'.$value['name'].'</td><td style="width:35%;">'.$val.'</td></tr>';
            if ($key == $len -1) {
              $d['data']->html .= '</table>';
            }
          }
        }

        if ($name == null) {
          $d['data']->level = '';
        }else{
          $d['data']->level = base64_decode(urldecode($name));
        }

      return view('detail-verif', $d);
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
