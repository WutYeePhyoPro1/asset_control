<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\NonAssetOperator;
use Maatwebsite\Excel\Facades\Excel;
class NonAssetImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx',
        ]);

        $file = $request->file('file');

        try {
            Excel::import(new NonAssetOperator, $file);
        } catch (SheetNotFoundException $exception) {
            return redirect('laptop_asset_code.nonasset_operator')->with('error', 'Invalid file format. Please upload a valid CSV or XLSX file.');
        }

        return back()->with('success', 'Data imported successfully!');
    }
}
