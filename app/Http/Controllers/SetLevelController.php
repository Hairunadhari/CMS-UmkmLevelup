<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Routing\Redirector;
use Session;


class SetLevelController extends Controller
{
    use AuthenticatesUsers;


    public function __construct(Redirector $redirect)
    {
        // if (!$this->guard()->check() == false) {
        //     $redirect->to('/login')->send();
        // }
    }

    public function index()
    {
        $d['data'] = DB::table('m_logic_level')->leftJoin('m_level', function($join) {
            $join->on('m_logic_level.id_level', '=', 'm_level.id');
          })
        ->select('m_logic_level.*', 'm_level.level')
        ->where('m_logic_level.aktif', 1)
        ->where('m_level.aktif', 1)
        ->get();
        // dd($d);
        return view('set-level', $d);
    }

    public function addLevel(Request $request){
        DB::table('m_logic_level')->insert([
            'name' => $request->nama,
            'id_level' => $request->level,
            'id_form' => 6,
            'logic' => '[]',
            'created_at' => date("Y-m-d")
        ]);
        return redirect('set-level');
    }

    public function setLogic($id)
    {
        $d['data'] = DB::table('m_logic_level')->where('id', $id)->where('aktif', 1)->first();
        $d['data_form'] = DB::table('forms')->where('id', $d['data']->id_form)->first();
        $d['data_json'] = json_decode($d['data_form']->properties, true);
        $d['data_logic'] = json_decode($d['data']->logic, true);
        
        return view('set-logic', $d);
    }

    public function addLogic(request $request){
        // dd($request);
        $logic = json_decode(DB::table('m_logic_level')->where('id', $request->id)->first()->logic, true);
        $count = count($logic);
        $data_json = json_decode($request->forms, true);
        $key = array_search($request->input, array_column($data_json, 'id'));
        $logic[$count]['input_id'] = $request->input;
        $logic[$count]['name'] = $data_json[$key]['name'].' ['.$data_json[$key]['type'].']';
        $logic[$count]['parameter'] = $request->parameter;
        if($request->valueParam != ''){
            $logic[$count]['val-param'] = $request->valueParam;
        }

        $logic = json_encode($logic);

        DB::table('m_logic_level')->where('id', $request->id)
        ->update([
            'logic' => $logic
         ]);
        return redirect('set-logic/'.$request->id);
    }

    public function deleteLevel($id = null)
    {
        // dd($id);
        if ($id == null) {
            return view('404');
        }

        DB::table('m_logic_level')->where('id', $id)
        ->update([
            'aktif' => 0,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect('set-level');
    }

    public function deleteLogic($id = null, $key = null)
    {
        if ($id == null or $key == null) {
            return view('404');
        }

        $data_logic = DB::table('m_logic_level')->where('id', $id)->first();
        $logic = json_decode($data_logic->logic, true);
        unset($logic[$key]);

        $logic = json_encode($logic);

        DB::table('m_logic_level')->where('id', $id)
        ->update([
            'logic' => $logic,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect('set-logic/'.$id);
    }
}
