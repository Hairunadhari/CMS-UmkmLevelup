<?php

namespace App\Imports;

use App\Models\PenerimaSertifikat;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportExcel implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $isFirstRow = true; // Menandakan apakah ini adalah baris pertama (header)

        foreach ($rows as $row) {
            if ($isFirstRow) {
                $isFirstRow = false;
                continue; // Lewati baris header
            }

            PenerimaSertifikat::create([
                'nama_fasilitator' => $row[0],
                'nama_usaha' => $row[1],
                'nama_pemilik' => $row[2],
                // Tambahkan kolom lainnya sesuai kebutuhan
            ]);
        }
    }
}
