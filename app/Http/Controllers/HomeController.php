<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use App\Models\Department;
use App\Models\FixAsset;
use App\Models\LaptopAssetCode;
use App\Models\Remark;
use App\Services\PendingEmployeeUpdateService;
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
    public function index(Request $request, PendingEmployeeUpdateService $pendingEmployeeUpdates)
    {
        $conn = DB::connection('Fixasset');
        $datas = LaptopAssetCode::latest()->paginate(20);
         /** @var User $user */
        $user = Auth::user();
        $branches = $user->hasRole('manager')
            ? Branch::all()
            : ((string) Auth::user()->emp_code === '000-000627'
                ? Branch::whereIn('branch_code', ['MM-505', 'MM-510', 'MM-511'])->get()
                : (Auth::user()->branch_id
                    ? Branch::where('id', Auth::user()->branch_id)->get()
                    : Branch::all()));
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

        /*
         * ================================================================
         * 1. LAPTOP COUNTS
         * ----------------------------------------------------------------
         * Laptop data comes from the Fixasset database. The query counts
         * active Laptop records by the original branch code/name.
         * Result: $laptopCountsByBranch -> branch, asset_type_name, asset_type_count
         * ================================================================
         */
        $laptopCountsByBranch = $conn->select("
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

        /*
         * ================================================================
         * 2. HANDSET COUNTS
         * ----------------------------------------------------------------
         * Handset data uses the same Fixasset database query pattern as
         * Laptop, but filters asset_type_name = 'Handset'.
         * Result: $handsetCountsByBranch -> branch, asset_type_name, asset_type_count
         * ================================================================
         */
        $handsetCountsByBranch = $conn->select("
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

        /*
         * ================================================================
         * 3. HANDSET + SIMCARD COUNTS
         * ----------------------------------------------------------------
         * Handset+Simcard records are stored in the local fix_assets table.
         * Their branch assignment must come from the latest Remark record:
         *   - FixAsset.branch_code -> branch filter/group key
         *   - FixAsset.branch_name -> display branch name
         * Records without a complete FixAsset branch assignment are excluded
         * from these branch-based dashboard counts. No FixAsset branch
         * fallback is used, so branch data cannot be mixed accidentally.
         * ================================================================
         */
        $activeFixAssetStatuses = ['S', 'T', 'C', 'Sold', 'Transfered', 'Cancel'];


        $activeFixAssets = FixAsset::query()
            ->where(function ($query) use ($activeFixAssetStatuses) {
                $query->whereNotIn('status', $activeFixAssetStatuses)->orWhereNull('status');
            })
            ->get(['asset_code', 'branch_code', 'branch_name', 'department', 'sub_department', 'asset_type_name']);

        /* Read branch information from the FixAsset assignment snapshot. */
        $resolveAssetBranch = static function ($asset) {
            if (blank($asset->branch_code) || blank($asset->branch_name)) {
                return null;
            }

            return [
                'code' => trim((string) $asset->branch_code),
                'name' => trim((string) $asset->branch_name),
            ];
        };
        $normalizeAssetType = static fn ($value) => preg_replace(
            '/\s+/',
            '',
            strtolower(trim((string) $value))
        );

        /* Group Handset+Simcard assets by FixAsset.branch_code. */
        $handsetSimcardAssetsGroupedByBranch = $activeFixAssets
            ->filter(function ($asset) use ($normalizeAssetType, $resolveAssetBranch) {
                return $normalizeAssetType($asset->asset_type_name) === 'handset+simcard'
                    && $resolveAssetBranch($asset) !== null;
            })
            ->groupBy(function ($asset) use ($resolveAssetBranch) {
                return $resolveAssetBranch($asset)['code'];
            });


        /* Convert grouped records into the format expected by the pie chart. */
        $handsetSimcardCountsByBranch = $handsetSimcardAssetsGroupedByBranch
            ->map(function ($assets, $branchCode) use ($resolveAssetBranch) {
                $branch = $resolveAssetBranch($assets->first());

                return (object) [
                    'branch' => $branch['name'] . ' (' . $branch['code'] . ')',
                    'asset_type_name' => 'Handset+Simcard',
                    'asset_type_count' => $assets->count(),
                ];
            })
            ->values();

        /* Build the column-chart data: branch -> sub-department -> asset type. */
        $subDepartmentAssetData = $activeFixAssets
            ->map(function ($asset) use ($resolveAssetBranch, $normalizeAssetType) {
                $branch = $resolveAssetBranch($asset);
                $type = $normalizeAssetType($asset->asset_type_name);

                if ($branch === null || !in_array($type, ['laptop', 'handset', 'handset+simcard'], true)) {
                    return null;
                }

                return [
                    'branch_code' => $branch['code'],
                    'branch' => $branch['name'] . ' (' . $branch['code'] . ')',
                    'sub_department' => trim((string) ($asset->sub_department ?: 'Unassigned')),
                    'asset_type' => $type,
                ];
            })
            ->filter()
            ->groupBy(fn ($asset) => implode('|', [$asset['branch_code'], $asset['sub_department']]))
            ->map(function ($assets) {
                $first = $assets->first();

                return [
                    'branch_code' => $first['branch_code'],
                    'branch' => $first['branch'],
                    'sub_department' => $first['sub_department'],
                    'laptop_count' => $assets->where('asset_type', 'laptop')->count(),
                    'handset_count' => $assets->where('asset_type', 'handset')->count(),
                    'handset_simcard_count' => $assets->where('asset_type', 'handset+simcard')->count(),
                ];
            })
            ->values();

        $handsetSimcardCountsByBranchCode = $handsetSimcardAssetsGroupedByBranch->map(fn ($assets) => $assets->count());


        $laptopAndHandsetCountsByBranch = $conn->select("
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


        $activeExternalAssetCodes = collect($conn->select("
            SELECT fxdt.fxassetdetailcode AS asset_code
            FROM asset.fxassetdetail fxdt
            WHERE COALESCE(fxdt.fxstatus, 'A') NOT IN ('S', 'T', 'C')
        "))
            ->pluck('asset_code')
            ->filter(fn ($assetCode) => trim((string) $assetCode) !== '')
            ->values();

        $operatorPhoneCountsByBranch = $activeExternalAssetCodes->isEmpty()
            ? collect()
            : DB::table('operators')
                ->select('branch')
                ->selectRaw('COUNT(phone) AS phone_count')
                ->whereIn('asset_code', $activeExternalAssetCodes->all())
                ->whereNotNull('phone')
                ->whereRaw("TRIM(phone) <> ''")
                ->groupBy('branch')
                ->get();
        $nonAssetOperatorCountsByBranch = DB::select("SELECT branch, COUNT(phone) AS phone_count FROM non_operators GROUP BY branch");
        $pendingEmployeeUpdateData = $user->hasRole('manager')
            ? $pendingEmployeeUpdates->get(
                $selectedMonth ? $monthStart : null,
                $selectedMonth ? $monthEnd : null,
            )
            : collect();

        $totalPhoneCount = collect($nonAssetOperatorCountsByBranch)->sum('phone_count');
        $branchAssetSummary = [];
        $normalizeBranch = static function ($branch) {
            $branch = trim((string) $branch);
            $branch = preg_replace('/\s+/', ' ', $branch);

            // Use MM branch code as the merge key. This handles differences in
            // spacing, spelling, and punctuation in the branch name.
            if (preg_match('/\(\s*(MM-\d+)\s*\)/i', $branch, $matches)) {
                return strtoupper($matches[1]);
            }

            return preg_replace('/\s*\(\s*/', '(', preg_replace('/\s*\)\s*/', ')', $branch));
        };
        
        foreach ($laptopAndHandsetCountsByBranch as $assetCountByBranch) {
            $branchKey = $normalizeBranch($assetCountByBranch->branch);
            $branchAssetSummary[$branchKey]['branch'] = $branchKey;
        
            $branchAssetSummary[$branchKey]['asset_type_count'][$assetCountByBranch->asset_type_name] =
                ($branchAssetSummary[$branchKey]['asset_type_count'][$assetCountByBranch->asset_type_name] ?? 0)
                + (int) $assetCountByBranch->asset_type_count;
        }

        foreach ($handsetCountsByBranch as $handsetCountByBranch) {
            $branchKey = $normalizeBranch($handsetCountByBranch->branch);
            $branchAssetSummary[$branchKey]['branch'] = $branchKey;
            $branchAssetSummary[$branchKey]['handset_count'] =
                ($branchAssetSummary[$branchKey]['handset_count'] ?? 0) + (int) $handsetCountByBranch->asset_type_count;
        }

        foreach ($handsetSimcardCountsByBranchCode as $branchCode => $count) {
            $branchKey = trim((string) $branchCode);
            $branchAssetSummary[$branchKey]['branch'] = $branchKey;
            $branchAssetSummary[$branchKey]['handset_simcard_count'] =
                ($branchAssetSummary[$branchKey]['handset_simcard_count'] ?? 0) + (int) $count;
        }

        foreach ($operatorPhoneCountsByBranch as $operatorPhoneCountByBranch) {
            $branchKey = $normalizeBranch($operatorPhoneCountByBranch->branch);
            if (!isset($branchAssetSummary[$branchKey])) {
                $branchAssetSummary[$branchKey] = [
                    'branch' => $branchKey,
                    'handset_count' => 0,
                    'operator_count' => 0,
                ];
            }

            $branchAssetSummary[$branchKey]['operator_count'] =
                ($branchAssetSummary[$branchKey]['operator_count'] ?? 0) + (int) $operatorPhoneCountByBranch->phone_count;
        }

        foreach ($nonAssetOperatorCountsByBranch as $nonAssetOperatorCountByBranch) {
            $branchKey = $normalizeBranch($nonAssetOperatorCountByBranch->branch);
            if (!isset($branchAssetSummary[$branchKey])) {
                $branchAssetSummary[$branchKey] = [
                    'branch' => $branchKey,
                    'handset_count' => 0,
                    'operator_count' => 0,
                ];
            }

            $branchAssetSummary[$branchKey]['operator_count'] =
                ($branchAssetSummary[$branchKey]['operator_count'] ?? 0) + (int) $nonAssetOperatorCountByBranch->phone_count;
        }

        $branchAssetSummary = array_values($branchAssetSummary);

        $branchShortNames = [];
        $branchesWithShortNames = Branch::query()
            ->whereNotNull('branch_code')
            ->whereNotNull('branch_short_name')
            ->get(['branch_code', 'branch_short_name']);

        foreach ($branchesWithShortNames as $branch) {
            $branchCode = strtoupper(trim((string) $branch->branch_code));
            $shortName = trim((string) $branch->branch_short_name);

            $branchShortNames[$branchCode] = $shortName;
        }

        return view('dashboard', compact(
            'datas',
            'branches',
            'departments',
            'laptopCountsByBranch',
            'handsetCountsByBranch',
            'handsetSimcardCountsByBranch',
            'subDepartmentAssetData',
            'branchAssetSummary',
            'nonAssetOperatorCountsByBranch',
            'totalPhoneCount',
            'pendingEmployeeUpdateData',
            'branchShortNames'
        ));
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
