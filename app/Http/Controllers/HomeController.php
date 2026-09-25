<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\LaptopAssetCode;
use App\Models\FixAsset;
use App\Models\Remark;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $conn = DB::connection('Fixasset');
        $datas = LaptopAssetCode::latest()->paginate(20);
        $branches = Branch::all();
        $departments = Department::all();
        $selectedMonth = $request->input('month');

        $request->validate([
            'month' => ['nullable', 'date_format:Y-m'],
        ]);

        $dateFilter = '';
        $dateBindings = [];

        if ($selectedMonth) {
            $monthStart = Carbon::createFromFormat('!Y-m', $selectedMonth)->startOfMonth();
            $monthEnd = $monthStart->copy()->addMonth();
            $dateFilter = "
        AND fxdt.fxdatebuy >= :month_start
        AND fxdt.fxdatebuy < :month_end
    ";

            $dateBindings = [
                'month_start' => $monthStart,
                'month_end' => $monthEnd,
            ];
        }

        $assetCounts = $conn->select("
                    SELECT branch_name || '(' || branch_code || ')' AS branch,
                asset_type_name,
                COUNT(asset_type_name) AS asset_type_count
         FROM
		 (
             SELECT fxdt.fxbranchcode AS branch_code,
                    fxbr.fxbranchname AS branch_name,
                    fxdp.fxdepartmentname AS department,
                    fxtp.fxassettypename AS asset_type_name,
                    fxdt.fxassetdetailcode AS asset_code,
                    fxdt.fxassetdetailname AS asset_name,
                    fxdt.fxdatebuy AS purchase_date,
                    fxdt.fxenddatecal AS stop_cal_date,
			 	COALESCE(fxdt.fxstatus, 'A') AS status
             FROM asset.fxassetdetail fxdt
             LEFT JOIN asset.fxbranch fxbr ON fxdt.fxbranchcode = fxbr.fxbranchcode
             LEFT JOIN asset.fxdepartment fxdp ON fxdt.fxdepartmentcode = fxdp.fxdepartmentcode
             LEFT JOIN asset.fxassetgroup fxgp ON fxgp.fxassettypecode = fxdt.fxassettypecode
             LEFT JOIN asset.fxassettype fxtp ON fxtp.fxassettypecode = fxdt.fxassettypecode
             LEFT JOIN asset.fxassetcategory fxct ON fxct.fxassetcategorycode = fxdt.fxassetcategorycode
             LEFT JOIN asset.fxassetsale fxsa ON fxsa.fxassetdetailcode = fxdt.fxassetdetailcode
             LEFT JOIN asset.fxassettransfer fxtf ON fxtf.fxassetdetailcode = fxdt.fxassetdetailcode
             WHERE fxtp.fxassettypename IN ('Laptop')
             {$dateFilter}
             ORDER BY purchase_date
         ) xx
		 where xx.status not in ('S','T','C')
         GROUP BY branch_code, branch_name, asset_type_name
         ORDER BY branch_code;
                ", $dateBindings);

        $assetCounts1 = $conn->select("
            SELECT branch_name || '(' || branch_code || ')' AS branch,
            asset_type_name,
            COUNT(asset_type_name) AS asset_type_count
     FROM
     (
         SELECT fxdt.fxbranchcode AS branch_code,
                fxbr.fxbranchname AS branch_name,
                fxdp.fxdepartmentname AS department,
                fxtp.fxassettypename AS asset_type_name,
                fxdt.fxassetdetailcode AS asset_code,
                fxdt.fxassetdetailname AS asset_name,
                fxdt.fxdatebuy AS purchase_date,
                fxdt.fxenddatecal AS stop_cal_date,
             COALESCE(fxdt.fxstatus, 'A') AS status
         FROM asset.fxassetdetail fxdt
         LEFT JOIN asset.fxbranch fxbr ON fxdt.fxbranchcode = fxbr.fxbranchcode
         LEFT JOIN asset.fxdepartment fxdp ON fxdt.fxdepartmentcode = fxdp.fxdepartmentcode
         LEFT JOIN asset.fxassetgroup fxgp ON fxgp.fxassettypecode = fxdt.fxassettypecode
         LEFT JOIN asset.fxassettype fxtp ON fxtp.fxassettypecode = fxdt.fxassettypecode
         LEFT JOIN asset.fxassetcategory fxct ON fxct.fxassetcategorycode = fxdt.fxassetcategorycode
         LEFT JOIN asset.fxassetsale fxsa ON fxsa.fxassetdetailcode = fxdt.fxassetdetailcode
         LEFT JOIN asset.fxassettransfer fxtf ON fxtf.fxassetdetailcode = fxdt.fxassetdetailcode
         WHERE fxtp.fxassettypename IN ('Handset')
         {$dateFilter}
         ORDER BY purchase_date
     ) xx
     where xx.status not in ('S','T','C')
     GROUP BY branch_code, branch_name, asset_type_name
     ORDER BY branch_code;
            ", $dateBindings);

        $assetCountslh = $conn->select("
                SELECT branch_name || '(' || branch_code || ')' AS branch,
                asset_type_name,
                COUNT(asset_type_name) AS asset_type_count
         FROM
		 (
             SELECT fxdt.fxbranchcode AS branch_code,
                    fxbr.fxbranchname AS branch_name,
                    fxdp.fxdepartmentname AS department,
                    fxtp.fxassettypename AS asset_type_name,
                    fxdt.fxassetdetailcode AS asset_code,
                    fxdt.fxassetdetailname AS asset_name,
                    fxdt.fxdatebuy AS purchase_date,
                    fxdt.fxenddatecal AS stop_cal_date,
			 	COALESCE(fxdt.fxstatus, 'A') AS status
             FROM asset.fxassetdetail fxdt
             LEFT JOIN asset.fxbranch fxbr ON fxdt.fxbranchcode = fxbr.fxbranchcode
             LEFT JOIN asset.fxdepartment fxdp ON fxdt.fxdepartmentcode = fxdp.fxdepartmentcode
             LEFT JOIN asset.fxassetgroup fxgp ON fxgp.fxassettypecode = fxdt.fxassettypecode
             LEFT JOIN asset.fxassettype fxtp ON fxtp.fxassettypecode = fxdt.fxassettypecode
             LEFT JOIN asset.fxassetcategory fxct ON fxct.fxassetcategorycode = fxdt.fxassetcategorycode
             LEFT JOIN asset.fxassetsale fxsa ON fxsa.fxassetdetailcode = fxdt.fxassetdetailcode
             LEFT JOIN asset.fxassettransfer fxtf ON fxtf.fxassetdetailcode = fxdt.fxassetdetailcode
             WHERE fxtp.fxassettypename IN ('Laptop', 'Handset')
             {$dateFilter}
             ORDER BY purchase_date
         ) xx
		 where xx.status not in ('S','T','C')
         GROUP BY branch_code, branch_name, asset_type_name
         ORDER BY branch_code;
                ", $dateBindings);

        $opers = DB::select("SELECT branch, COUNT(phone) AS phone_count FROM operators GROUP BY branch");
        $nonopers = DB::select("SELECT branch, COUNT(phone) AS phone_count FROM non_operators GROUP BY branch");

        // Count active Laptop/Handset assets whose latest employee assignment
        // is missing either the employee ID or employee name.
        $pendingAssetsQuery = FixAsset::query()
            ->whereIn('asset_type_name', ['Laptop', 'Handset'])
            ->where('status', 'Ongoing');

        if ($selectedMonth) {
            $pendingAssetsQuery
                ->whereDate('purchase_date', '>=', $monthStart->toDateString())
                ->whereDate('purchase_date', '<', $monthEnd->toDateString());
        }

        $pendingAssets = $pendingAssetsQuery
            ->get(['asset_code', 'branch_code', 'branch_name']);

        $latestRemarks = Remark::whereIn('asset_code', $pendingAssets->pluck('asset_code'))
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->get()
            ->unique('asset_code')
            ->keyBy('asset_code');

        $pendingEmployeeUpdates = $pendingAssets
            ->filter(function ($asset) use ($latestRemarks) {
                $remark = $latestRemarks->get($asset->asset_code);
                return blank($remark?->emp_id) || blank($remark?->emp_name);
            })
            ->groupBy(function ($asset) {
                return $asset->branch_name . '(' . $asset->branch_code . ')';
            })
            ->map(function ($assets, $branch) {
                return [
                    'branch' => $branch,
                    'pending_count' => $assets->count(),
                ];
            })
            ->values();

        $totalPhoneCount = collect($nonopers)->sum('phone_count');

        // dd($nonopers);

        $mergedData = [];
        $normalizeBranch = static function ($branch) {
            $branch = trim((string) $branch);
            $branch = preg_replace('/\s+/', ' ', $branch);
            return preg_replace('/\s*\(\s*/', '(', preg_replace('/\s*\)\s*/', ')', $branch));
        };

        foreach ($assetCountslh as $asset) {
            $branchKey = $normalizeBranch($asset->branch);
            $mergedData[$branchKey]['branch'] = $branchKey;
            $mergedData[$branchKey]['asset_type_count'][$asset->asset_type_name] = $asset->asset_type_count;
        }

        foreach ($assetCounts1 as $asset) {
            $branch = $normalizeBranch($asset->branch);
            $mergedData[$branch]['branch'] = $branch;
            $mergedData[$branch]['handset_count'] = $asset->asset_type_count;
        }

        foreach ($opers as $oper) {
            $branch = $normalizeBranch($oper->branch);
            if (isset($mergedData[$branch])) {
                $mergedData[$branch]['operator_count'] = $oper->phone_count;
            } else {
                $mergedData[$branch] = [
                    'branch' => $branch,
                    'handset_count' => 0,
                    'operator_count' => $oper->phone_count,
                ];
            }
        }

        // foreach ($nonopers as $nonoper) {
        //     $branch = $nonoper->branch;
        //     if (isset($mergedData[$branch])) {
        //         $mergedData[$branch]['non_operator_count'] = $nonoper->phone_count;
        //     } else {

        //         $mergedData[$branch]['branch'] = $branch;
        //         $mergedData[$branch]['non_operator_count'] = $nonoper->phone_count;
        //     }
        // }


        $mergedData = array_values($mergedData);
        return view('dashboard', compact('datas', 'branches', 'departments', 'assetCounts', 'assetCounts1', 'mergedData', 'nonopers', 'totalPhoneCount', 'pendingEmployeeUpdates'));
    }

    public function logout()
    {
        // Clear all data from the session
        Session::flush();

        // Log the user out
        Auth::logout();

        return redirect()->route('login');
    }
}
