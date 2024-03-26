<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Throwable;
use Validator;
// use Barryvdh\DomPDF\PDF;
use App\Models\User;
// use Spatie\PdfToImage\Pdf;
use App\Models\MateriChat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UserProgresMateri;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class LmsController extends Controller
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
    });}
    
    public function index() {
        $d['forms'] = DB::table('forms')->whereNull('forms.deleted_at')->get();
        // return view('import-page', $d);
    }

    public function listKategori() {
        $d['kategori'] = DB::table('m_kategori_materi')->where('aktif', 1)->orWhere('aktif', 2)->get();
        
        return view('list-kategori-page', $d);
    }
    
    public function listMateri() {
        if (session('id_role') == 2 or session('id_role') == 3) {
            $d['materi'] = DB::table('m_materi')->where('aktif', 1)->orWhere('aktif', 2)->get();
        }else{
            $d['materi'] = DB::table('m_materi')->where('created_by', session('id_user'))->where('aktif', 1)->orWhere('aktif', 2)->get();
        }

        return view('list-materi-page', $d);
    }

    public function approve($id){
        DB::table('m_materi')->where('id', $id)->update(['aktif' => 1]);
        return redirect('/list-materi')->with(['success' => 'Materi Berhasil DiPublish']);
    }
    
    public function listPengumuman() {
        $d['pengumuman'] = DB::table('notifikasis')->get();

        return view('list-pengumuman-page', $d);
    }

    public function addKategori(Request $request){
        if ($request->session()->get('id_user') == null) {
            $request->session()->flash('alert', [
                'type' => 'error',
                'message' => 'Silahkan periksa kembali email password anda.',
            ]);
            return redirect('login');
        }
        DB::table('m_kategori_materi')->insert([
            'nama' => $request->nama,
            'created_by' => $request->session()->get('id_user'),
            'created_at' => date("Y-m-d")
        ]);
        return redirect('list-kategori-materi');
    }

    public function addMateri(Request $request){
        if ($request->session()->get('id_user') == null) {
            $request->session()->flash('alert', [
                'type' => 'error',
                'message' => 'Silahkan periksa kembali email password anda.',
            ]);
            return redirect('login');
        }

        DB::table('m_materi')->insert([
            'nama' => $request->nama,
            'keterangan' => $request->deskripsi,
            'created_by' => $request->session()->get('id_user'),
            'created_at' => date("Y-m-d")
        ]);
        return redirect('list-materi');
    }

    public function subMateri($name, $id) {
        $d['name'] = $name;
        $d['id'] = $id;
        $d['sub_materi'] = DB::table('t_sub_materi')
        ->select('t_sub_materi.*')
        ->where('t_sub_materi.aktif', 1)
        ->where('t_sub_materi.id_materi', $id)
        ->get();
        return view('sub-materi', $d);
    }
    
    public function addSubMateri(Request $request, $id, $name) {
        // dd($request);
        if ($request->session()->get('id_user') == null) {
            $request->session()->flash('alert', [
                'type' => 'error',
                'message' => 'Silahkan periksa kembali email password anda!',
            ]);
            return redirect('login');
        }
        $validator = Validator::make($request->all(), [
            'video' => 'max:100000', // Tambahkan validasi untuk logo
            'file' => 'max:500000', // Tambahkan validasi untuk logo
        ],
        [
            'video'=>'Maksimal Ukuran Video 100 mb',
            'file'=>'Maksimal Ukuran File PDF  50 mb'
        ]
        );
        if($validator->fails()){
            $messages = $validator->messages();
            $alertMessage = $messages->first();
          
            return response()->json($alertMessage);
        }

        try {
            DB::beginTransaction();

            $lastId = DB::table('t_sub_materi')->insertGetId([
                'nama' => $request->title,
                'deskripsi' => $request->deskripsi,
                'id_materi' => $id,
                'created_by' => $request->session()->get('id_user'),
                'created_at' => date("Y-m-d")
            ]);
            if ($request->hasFile('file') && $request->hasFile('video') ) {
                $file = Str::random(3).time().'.'.$request->file->getClientOriginalExtension();
                $request->file('file')->move('storage/data_upload_lms/', $file);
                $video = Str::random(3).time().'.'.$request->video->getClientOriginalExtension();
                $request->file('video')->move('storage/data_upload_lms/', $video);

                DB::table('t_sub_materi_file')->insert([
                    'id_sub_materi' => $lastId,
                    'video_url' => env('APP_URL').'/storage/data_upload_lms/'.$video,
                    'file_location' => env('APP_URL').'/storage/data_upload_lms/'.$file,
                    'file_name' => $file,
                    'video_name' => $video,
                    'created_by' => $request->session()->get('id_user'),
                    'created_at' => date("Y-m-d")
                ]);

            }elseif ($request->link_video && $request->hasFile('file')) {
                $file = Str::random(3).time().'.'.$request->file->getClientOriginalExtension();
                $request->file('file')->move('storage/data_upload_lms/', $file);
                DB::table('t_sub_materi_file')->insert([
                    'id_sub_materi' => $lastId,
                    'video_url' => $request->link_video,
                    'file_location' => env('APP_URL').'/storage/data_upload_lms/'.$file,
                    'file_name' => $file,
                    'created_by' => $request->session()->get('id_user'),
                    'created_at' => date("Y-m-d")
                ]);
            }elseif ($request->hasFile('file')) {
                $file = Str::random(3).time().'.'.$request->file->getClientOriginalExtension();
                $request->file('file')->move('storage/data_upload_lms/', $file);
                DB::table('t_sub_materi_file')->insert([
                    'id_sub_materi' => $lastId,
                    'file_location' => env('APP_URL').'/storage/data_upload_lms/'.$file,
                    'file_name' => $file,
                    'created_by' => $request->session()->get('id_user'),
                    'created_at' => date("Y-m-d")
                ]);
            }elseif ($request->hasFile('video')) {
                $video = Str::random(3).time().'.'.$request->video->getClientOriginalExtension();
                $request->file('video')->move('storage/data_upload_lms/', $video);
                DB::table('t_sub_materi_file')->insert([
                    'id_sub_materi' => $lastId,
                    'video_url' => env('APP_URL').'/storage/data_upload_lms/'.$video,
                    'video_name' => $video,
                    'created_by' => $request->session()->get('id_user'),
                    'created_at' => date("Y-m-d")
                ]);
            }elseif ($request->link_video){
                DB::table('t_sub_materi_file')->insert([
                    'id_sub_materi' => $lastId,
                    'video_url' => $request->link_video,
                    'created_by' => $request->session()->get('id_user'),
                    'created_at' => date("Y-m-d")
                ]);
            } else{
                DB::table('t_sub_materi_file')->insert([
                    'id_sub_materi' => $lastId,
                    'created_by' => $request->session()->get('id_user'),
                    'created_at' => date("Y-m-d")
                ]);
            }


          
            
            DB::commit();
        } catch (Throwable $th) {
            DB::rollback();
            // dd($th);
            return redirect()->back()->with(['error' => 'Data Gagal Ditambahkan! '.$th]);
            // throw $th;
        }

        // return redirect($name.'/sub-materi/'.$id)->with(['success' => 'Data Berhasil Ditambahkan!']);
        return response()->json([
            'success'=>'Data Berhasil DiUpload!',
            'name'=>$name,
            'id'=>$id
        ]);
    }

    public function addPengumuman(Request $request) {
        DB::table('notifikasis')->insert([
            'judul_notifikasi' => $request->judul_notifikasi,
            'keterangan' => $request->keterangan,
            'created_by' => $request->session()->get('id_user'),
            'tanggal' => date("Y-m-d")
        ]);
        return redirect('/list-pengumuman');
    }

    public function deletePengumuman($id) {
        DB::table('notifikasis')->where('id', $id)->update(['status_aktif' => 0]);
        return redirect('/list-pengumuman');
    }

    public function editPengumuman($id) {
        $d['pengumumanById'] = DB::table('notifikasis')->where('id', $id)->first();
        return view('edit-pengumuman', $d);
    }

    public function updatePengumuman(Request $request, $id) {
        $d['pengumumanById'] = DB::table('notifikasis')->where('id', $id)->update([
            'judul_notifikasi' =>$request->judul_notifikasi,
            'keterangan' =>$request->keterangan,
        ]);
        return redirect('list-pengumuman');
    }

    public function user_progres(){
        
        // dd($data);
    //     $data = DB::table('user_progres_materis')
    //     ->select(
    //         'user_progres_materis.materi_id', 
    //         'm_materi.nama', 
    //         'users.name', 
    //         'users.id', 
    //         DB::raw('COUNT(user_progres_materis.id) as jumlah_user'),
    //         DB::raw('COUNT(user_progres_materis.sub_materi_id) as jumlah_sub_materi_user'))
    //         ->leftJoin('users','user_progres_materis.user_id','=','users.id')
    //         ->leftJoin('m_materi','user_progres_materis.materi_id','=','m_materi.id')
    //         ->groupBy('user_progres_materis.materi_id', 'm_materi.nama', 'users.name','users.id')
    //         ->get();
    // $data = DB::table('user_progres_materis')
    // ->select(
    //     'user_progres_materis.materi_id', 
    //     'm_materi.nama', 
    //     'users.name', 
    //     'users.id', 
    //     DB::raw('COUNT(user_progres_materis.id) as jumlah_user'),
    //     DB::raw('COUNT(user_progres_materis.sub_materi_id) as jumlah_sub_materi_user'))
    //     ->leftJoin('users','user_progres_materis.user_id','=','users.id')
    //     ->leftJoin('m_materi','user_progres_materis.materi_id','=','m_materi.id')
    //     ->groupBy('user_progres_materis.materi_id', 'm_materi.nama', 'users.name','users.id')
    //     ->where('status',1)
    //     ->get();
    //    dd($data);
        if (request()->ajax()) {
            $data = DB::table('user_progres_materis')
            ->select(
                'user_progres_materis.materi_id', 
                'm_materi.nama', 
                'users.name', 
                'users.id', 
                DB::raw('COUNT(user_progres_materis.id) as jumlah_user'),
                DB::raw('COUNT(user_progres_materis.sub_materi_id) as jumlah_sub_materi_user'))
                ->leftJoin('users','user_progres_materis.user_id','=','users.id')
                ->leftJoin('m_materi','user_progres_materis.materi_id','=','m_materi.id')
                ->groupBy('user_progres_materis.materi_id', 'm_materi.nama', 'users.name','users.id')
                ->where('status',1)
                ->get();
            return DataTables::of($data)->make(true);
        }
        
        return view('user-progres');
    }
    public function detail_user_progres($id, $materiid){
        // dd($id,$materiid);
        $user = User::find($id);
        $materi = DB::table('m_materi')
        ->select('nama')
        ->find($materiid);
        // dd($materi);
        $all_sub_materi = DB::table('t_sub_materi')
        ->select('t_sub_materi.id','t_sub_materi.nama','t_sub_materi_file.video_url')
        ->leftJoin('t_sub_materi_file','t_sub_materi.id','=','t_sub_materi_file.id_sub_materi')
        ->where('id_materi',$materiid)
        ->where('t_sub_materi.aktif',1)
        ->where('t_sub_materi_file.aktif',1)
        ->get();

        $materi_progres_user = DB::table('user_progres_materis')
        ->select('user_progres_materis.*','t_sub_materi.nama')
        ->leftJoin('t_sub_materi','user_progres_materis.sub_materi_id','=','t_sub_materi.id')
        ->where('user_id',$id)
        ->where('materi_id',$materiid)
        ->get();
        $sub_materi_yg_dikerjain = [];
        foreach ($materi_progres_user as $item) {
            $sub_materi_yg_dikerjain[$item->sub_materi_id] = $item->progres;
        }
        // dd($all_sub_materi);

        return view('detail-user-progres',compact('user','materi','all_sub_materi','sub_materi_yg_dikerjain'));
    }
    public function detail_sub_materi($id){
        $a = DB::table('t_sub_materi')
        ->select('t_sub_materi.*','m_materi.nama as nama_materi')
        ->leftJoin('m_materi','t_sub_materi.id_materi','=','m_materi.id')
        ->where('t_sub_materi.id',$id)
        ->first();
        // dd($a);
        $data = DB::table('t_sub_materi_file')
        ->where('id_sub_materi',$id)
        ->first();
        return view('detail-sub-materi',compact('data','a'));
    }
    public function edit_sub_materi($id){
        $a = DB::table('t_sub_materi')
        ->select('t_sub_materi.*','m_materi.nama as nama_materi')
        ->leftJoin('m_materi','t_sub_materi.id_materi','=','m_materi.id')
        ->where('t_sub_materi.id',$id)
        ->first();
        $data = DB::table('t_sub_materi_file')
        ->where('id_sub_materi',$id)
        ->first();
        // dd($a);
        return view('edit-sub-materi',compact('data','a'));
    }
    public function update_sub_materi(Request $request, $id){
        try {
            DB::beginTransaction();
            $sub_materi = DB::table('t_sub_materi')->find($id);
            $materi = DB::table('m_materi')->find($sub_materi->id_materi);
            $sub_materi_file = DB::table('t_sub_materi_file')->where('id_sub_materi',$id)->first();
            
            if($request->hasFile('file') && $request->hasFile('video') ) {
                $file = Str::random(3).time().'.'.$request->file->getClientOriginalExtension();
                $request->file('file')->move('storage/data_upload_lms/', $file);
                
                $video = Str::random(3).time().'.'.$request->video->getClientOriginalExtension();
                $request->file('video')->move('storage/data_upload_lms/', $video);
                
                DB::table('t_sub_materi_file')->where('id_sub_materi',$id)->update([
                    'video_url' => env('APP_URL').'/storage/data_upload_lms/'.$video,
                    'file_location' => env('APP_URL').'/storage/data_upload_lms/'.$file,
                    'file_name' => $file,
                    'video_name' => $video,
                    'created_by' => $request->session()->get('id_user'),
                    'created_at' => date("Y-m-d")
                ]);
            }elseif ($request->hasFile('file') && $request->link_video ) {
                $file = Str::random(3).time().'.'.$request->file->getClientOriginalExtension();
                $request->file('file')->move('storage/data_upload_lms/', $file);
                
                DB::table('t_sub_materi_file')->where('id_sub_materi',$id)->update([
                    'video_url' => $request->link_video,
                    'file_location' => env('APP_URL').'/storage/data_upload_lms/'.$file,
                    'file_name' => $file,
                    'created_by' => $request->session()->get('id_user'),
                    'created_at' => date("Y-m-d")
                ]);
            }elseif ($request->hasFile('file')) {
                    $file = Str::random(3).time().'.'.$request->file->getClientOriginalExtension();
                    $request->file('file')->move('storage/data_upload_lms/', $file);
                    DB::table('t_sub_materi_file')->where('id_sub_materi',$id)->update([
                        'file_location' => env('APP_URL').'/storage/data_upload_lms/'.$file,
                        'file_name' => $file,
                        'created_by' => $request->session()->get('id_user'),
                        'created_at' => date("Y-m-d")
                    ]);
            }elseif ($request->hasFile('video')) {
                $video = Str::random(3).time().'.'.$request->video->getClientOriginalExtension();
                $request->file('video')->move('storage/data_upload_lms/', $video);
                    DB::table('t_sub_materi_file')->where('id_sub_materi',$id)->update([
                        'video_url' => env('APP_URL').'/storage/data_upload_lms/'.$video,
                        'video_name' => $video,
                        'created_by' => $request->session()->get('id_user'),
                        'created_at' => date("Y-m-d")
                    ]);
            }elseif ($request->link_video) {
                    DB::table('t_sub_materi_file')->where('id_sub_materi',$id)->update([
                        'video_url' => $request->link_video,
                        'created_by' => $request->session()->get('id_user'),
                        'created_at' => date("Y-m-d")
                    ]);
            }

            
            DB::table('t_sub_materi')->where('id',$id)->update([
                'nama' => $request->title,
                'deskripsi' => $request->deskripsi,
            ]);
            DB::commit();
        } catch (Throwable $th) {
            DB::rollback();
            //throw $th;
            dd($th);
        }
        // dd($sub_materi);
        // return redirect('/list-materi')->with(['success'=>'Data Berhasil Diedit!']);
            return response()->json([
                'success'=>'Data Berhasil DiUpdate!',
                'name'=>$materi->nama,
                'id'=>$materi->id
            ]);

    }

    public function deleteSubmateri($id){
        try {
            DB::beginTransaction();
            DB::table('t_sub_materi')->where('id',$id)->update([
                'aktif'=>0
            ]);
            DB::table('t_sub_materi_file')->where('id_sub_materi',$id)->update([
                'aktif'=>0
            ]);
            DB::table('user_progres_materis')->where('sub_materi_id',$id)->update([
                'status'=>0
            ]);
            $sub = DB::table('t_sub_materi')->find($id);
            $data = DB::table('m_materi')->find($sub->id_materi);
            DB::commit();
        } catch (Throwable $th) {
            DB::rollback();
            //throw $th;
            // dd($th);
            return redirect()->back()->with(['error'=>'Data Gagal DiHapus!, '.$th]);
        }

        return redirect('/'.$data->nama.'/sub-materi/'.$data->id)->with(['success'=>'Data Berhasil DiHapus!']);

    }
    public function get_file_by_name(Request $request){
        dd($request->filename);
        $file = 'http://127.0.0.1:8000/storage/data_upload_lms/'. $request->filename;
        return response()->json(['file' => $file]);
    }

    public function materi_chatting(){
        if (request()->ajax()) {
            if (session('id_role') == 2 or session('id_role') == 3) {
                $data = DB::table('m_materi')->where('aktif', 1)->orWhere('aktif', 2)->get();
            }else{
                $data = DB::table('m_materi')->where('created_by', session('id_user'))->where('aktif', 1)->orWhere('aktif', 2)->get();
            }
           
            return DataTables::of($data)->make(true);
        }
        return view('materi-chatting');
    }

    public function materi_chatting_by_id($id, $nama){
        if (request()->ajax()) {
            $data = DB::table('t_sub_materi')
            ->select('t_sub_materi.*')
            ->where('t_sub_materi.aktif', 1)
            ->where('t_sub_materi.id_materi', $id)
            ->get();
           
            return DataTables::of($data)->make(true);
        }
        return view('sub-materi-chatting',compact('nama'));
    }

    public function sub_materi_chatting_by_id($id){
        $name = DB::table('t_sub_materi')
        ->select('t_sub_materi.*','m_materi.nama as nama_materi')
        ->leftJoin('m_materi','t_sub_materi.id_materi','=','m_materi.id')
        ->where('t_sub_materi.id',$id)
        ->first();
        
        $chats = DB::table('materi_chats')
        ->select('materi_chats.*','users.name','users.id')
        ->leftJoin('users','materi_chats.user_id','=','users.id')
        ->where('materi_chats.sub_materi_id',$id)
        ->get();

        return view('chatting',compact('id','chats','name'));
    }

    public function send_chatting(Request $request){
        $now = now()->setTimezone('Asia/Jakarta');

        MateriChat::create([
            'user_id' => $request->id_user,
            'sub_materi_id' => $request->sub_materi_id,
            'chat' => $request->chat,
            'tanggal' => $now,
        ]);
        return response()->json(['message'=>'success']);
    }

    public function downloadPdf($id){
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
        // dd($d);
        $pdf = PDF::loadView('generate.pdf',compact('d'));
        $pdf->setPaper('a4', 'landscape');

        // tanpa keunduh
        // return $pdf->stream('disney.pdf', [
        //     'Attachment' => false,
        // ]);

        // diunduh
        return $pdf->download('Sertifikat-UMKM-Level-UP.pdf');
    }

  
    public function delete_materi($id){
        try {
            DB::beginTransaction();
            $m = DB::table('m_materi')
            ->select('id')
            ->where('id',$id)
            ->update([
                'aktif'=>0
            ]);
            
            DB::table('t_sub_materi')
            ->select('id','id_materi')
            ->where('id_materi',$id)
            ->update([
                'aktif'=>0
            ]);

             $sub = DB::table('t_sub_materi')
            ->select('id','id_materi')
            ->where('id_materi',$id)
            ->get();

            $subIds = $sub->pluck('id')->toArray();
            
            $subfile = DB::table('t_sub_materi_file')
            ->select('id_sub_materi_file','id_sub_materi')
            ->whereIn('id_sub_materi',$subIds)
            ->update([
                'aktif'=>0
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            //throw $th;
        }

        return redirect('list-materi')->with('alert',[
            'title'=>'Notifikasi!',
            'text'=>'Data Berhasil DiHapus!',
            'icon'=>'success',
        ]);

        
    }
}
