<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Department;
use App\Models\LaptopAssetCode;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // public function username(){
    //     return 'emp_code';
    // }

    public function login(Request $request)
    {
            // dd('hi');
        $credentials = $request->validate([
            'emp_code' => 'required',
            'password' => 'required',
        ]);


        // dd($credentials);
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // dd($user->status==1);
            if ($user->status == '1') {
                return redirect('/home');
                // $conn = DB::connection('Fixasset');
                // $datas=LaptopAssetCode::latest()->paginate(20);
                // $branches=Branch::all();
                // $departments=Department::all();

                //             $assetCounts = $conn->select("
                //             SELECT branch_name || '(' || branch_code || ')' AS branch,
                //                 asset_type_name,
                //                 COUNT(asset_type_name) AS asset_type_count
                //             FROM (
                //                 SELECT
                //                 fxdt.fxbranchcode AS branch_code, fxbr.fxbranchname AS branch_name, fxdp.fxdepartmentname AS department, fxtp.fxassettypename AS asset_type_name,
                //                 fxdt.fxassetdetailcode AS asset_code, fxdt.fxassetdetailname AS asset_name, fxdt.fxdatebuy AS purchase_date, fxdt.fxenddatecal AS stop_cal_date, fxdt.fxstatus AS status
                //                 FROM asset.fxassetdetail fxdt
                //                 LEFT JOIN asset.fxbranch fxbr ON fxdt.fxbranchcode = fxbr.fxbranchcode
                //                 LEFT JOIN asset.fxdepartment fxdp ON fxdt.fxdepartmentcode = fxdp.fxdepartmentcode
                //                 LEFT JOIN asset.fxassetgroup fxgp ON fxgp.fxassettypecode = fxdt.fxassettypecode
                //                 LEFT JOIN asset.fxassettype fxtp ON fxtp.fxassettypecode = fxdt.fxassettypecode
                //                 LEFT JOIN asset.fxassetcategory fxct ON fxct.fxassetcategorycode = fxdt.fxassetcategorycode
                //                 LEFT JOIN asset.fxassetsale fxsa ON fxsa.fxassetdetailcode = fxdt.fxassetdetailcode
                //                 LEFT JOIN asset.fxassettransfer fxtf ON fxtf.fxassetdetailcode = fxdt.fxassetdetailcode
                //                 WHERE fxtp.fxassettypename IN ('Laptop')
                //                 AND fxdt.fxstatus <> 'sold'
                //                 ORDER BY purchase_date
                //             ) xx
                //             GROUP BY branch_code, branch_name, asset_type_name
                //             ORDER BY branch_code
                //         ");

                //     $assetCounts1 = $conn->select("
                //         SELECT branch_name || '(' || branch_code || ')' AS branch,
                //             asset_type_name,
                //             COUNT(asset_type_name) AS asset_type_count
                //         FROM (
                //             SELECT
                //             fxdt.fxbranchcode AS branch_code, fxbr.fxbranchname AS branch_name, fxdp.fxdepartmentname AS department, fxtp.fxassettypename AS asset_type_name,
                //             fxdt.fxassetdetailcode AS asset_code, fxdt.fxassetdetailname AS asset_name, fxdt.fxdatebuy AS purchase_date, fxdt.fxenddatecal AS stop_cal_date, fxdt.fxstatus AS status
                //             FROM asset.fxassetdetail fxdt
                //             LEFT JOIN asset.fxbranch fxbr ON fxdt.fxbranchcode = fxbr.fxbranchcode
                //             LEFT JOIN asset.fxdepartment fxdp ON fxdt.fxdepartmentcode = fxdp.fxdepartmentcode
                //             LEFT JOIN asset.fxassetgroup fxgp ON fxgp.fxassettypecode = fxdt.fxassettypecode
                //             LEFT JOIN asset.fxassettype fxtp ON fxtp.fxassettypecode = fxdt.fxassettypecode
                //             LEFT JOIN asset.fxassetcategory fxct ON fxct.fxassetcategorycode = fxdt.fxassetcategorycode
                //             LEFT JOIN asset.fxassetsale fxsa ON fxsa.fxassetdetailcode = fxdt.fxassetdetailcode
                //             LEFT JOIN asset.fxassettransfer fxtf ON fxtf.fxassetdetailcode = fxdt.fxassetdetailcode
                //             WHERE fxtp.fxassettypename IN ('Handset')
                //             AND fxdt.fxstatus <> 'sold'
                //             ORDER BY purchase_date
                //         ) xx
                //         GROUP BY branch_code, branch_name, asset_type_name
                //         ORDER BY branch_code
                //     ");


                //         $assetCountslh = $conn->select("
                //         SELECT branch_name || '(' || branch_code || ')' AS branch,
                //         asset_type_name,
                //         COUNT(asset_type_name) AS asset_type_count
                //  FROM (
                //      SELECT fxdt.fxbranchcode AS branch_code,
                //             fxbr.fxbranchname AS branch_name,
                //             fxdp.fxdepartmentname AS department,
                //             fxtp.fxassettypename AS asset_type_name,
                //             fxdt.fxassetdetailcode AS asset_code,
                //             fxdt.fxassetdetailname AS asset_name,
                //             fxdt.fxdatebuy AS purchase_date,
                //             fxdt.fxenddatecal AS stop_cal_date,
                //             fxdt.fxstatus AS status
                //      FROM asset.fxassetdetail fxdt
                //      LEFT JOIN asset.fxbranch fxbr ON fxdt.fxbranchcode = fxbr.fxbranchcode
                //      LEFT JOIN asset.fxdepartment fxdp ON fxdt.fxdepartmentcode = fxdp.fxdepartmentcode
                //      LEFT JOIN asset.fxassetgroup fxgp ON fxgp.fxassettypecode = fxdt.fxassettypecode
                //      LEFT JOIN asset.fxassettype fxtp ON fxtp.fxassettypecode = fxdt.fxassettypecode
                //      LEFT JOIN asset.fxassetcategory fxct ON fxct.fxassetcategorycode = fxdt.fxassetcategorycode
                //      LEFT JOIN asset.fxassetsale fxsa ON fxsa.fxassetdetailcode = fxdt.fxassetdetailcode
                //      LEFT JOIN asset.fxassettransfer fxtf ON fxtf.fxassetdetailcode = fxdt.fxassetdetailcode
                //      WHERE fxtp.fxassettypename IN ('Laptop', 'Handset')
                //        AND fxdt.fxstatus <> 'sold'
                //      ORDER BY purchase_date
                //  ) xx
                //  GROUP BY branch_code, branch_name, asset_type_name
                //  ORDER BY branch_code;
                //         ");

                //         // dd($assetCountslh);

                //         $opers = DB::select("SELECT branch, COUNT(phone) AS phone_count FROM operators GROUP BY branch");


                //         $mergedData = [];
                //         foreach ($assetCountslh as $asset) {
                //             $mergedData[$asset->branch]['branch'] = $asset->branch;
                //             $mergedData[$asset->branch]['asset_type_count'][$asset->asset_type_name] = $asset->asset_type_count;
                //         }

                //         foreach ($opers as $oper) {
                //             $branch = $oper->branch;
                //             if (isset($mergedData[$branch])) {
                //                 $mergedData[$branch]['phone_count'] = $oper->phone_count;
                //             } else {
                //                 $mergedData[$branch]['branch'] = $branch;
                //                 $mergedData[$branch]['phone_count'] = $oper->phone_count;
                //             }
                //         }

                //         $mergedData = array_values($mergedData);

                //         // dd($mergedData);
                // return view('dashboard',compact('datas','branches','departments','assetCounts','assetCounts1','mergedData'));
            } else {
                // dd('hi');
                Auth::logout();
                return redirect()->back()->with('error', 'Your account is inactive.');
            }
        }

        return redirect()->back()->withErrors(['emp_id' => 'Invalid credentials.']);
    }
}
