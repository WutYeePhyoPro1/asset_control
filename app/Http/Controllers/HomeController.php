<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\LaptopAssetCode;
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
    public function index()
    {
        $conn = DB::connection('Fixasset');
        $datas=LaptopAssetCode::latest()->paginate(20);
        $branches=Branch::all();
        $departments=Department::all();

                    $assetCounts = $conn->select("
                    SELECT branch_name || '(' || branch_code || ')' AS branch,
                        asset_type_name,
                        COUNT(asset_type_name) AS asset_type_count
                    FROM (
                        SELECT
                        fxdt.fxbranchcode AS branch_code, fxbr.fxbranchname AS branch_name, fxdp.fxdepartmentname AS department, fxtp.fxassettypename AS asset_type_name,
                        fxdt.fxassetdetailcode AS asset_code, fxdt.fxassetdetailname AS asset_name, fxdt.fxdatebuy AS purchase_date, fxdt.fxenddatecal AS stop_cal_date, fxdt.fxstatus AS status
                        FROM asset.fxassetdetail fxdt
                        LEFT JOIN asset.fxbranch fxbr ON fxdt.fxbranchcode = fxbr.fxbranchcode
                        LEFT JOIN asset.fxdepartment fxdp ON fxdt.fxdepartmentcode = fxdp.fxdepartmentcode
                        LEFT JOIN asset.fxassetgroup fxgp ON fxgp.fxassettypecode = fxdt.fxassettypecode
                        LEFT JOIN asset.fxassettype fxtp ON fxtp.fxassettypecode = fxdt.fxassettypecode
                        LEFT JOIN asset.fxassetcategory fxct ON fxct.fxassetcategorycode = fxdt.fxassetcategorycode
                        LEFT JOIN asset.fxassetsale fxsa ON fxsa.fxassetdetailcode = fxdt.fxassetdetailcode
                        LEFT JOIN asset.fxassettransfer fxtf ON fxtf.fxassetdetailcode = fxdt.fxassetdetailcode
                        WHERE fxtp.fxassettypename IN ('Laptop')
                        ORDER BY purchase_date
                    ) xx
                    GROUP BY branch_code, branch_name, asset_type_name
                    ORDER BY branch_code
                ");

                $assetCounts1 = $conn->select("
                SELECT branch_name || '(' || branch_code || ')' AS branch,
                    asset_type_name,
                    COUNT(asset_type_name) AS asset_type_count
                FROM (
                    SELECT
                    fxdt.fxbranchcode AS branch_code, fxbr.fxbranchname AS branch_name, fxdp.fxdepartmentname AS department, fxtp.fxassettypename AS asset_type_name,
                    fxdt.fxassetdetailcode AS asset_code, fxdt.fxassetdetailname AS asset_name, fxdt.fxdatebuy AS purchase_date, fxdt.fxenddatecal AS stop_cal_date, fxdt.fxstatus AS status
                    FROM asset.fxassetdetail fxdt
                    LEFT JOIN asset.fxbranch fxbr ON fxdt.fxbranchcode = fxbr.fxbranchcode
                    LEFT JOIN asset.fxdepartment fxdp ON fxdt.fxdepartmentcode = fxdp.fxdepartmentcode
                    LEFT JOIN asset.fxassetgroup fxgp ON fxgp.fxassettypecode = fxdt.fxassettypecode
                    LEFT JOIN asset.fxassettype fxtp ON fxtp.fxassettypecode = fxdt.fxassettypecode
                    LEFT JOIN asset.fxassetcategory fxct ON fxct.fxassetcategorycode = fxdt.fxassetcategorycode
                    LEFT JOIN asset.fxassetsale fxsa ON fxsa.fxassetdetailcode = fxdt.fxassetdetailcode
                    LEFT JOIN asset.fxassettransfer fxtf ON fxtf.fxassetdetailcode = fxdt.fxassetdetailcode
                    WHERE fxtp.fxassettypename IN ('Handset')
                    ORDER BY purchase_date
                ) xx
                GROUP BY branch_code, branch_name, asset_type_name
                ORDER BY branch_code
            ");


                            $assetCountslh = $conn->select("
                    SELECT branch_name || '(' || branch_code || ')' AS branch,
                    asset_type_name,
                    COUNT(asset_type_name) AS asset_type_count
                    FROM (
                        SELECT
                        fxdt.fxbranchcode AS branch_code, fxbr.fxbranchname AS branch_name, fxdp.fxdepartmentname AS department, fxtp.fxassettypename AS asset_type_name,
                        fxdt.fxassetdetailcode AS asset_code, fxdt.fxassetdetailname AS asset_name, fxdt.fxdatebuy AS purchase_date, fxdt.fxenddatecal AS stop_cal_date, fxdt.fxstatus AS status
                        FROM asset.fxassetdetail fxdt
                        LEFT JOIN asset.fxbranch fxbr ON fxdt.fxbranchcode = fxbr.fxbranchcode
                        LEFT JOIN asset.fxdepartment fxdp ON fxdt.fxdepartmentcode = fxdp.fxdepartmentcode
                        LEFT JOIN asset.fxassetgroup fxgp ON fxgp.fxassettypecode = fxdt.fxassettypecode
                        LEFT JOIN asset.fxassettype fxtp ON fxtp.fxassettypecode = fxdt.fxassettypecode
                        LEFT JOIN asset.fxassetcategory fxct ON fxct.fxassetcategorycode = fxdt.fxassetcategorycode
                        LEFT JOIN asset.fxassetsale fxsa ON fxsa.fxassetdetailcode = fxdt.fxassetdetailcode
                        LEFT JOIN asset.fxassettransfer fxtf ON fxtf.fxassetdetailcode = fxdt.fxassetdetailcode
                        WHERE fxtp.fxassettypename IN ('Laptop','Handset')
                        ORDER BY purchase_date
                    ) xx
                    GROUP BY branch_code, branch_name, asset_type_name
                    ORDER BY branch_code
                ");

                $opers = DB::select("SELECT branch, COUNT(phone) AS phone_count FROM operators GROUP BY branch");


                $mergedData = [];
                foreach ($assetCountslh as $asset) {
                    $mergedData[$asset->branch]['branch'] = $asset->branch;
                    $mergedData[$asset->branch]['asset_type_count'][$asset->asset_type_name] = $asset->asset_type_count;
                }

                foreach ($opers as $oper) {
                    $branch = $oper->branch;
                    if (isset($mergedData[$branch])) {
                        $mergedData[$branch]['phone_count'] = $oper->phone_count;
                    } else {
                        $mergedData[$branch]['branch'] = $branch;
                        $mergedData[$branch]['phone_count'] = $oper->phone_count;
                    }
                }


                $mergedData = array_values($mergedData);

        return view('dashboard',compact('datas','branches','departments','assetCounts','assetCounts1','mergedData'));
        // return view('laptop_asset_code.index');
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
