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

        // Handset + Simcard assets are maintained in the local FixAsset table.
        // Use the same source as the Fix Asset page so the dashboard cannot
        // disagree with the records users see there.
        $assetCountsSim = FixAsset::query()
            ->select('branch_code', 'branch_name', 'asset_type_name')
            ->selectRaw('COUNT(*) AS asset_type_count')
            ->whereRaw("REPLACE(LOWER(TRIM(asset_type_name)), ' ', '') = ?", ['handset+simcard'])
            ->whereNotIn('status', ['S', 'T', 'C', 'Sold', 'Transfered', 'Cancel'])
            ->groupBy('branch_code', 'branch_name', 'asset_type_name')
            ->orderBy('branch_code')
            ->get()
            ->map(function ($asset) {
                return (object) [
                    'branch' => trim((string) $asset->branch_name) . ' (' . trim((string) $asset->branch_code) . ')',
                    'asset_type_name' => $asset->asset_type_name,
                    'asset_type_count' => (int) $asset->asset_type_count,
                ];
            })
            ->values();

        // Keep the detail chart at the same grain users maintain in Fix Asset:
        // branch -> sub-department -> asset type. The latest remark is used
        // because employee/sub-department assignments can change over time.
        $dashboardAssets = FixAsset::query()
            ->whereNotIn('status', ['S', 'T', 'C', 'Sold', 'Transfered', 'Cancel'])
            ->get(['asset_code', 'branch_code', 'branch_name', 'asset_type_name']);
        $dashboardRemarks = Remark::query()
            ->whereIn('asset_code', $dashboardAssets->pluck('asset_code'))
            ->latest('updated_at')
            ->latest('id')
            ->get()
            ->unique('asset_code')
            ->keyBy('asset_code');

        $subDepartmentAssetData = $dashboardAssets
            ->map(function ($asset) use ($dashboardRemarks) {
                $remark = $dashboardRemarks->get($asset->asset_code);
                $type = preg_replace('/\s+/', '', strtolower(trim((string) $asset->asset_type_name)));

                if (!in_array($type, ['laptop', 'handset'], true)) {
                    return null;
                }

                return [
                    'branch_code' => trim((string) $asset->branch_code),
                    'branch' => trim((string) $asset->branch_name) . ' (' . trim((string) $asset->branch_code) . ')',
                    'sub_department' => trim((string) ($remark?->sub_department ?: 'Unassigned')),
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
                ];
            })
            ->values();

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


        $ongoingAssetCodes = collect($conn->select("
            SELECT fxdt.fxassetdetailcode AS asset_code
            FROM asset.fxassetdetail fxdt
            WHERE COALESCE(fxdt.fxstatus, 'A') NOT IN ('S', 'T', 'C')
        "))
            ->pluck('asset_code')
            ->filter(fn ($assetCode) => trim((string) $assetCode) !== '')
            ->values();

        $opers = $ongoingAssetCodes->isEmpty()
            ? collect()
            : DB::table('operators')
                ->select('branch')
                ->selectRaw('COUNT(phone) AS phone_count')
                ->whereIn('asset_code', $ongoingAssetCodes->all())
                ->whereNotNull('phone')
                ->whereRaw("TRIM(phone) <> ''")
                ->groupBy('branch')
                ->get();
        $nonopers = DB::select("SELECT branch, COUNT(phone) AS phone_count FROM non_operators GROUP BY branch");
        $pendingEmployeeUpdateData = $user->hasRole('manager')
            ? $pendingEmployeeUpdates->get(
                $selectedMonth ? $monthStart : null,
                $selectedMonth ? $monthEnd : null,
            )
            : collect();

        $totalPhoneCount = collect($nonopers)->sum('phone_count');

        // dd($nonopers);

        $mergedData = [];
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

        foreach ($assetCountslh as $asset) {
            $branchKey = $normalizeBranch($asset->branch);
            $mergedData[$branchKey]['branch'] = $branchKey;
            $mergedData[$branchKey]['asset_type_count'][$asset->asset_type_name] =
                ($mergedData[$branchKey]['asset_type_count'][$asset->asset_type_name] ?? 0)
                + (int) $asset->asset_type_count;
        }

        foreach ($assetCounts1 as $asset) {
            $branchKey = $normalizeBranch($asset->branch);
            $mergedData[$branchKey]['branch'] = $branchKey;
            $mergedData[$branchKey]['handset_count'] =
                ($mergedData[$branchKey]['handset_count'] ?? 0) + (int) $asset->asset_type_count;
        }

        foreach ($opers as $oper) {
            $branchKey = $normalizeBranch($oper->branch);
            if (!isset($mergedData[$branchKey])) {
                $mergedData[$branchKey] = [
                    'branch' => $branchKey,
                    'handset_count' => 0,
                    'operator_count' => 0,
                ];
            }

            $mergedData[$branchKey]['operator_count'] =
                ($mergedData[$branchKey]['operator_count'] ?? 0) + (int) $oper->phone_count;
        }

        foreach ($nonopers as $nonoper) {
            $branchKey = $normalizeBranch($nonoper->branch);
            if (!isset($mergedData[$branchKey])) {
                $mergedData[$branchKey] = [
                    'branch' => $branchKey,
                    'handset_count' => 0,
                    'operator_count' => 0,
                ];
            }

            $mergedData[$branchKey]['operator_count'] =
                ($mergedData[$branchKey]['operator_count'] ?? 0) + (int) $nonoper->phone_count;
        }

        $mergedData = array_values($mergedData);

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

        return view('dashboard', compact('datas', 'branches', 'departments', 'assetCounts', 'assetCounts1', 'assetCountsSim', 'subDepartmentAssetData', 'mergedData', 'nonopers', 'totalPhoneCount', 'pendingEmployeeUpdateData', 'branchShortNames'));
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
