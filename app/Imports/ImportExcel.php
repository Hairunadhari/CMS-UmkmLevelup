<?php

namespace App\Imports;

use App\Models\PenerimaSertifikat;
use Illuminate\Support\Collection;
use App\Models\ManagementSertifikat;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportExcel implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $skippedRows = 0; // Menandakan jumlah baris yang sudah dilewati
    
        foreach ($rows as $row) {
            if ($skippedRows < 4) {
                $skippedRows++;
                continue; // Lewati baris-baris pertama
            }
    
            ManagementSertifikat::create([
                'id' => $row[0],
                'nama_fasilitator' => $row[0],
                'nama_usaha' => $row[1],
                'nama_pemilik' => $row[2],
                // Tambahkan kolom lainnya sesuai kebutuhan
            ]);
        }
    }
    
}
