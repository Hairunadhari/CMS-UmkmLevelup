<?php

namespace App\Imports;

use Throwable;
use App\Models\PenerimaSertifikat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\ManagementSertifikat;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportExcel implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        try {
            DB::beginTransaction();
            DB::commit();
            $skippedRows = 0; // Menandakan jumlah baris yang sudah dilewati
            
            foreach ($rows as $row) {
            if ($skippedRows < 1) {
                $skippedRows++;
                continue; // Lewati baris-baris pertama
            }
            ManagementSertifikat::create([
                'nama_fasilitator' => $row[0],
                'nama_usaha' => $row[1],
                'nama_pemilik' => $row[2],
                // Tambahkan kolom lainnya sesuai kebutuhan
            ]);
        }
        } catch (Throwable $th) {
            DB::rollback();
            return back();
        }
    }
    
}
