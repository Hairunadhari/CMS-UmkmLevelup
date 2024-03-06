<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use App\Models\Artikel;
use App\Models\Martikel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MateriArtikel;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class ArtikelController extends Controller
{
    public function kategori_artikel(){
        if (request()->ajax()) {
            $data = Artikel::where('status',1)->get();
            foreach ($data as $key ) {
                $key->encryptId = Crypt::encrypt($key->id);
            }
            return DataTables::of($data)->make(true);
        }
        return view('artikel.kategori');
    }

    public function submit(Request $request){
        try {
            DB::beginTransaction();
            Artikel::create([
                'kategori' => $request->kategori
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
        }
        return redirect('/kategori-artikel')->with('success','Data Berhasil DiTambah!');
    }

    public function edit($encryptId){
        $id = Crypt::decrypt($encryptId);
        $data = Artikel::find($id);
        return view('artikel.edit-kategori',compact('data'));
    }

    public function update(Request $request, $id){
        try {
            DB::beginTransaction();
            $data = Artikel::find($id);
            $data->update([
                'kategori'=>$request->kategori
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            dd($th);
        }
        return redirect('/kategori-artikel')->with('success','Data Berhasil DiUpdate!');
    }

    public function delete($encryptId){
        try {
            DB::beginTransaction();
            $id = Crypt::decrypt($encryptId);
            $data = Artikel::find($id);
            $data->update([
                'status'=>0
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            dd($th);
        }
        return redirect('/kategori-artikel')->with('success','Data Berhasil DiHapus!');
    }

    public function materi_artikel(){
        $kategori = Artikel::where('status',1)->get();
        if (request()->ajax()) {
            $data = MateriArtikel::where('status',1)->get();
            foreach ($data as $key ) {
                $key->encryptId = Crypt::encrypt($key->id);
            }
            return DataTables::of($data)->make(true);
        }
        return view('artikel.materi-artikel',compact('kategori'));
    }

    public function submit_materi(Request $request){
        $validator = Validator::make($request->all(), [
            'gambar' => 'max:5000', // Tambahkan validasi untuk logo
        ],
        [
            'gambar'=>'Maksimal Ukuran Gambar Artikel 2mb ',
        ]
        );
        if($validator->fails()){
            $messages = $validator->messages();
            $alertMessage = $messages->first();
          
            session()->flash('judul', $request->judul);
            session()->flash('deskripsi', $request->deskripsi);
            session()->flash('start', $request->start);
            session()->flash('end', $request->end);
            session()->flash('lokasi', $request->lokasi);

            return back()->with('alert',[
                'title' =>'Ada Kesalahan',
                'text' => $alertMessage,
                'icon' =>'error',
            ]);
        }

        try {
            DB::beginTransaction();
            $gambar = Str::random(3).time().'.'.$request->gambar->getClientOriginalExtension();
            $request->file('gambar')->move('storage/image_artikels/', $gambar);
            
            $materiArtikel = MateriArtikel::create([
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'start' => $request->start,
                'end' => $request->end,
                'lokasi' => $request->lokasi,
                'gambar' => env('APP_URL').'/storage/image_artikels/'.$gambar,
            ]);

            foreach ($request->kategori as $key) {
                Martikel::create([
                    'artikel_id' => $key,
                    'materi_artikel_id' => $materiArtikel->id,
                ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
        }
        return redirect('/materi-artikel')->with('alert',[
            'title'=>'Notifikasi!',
            'text'=>'Data Berhasil DiTambah!',
            'icon'=>'success',
        ]);
    }

    public function edit_materi($encryptId){
        $id = Crypt::decrypt($encryptId);
        $data = MateriArtikel::find($id);
        $kategori = Artikel::where('status',1)->get();
        $kategoriTerpilih = Martikel::where('status',1)->where('materi_artikel_id',$id)->get();
        
        return view('artikel.edit-materi',compact('data','kategori','kategoriTerpilih'));
    }

    public function update_materi(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'gambar' => 'max:5000', // Tambahkan validasi untuk logo
        ],
        [
            'gambar'=>'Maksimal Ukuran Gambar Artikel 2mb ',
        ]
        );
        if($validator->fails()){
            $messages = $validator->messages();
            $alertMessage = $messages->first();
          
            

            return back()->with('alert',[
                'title' =>'Ada Kesalahan',
                'text' => $alertMessage,
                'icon' =>'error',
            ]);
        }
        try {
            DB::beginTransaction();
            $data = MateriArtikel::find($id);
            $kategoriTerpilih = Martikel::where('status',1)->where('materi_artikel_id',$id)->get();

            if ($request->hasFile('gambar')) {
                $gambar = Str::random(3).time().'.'.$request->gambar->getClientOriginalExtension();
                $request->file('gambar')->move('storage/image_artikels/', $gambar);
                $data->update([
                    'judul' => $request->judul,
                    'deskripsi' => $request->deskripsi,
                    'start' => $request->start,
                    'end' => $request->end,
                    'lokasi' => $request->lokasi,
                    'gambar' => env('APP_URL').'/storage/image_artikels/'.$gambar,
                ]);
            }else{
                $data->update([
                    'judul' => $request->judul,
                    'deskripsi' => $request->deskripsi,
                    'start' => $request->start,
                    'end' => $request->end,
                    'lokasi' => $request->lokasi,
                ]);

            }
            $kategoriTerpilih->each->update([
                'status'=>0
            ]);
            foreach ($request->kategori as $key) {
                Martikel::create([
                    'artikel_id' => $key,
                    'materi_artikel_id' => $id,
                ]);
            }
            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            dd($th);
        }
        return redirect('/materi-artikel')->with('success','Data Berhasil DiUpdate!');
    }

    public function materi_delete($encryptId){
        try {
            DB::beginTransaction();
            $id = Crypt::decrypt($encryptId);
            $data = MateriArtikel::find($id);
            $data->update([
                'status'=>0
            ]);
            $martikel = Martikel::where('status',1)->where('materi_artikel_id',$id)->get();
            $martikel->each->update([
                'status'=>0
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            dd($th);
        }
        return redirect('/materi-artikel')->with('success','Data Berhasil DiHapus!');
    }

  
}
