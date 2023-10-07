<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AssetImport;

class AssetImportExcelController extends Controller
{
    public function importExcel(Request $request)
    {
        // Validate the request, including checking if 'type' is valid
        $request->validate([
            // 'type' => 'required|in:Dept,Emp', // Adjust the allowed 'type' values as needed
            'file' => 'required|file|mimes:xlsx,csv', // Add more allowed file types if necessary
        ]);

        $type = $request->type;
        $import= new AssetImport($type,20);
        try {
          
            $import->import($request->file('file'));

        } catch (\Exception $e) {
           
            return redirect()->back()->with('error', 'An error occurred during the import: ' . $e->getMessage());
        }
        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }

        return back()->with('success', 'The product list has been successfully imported.');
        
    }
}
