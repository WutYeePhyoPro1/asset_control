<?php

namespace App\Http\Controllers;

use App\Exports\MasterSimSampleExport;
use App\Imports\MasterSimImport;
use App\Models\MasterSim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MasterSimController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'type' => ['nullable', 'in:reserve,available,used'],
        ]);

        $type = $request->input('type');

        $query = MasterSim::query();

        if ($type) {
            $query->where('type', $type);
        }

        $sims = $query->orderBy('id')->paginate(20)->withQueryString();

        return view('master_sim.index', compact('sims'));
    }

    public function sample()
    {
        return Excel::download(new MasterSimSampleExport(), 'master_sim_sample.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv'],
        ]);

        $import = new MasterSimImport();

        try {
            DB::transaction(fn () => Excel::import($import, $request->file('file')));
        } catch (\Throwable $exception) {
            return back()
                ->withInput()
                ->with('error', 'SIM import failed: ' . $exception->getMessage());
        }

        return back()->with('import_summary', $import->summary());
    }
}
