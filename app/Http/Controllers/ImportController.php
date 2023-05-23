<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportController extends Controller
{
    public function index()
    {
        return view('import-page');
    }

    public function import(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        if ($extension == 'xlsx' || $extension == 'xls') {
            // Load the Excel file
            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();

            // Iterate over each row
            foreach ($worksheet->getRowIterator() as $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                // Iterate over each cell in the row
                foreach ($cellIterator as $cell) {
                    // Access cell value
                    $value = $cell->getValue();
                    // Process the value as required
                }
            }
            dd($value);
        } else {
            // Invalid file format
            return back()->with('error', 'Invalid file format.');
        }

        return back()->with('success', 'File imported successfully.');
    }
}
