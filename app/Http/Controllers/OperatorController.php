<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\OperatorImport;
use Illuminate\Support\Facades\Validator;
class OperatorController extends Controller
{
    public function importExcelOperator(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,csv', // Add more allowed file types if necessary
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $import = new OperatorImport(100);

        try {
            $import->import($request->file('file'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred during the import: ' . $e->getMessage());
        }

        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }

        return back()->with('success', 'The operator (sim) list has been successfully imported.');
    }
}
