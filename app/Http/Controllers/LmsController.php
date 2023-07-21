<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\PdfToImage\Pdf;

class LmsController extends Controller
{
    public function index() {
        $d['forms'] = DB::table('forms')->whereNull('forms.deleted_at')->get();
        dd($d);
        // return view('import-page', $d);
    }

    public function listKategori() {
        $d['kategori'] = DB::table('m_kategori_materi')->where('aktif', 1)->get();

        return view('list-kategori-page', $d);
    }
    
    public function listMateri() {
        $d['materi'] = DB::table('m_materi')->where('aktif', 1)->get();

        return view('list-materi-page', $d);
    }
    
    public function listPengumuman() {
        $d['pengumuman'] = DB::table('notifikasis')->get();

        return view('list-pengumuman-page', $d);
    }

    public function addKategori(Request $request){
        DB::table('m_kategori_materi')->insert([
            'nama' => $request->nama,
            'created_by' => 1,
            'created_at' => date("Y-m-d")
        ]);
        return redirect('list-kategori-materi');
    }

    public function addMateri(Request $request){
        DB::table('m_materi')->insert([
            'nama' => $request->nama,
            'keterangan' => $request->deskripsi,
            'created_by' => 1,
            'created_at' => date("Y-m-d")
        ]);
        return redirect('list-materi');
    }

    public function subMateri($id, $name) {
        $d['name'] = $name;
        $d['id'] = $id;
        $d['sub_materi'] = DB::table('t_sub_materi')
        ->select('t_sub_materi.*', 't_sub_materi_file.file_location')
        ->leftJoin('t_sub_materi_file', 't_sub_materi.id', '=', 't_sub_materi_file.id_sub_materi')
        ->where('t_sub_materi.aktif', 1)
        ->where('t_sub_materi.id_materi', $id)
        ->get();

        return view('sub-materi', $d);
    }

    public function addSubMateri(Request $request, $id, $name) {
        try {
            DB::beginTransaction();
            $request->validate([
                'file' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            ]);
            // dd($publicUrl);    
            $lastId = DB::table('t_sub_materi')->insertGetId([
                'nama' => $request->title,
                'deskripsi' => $request->deskripsi,
                'id_materi' => $id,
                'created_by' => 1,
                'created_at' => date("Y-m-d")
            ]);

            $file = $request->file('file');
    
            // Generate a hashed filename using the original file name and a unique identifier
            $hashedFileName = Str::random(40) . '.' . $file->getClientOriginalExtension();
    
            // Store the file in the storage/app/public directory
            $filePath = $file->storeAs('data_upload_lms', $hashedFileName, 'public');

            // Create a public URL for the file using the storage link
            $publicUrl = Storage::disk('public')->url($filePath);   
            
            // $pdfFile = $request->file('file');
            // $originalFileName = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
            // $outputFolder = 'public/data_upload_lms'; // Ganti dengan folder tujuan untuk menyimpan gambar JPG

            // $pdf = new Pdf($pdfFile);
            // $pages = $pdf->getNumberOfPages();

            // $arrData = [];
            // for ($pageNumber = 1; $pageNumber <= $pages; $pageNumber++) {
            //     $outputFileName = Str::random(10).'_'.$originalFileName . '_halaman_' . $pageNumber . '.jpg';
            //     $pdf->setPage($pageNumber)->saveImage($outputFolder . '/' . $outputFileName);
            //     $arrData[] = [
            //         'id_sub_materi' => $lastId,
            //         'kategori_materi' => 'jpg',
            //         'file_location' => Storage::disk('public')->url($outputFileName),
            //         'created_by' => 1,
            //         'created_at' => date("Y-m-d")
            //     ];
            // }
            // dd($arrData);

            DB::table('t_sub_materi_file')->insert([
                'id_sub_materi' => $lastId,
                'kategori_materi' => "PDF",
                'video_url' => null,
                'file_location' => $publicUrl,
                'created_by' => 1,
                'created_at' => date("Y-m-d")
            ]);
            
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            //throw $th;
        }

        return redirect('sub-materi/'.$id.'/'.$name);
    }

    public function addPengumuman() {
        // try {
        //     DB::table('form_submissions')
        //     ->insert([
        //         'id_user' => $id_user,
        //         'form_id' => $request->id_form,
        //         'data' => ($arrayData ?? '{}'),
        //         'savedSession' => 0,
        //         'import' => 1,
        //         'created_at' => $date,
        //         'updated_at' => null,
        //     ]);
        // } catch (\Throwable $th) {
            
        // }

        return view('list-pengumuman-page', $d);
    }

    public function deletePengumuman($id) {
        DB::table('notifikasis')->where('id', $id)->update(['final_level' => $level]);

        return view('list-pengumuman-page', $d);
    }

    public function editPengumuman($id) {
        $d['pengumumanById'] = DB::table('notifikasis')->where('id', $id)->first();

        return view('list-pengumuman-page', $d);
    }
}
