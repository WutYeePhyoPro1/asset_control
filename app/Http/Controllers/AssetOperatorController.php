<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\AssetOperator;
use Maatwebsite\Excel\Facades\Excel;
class AssetOperatorController extends Controller
{
    // public function showForm()
    // {
    //     return view('import-form'); // Create a Blade view for the import form
    // }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,xlsx',
        ]);

        $file = $request->file('file');

        try {
            Excel::import(new AssetOperator, $file);
        } catch (SheetNotFoundException $exception) {
            return redirect('laptop_asset_code.fixasset_detail')->with('error', 'Invalid file format. Please upload a valid CSV or XLSX file.');
        }

        return back()->with('success', 'Data imported successfully!');
    }

}
