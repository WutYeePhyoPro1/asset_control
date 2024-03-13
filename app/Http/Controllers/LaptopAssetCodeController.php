<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\LaptopAssetCode;
use App\Models\Assetfile;
use App\Models\AssetType;
use App\Models\NonOperator;
use App\Models\NonRemark;
use App\Models\Remark;
use App\Models\Operator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class LaptopAssetCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas=LaptopAssetCode::latest()->get();
        $branches=Branch::all();
        $departments=Department::all();

        return view('laptop_asset_code.index',compact('datas','branches','departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches=Branch::all();
        $departments=Department::all();
        return view('laptop_asset_code.create',compact('branches','departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'assettype.*' => 'required',
            'assetname.*' => 'required',
            'assetcode.*' => 'required',
        ],[
            'assettype.*.required' => 'Asset type ရွေးချယ်ရန်လိုပါသည်။ (Please select at least one Asset type.)',
            'assetname.*.required' => 'Asset Code ရွေးချယ်ရန်လိုပါသည်။ (Please select at least one Asset code.)',
            'assetcode.*.required' => 'Asset Name ရွေးချယ်ရန်လိုပါသည်။ (Please select at least one Asset name.)',

        ]

    );

        $date = Carbon::parse($request->date)->format('Ymd');
        $today=LaptopAssetCode::where(['date'=>Carbon::parse($request->date)->format('Y-m-d'),'type'=>$request->type])->distinct('doc_no')->get();

        if ($today->isEmpty()) {
            $suffix = 1;
        } else {
            $next = $today->count();
            $suffix = $next + 1;
        }

        $data = sprintf("%'.04d", $suffix);

        if ($request->type == 'Dept') {
            $doc_no = 'ACSDE' . $date . '-' . $data;
        } else {
            $doc_no = 'ACSEM' . $date . '-' . $data;
        }

        // if($request){

        // }

        $asset=LaptopAssetCode::create([
            'user_id'=>$request->userid,
            'doc_no'=>$doc_no,
            'type'=>$request->type,
            'emp_name'=>$request->empname,
            'emp_code'=>$request->empcode,
            'branch_code'=>$request->branchcode,
            'branch_name'=>$request->branchname,
            'department'=>$request->department,
            'receipt_date'=>$request->receiptdate,
            'receipt_type'=>$request->receipttype,
            'remark'=>$request->remark,
            // 'file'=>$file,
            'date'=>$request->date
        ]);


            $assettype                  = $request['assettype'];
            $assetcode                  = $request['assetcode'];
            $assetname                  = $request['assetname'];
            $operator                   = $request['simname'];
            $phone                      = $request['simnumber'];

            for($i=0;$i<count($assetcode);$i++){
                $addasset=[
                    'doc_id'            =>$asset->id,
                    'department'        =>$asset->department,
                    'branch'            =>$asset->branch_code,
                    'assettype'         =>$assettype[$i],
                    'assetcode'         =>$assetcode[$i],
                    'assetname'         =>$assetname[$i],
                    'operator'          =>$operator[$i],
                    'ph'                =>$phone[$i],
                ];

                DB::table('asset_types')->insert($addasset);

            }

        if(isset($request['file']))

                    foreach($request['file'] as $file)
                    {

                        $folderName = "public/asset_upload";
                        $fileName = $file->getClientOriginalName();
                        $originalFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '',$fileName);
                        $savedFileName = $originalFileName.$file->getClientOriginalExtension();
                        $file->storeAs($folderName,$savedFileName);
                        $data_image                 =[
                            'doc_id'                =>$asset->id,
                            'file'                  =>$savedFileName,

                            'created_at'            =>Carbon::now(),
                            'updated_at'            =>Carbon::now(),
                        ];

                        DB::table('assetfiles')->insert($data_image);

                    }


        return redirect('employee_benefic/laptop_asset_code/'.$asset->id)->with('success','Successfully your created.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $datas=LaptopAssetCode::find($id);
        $branches=Branch::all();
        $files= Assetfile::where('doc_id',$id)->get();
        $addassets= AssetType::where('doc_id',$id)->get();
        $departments=Department::all();
        return view('laptop_asset_code.detail',compact('datas','branches','departments','files','addassets'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LaptopAssetCode $laptopAssetCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        // $request->validate([
        //     'file' => 'mimes:jpeg,jpg,png,gif,webp|max:3300',
        // ], [
        //     'file.mimes' => 'Only jpeg, jpg, png, webp, and gif file types are allowed.',
        //     'file.max' => 'File size should not exceed 3MB.',
        // ]);



        $datas=LaptopAssetCode::find($id);
        $datas->doc_no=$request->doc_no;
        $datas->type=$request->type;

        if($request->type=='Emp'){
            $datas->emp_name=$request->empname;
            $datas->emp_code=$request->empcode;
        }else{
            $datas->emp_name='';
            $datas->emp_code='';
        }

        $datas->branch_code=$request->branchcode;
        $datas->branch_name=$request->branchname;
        $datas->department=$request->department;
        $datas->receipt_type=$request->receipttype;
        $datas->receipt_date=$request->receiptdate;
        $datas->remark=$request->remark;
        $datas->date=$request->date;


        $datas->update();

        if(isset($request['file']))

        foreach($request['file'] as $file)
        {

            $folderName = "public/asset_upload";
            $fileName = $file->getClientOriginalName();
            $originalFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '',$fileName);
            $savedFileName = $originalFileName.$file->getClientOriginalExtension();
            $file->storeAs($folderName,$savedFileName);
            $data_image                 =[
                'doc_id'                =>$datas->id,
                'file'                  =>$savedFileName,

                'created_at'            =>Carbon::now(),
                'updated_at'            =>Carbon::now(),
            ];

            DB::table('assetfiles')->insert($data_image);

        }

        return back()->with('success','successfully updated...');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       //
    }

    public function deletRecord($id){
        // dd('hi');
        LaptopAssetCode::find($id)->delete($id);
        return back()->with('success','Successfully Deleted.');

    }

    public function deletasset($id){
        // dd('hi');
        AssetType::find($id)->delete($id);
        return back()->with('success','Successfully Deleted.');

    }

    public function deletRemark($id){

        $remark = Remark::find($id);
        if($remark){
            $remark->delete();
            return response()->json(['message' => 'Successfully Deleted'], 200);
        }else{

        }
        return respose()->json(['messagge'=>'Operator and Contract not found',404]);

    }

    public function deleteOperator($id)
    {
        $operator = Operator::find($id);

        // dd($operator);

        if ($operator) {
            $operator->delete();
            return response()->json(['message' => 'Successfully Deleted'], 200);
        } else {
            return response()->json(['message' => 'Operator not found'], 404);
        }
    }


    public function deletUpload($id){
        // dd('hi');
        Assetfile::find($id)->delete($id);
        return back()->with('success','Successfully Deleted.');

    }

    public function search1(Request $request)
    {
        $branches = Branch::all();
        $departments = Department::all();
        $query = LaptopAssetCode::query();
        $branch = $request->branch;

        // Apply search filters
        if ($branch != 0) {
            $query->where('branch_name', $branch);
        }

        if ($request->filled('doc_no')) {
            $query->where('doc_no', 'LIKE', '%' . $request->input('doc_no') . '%');
        }

        if ($request->filled('assettype')) {
            $query->where('asset_type', 'LIKE', '%' . $request->input('assettype') . '%');
        }

        if ($request->filled('empname')) {
            $query->where('emp_name', 'LIKE', '%' . $request->input('empname') . '%');
        }

        if ($request->filled('empcode')) {
            $query->where('emp_code', 'LIKE', '%' . $request->input('empcode') . '%');
        }

        if ($request->filled('department')) {
            $query->where('department', 'LIKE', '%' . $request->input('department') . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', 'LIKE', '%' . $request->input('type') . '%');
        }

        if ($branch == 0) {
            $query->latest();
        }

        if ($request->filled('laptop')) {
            $query->where(function ($query) use ($request) {
                $query->orWhere('laptop_asset_code', 'LIKE', '%' . $request->input('laptop') . '%')
                    ->orWhere('handset_asset_code', 'LIKE', '%' . $request->input('laptop') . '%')
                    ->orWhere('sim_phone', 'LIKE', '%' . $request->input('laptop') . '%');
            });
        }

        // Export to Excel
        if ($request->filled('export') && $request->input('export') === 'excel') {
            $exportFileName = 'laptop_asset_code_export.xlsx';

            // Export the query results directly
            return Excel::download(function () use ($query) {
                return $query->get();
            }, $exportFileName);
        }

        $datas = $query->latest()->paginate(20);

        return view('laptop_asset_code.index', compact('datas', 'branches', 'departments'));
    }


    public function search(Request $request)
{
    $branches = Branch::all();
    $departments = Department::all();
    $query = LaptopAssetCode::query();
    $branch = $request->branch;

    if ($branch != 0) {
        $query->where('branch_name', $branch);
    }

    if ($request->filled('doc_no')) {
        $query->where('doc_no', 'LIKE', '%' . $request->input('doc_no') . '%');
    }

    if ($request->filled('assettype')) {
        $query->where('asset_type', 'LIKE', '%' . $request->input('assettype') . '%');
    }

    if ($request->filled('empname')) {
        $query->where('emp_name', 'LIKE', '%' . $request->input('empname') . '%');
    }

    if ($request->filled('empcode')) {
        $query->where('emp_code', 'LIKE', '%' . $request->input('empcode') . '%');
    }

    if ($request->filled('department')) {
        $query->where('department', 'LIKE', '%' . $request->input('department') . '%');
    }

    if ($request->filled('type')) {
        $query->where('type', 'LIKE', '%' . $request->input('type') . '%');
    }

    if ($branch == 0) {
        $query->latest();
    }

    if ($request->filled('laptop')) {
        $query->where(function ($query) use ($request) {
            $query->orWhere('laptop_asset_code', 'LIKE', '%' . $request->input('laptop') . '%')
                ->orWhere('handset_asset_code', 'LIKE', '%' . $request->input('laptop') . '%')
                ->orWhere('sim_phone', 'LIKE', '%' . $request->input('laptop') . '%');
        });
    }



    // Export to Excel
    if ($request->filled('export') && $request->input('export') === 'excel') {
        $exportFileName = 'employee_asset_system.xlsx';

        // Export the query results directly
        return Excel::download(function () use ($query) {
            return $query->get();
        }, $exportFileName);
    }

    $datas = $query->latest()->paginate(20);

    return view('laptop_asset_code.index', compact('datas', 'branches', 'departments'));
}


    public function export(Request $request)
        {
            $query = $this->buildSearchQuery($request); // Create a method to build the query

            $exportFileName = 'laptop_asset_code_export.xlsx';
            return Excel::download(new \App\Exports\LaptopAssetCodeExport($query), $exportFileName);

        }

    private function buildSearchQuery(Request $request)
    {
        $query = LaptopAssetCode::query();

        return $query;
    }




    public function branchSearch($branch_code) {
        // Find the branch based on the provided branch_code
        $branch = Branch::where('branch_code', $branch_code)->first();

        if (!$branch) {
            return response()->json(['message' => 'Branch not found'], 404);
        }

        // Retrieve the branch_name for the found branch
        $branchName = $branch->branch_name;

        return response()->json(['branch_name' => $branchName], 200);
    }

    public function empIDsearch($emp_id){
        $conn    = DB::connection('Hremployee');
        $data = $conn->select("
        SELECT emp.employeecode, emp.employeename, brch.branch_code, brch.branch_name
        FROM hremployee.employee emp
        left join master_data.master_branch brch on brch.branch_code = emp.brchcode
        where emp.employeecode = '$emp_id'");

        if(!empty($data)){
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        }else{
            return response()->json([
                'status' => 'fail'
            ]);
        }
    }

    public function assetCodesearch($asset_code2){
        $conn    = DB::connection('Fixasset');
        $data = $conn->select("
        select fxassetdetailcode, fxassetdetailname
        from asset.fxassetdetail
        where fxassetdetailcode = '$asset_code2'");

        if(!empty($data)){
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        }else{
            return response()->json([
                'status' => 'fail'
            ]);
        }
    }


    public function paginateData(Request $request) {
        $perPage = $request->input('per_page', 10);
        $branches = Branch::all();
        $departments = Department::all();
        $datas = LaptopAssetCode::paginate($perPage);

        return view('laptop_asset_code.index', [
            'datas' => $datas,
            'branches' => $branches,
            'departments' => $departments
        ]);
    }


    public function fix_asset(Request $asset_code) {
        $conn = DB::connection('Fixasset');
        $departments=Department::all();
        $branches=Branch::all();
        $branch_id=Auth::user()->getBranch->branch_code;
        // dd($branch_id);
        if(Auth::user()->type=='Manager'){
            $query = "SELECT
            fxdt.fxbranchcode AS branch_code, fxbr.fxbranchname AS branch_name, fxdp.fxdepartmentname AS department, fxtp.fxassettypename AS asset_type_name,
            fxdt.fxassetdetailcode AS asset_code, fxdt.fxassetdetailname AS asset_name, fxdt.fxdatebuy AS purchase_date, fxdt.fxenddatecal AS stop_cal_date,
            case
            when fxdt.fxstatus = 'C' then 'Cancelled'
            when fxdt.fxstatus = 'T' then 'Transfered'
            when fxdt.fxstatus = 'S' then 'Sold'
            else 'Ongoing'
            end AS status
            FROM asset.fxassetdetail fxdt
            LEFT JOIN asset.fxbranch fxbr ON fxdt.fxbranchcode = fxbr.fxbranchcode
            LEFT JOIN asset.fxdepartment fxdp ON fxdt.fxdepartmentcode = fxdp.fxdepartmentcode
            LEFT JOIN asset.fxassetgroup fxgp ON fxgp.fxassettypecode = fxdt.fxassettypecode
            LEFT JOIN asset.fxassettype fxtp ON fxtp.fxassettypecode = fxdt.fxassettypecode
            LEFT JOIN asset.fxassetcategory fxct ON fxct.fxassetcategorycode = fxdt.fxassetcategorycode
            LEFT JOIN asset.fxassetsale fxsa ON fxsa.fxassetdetailcode = fxdt.fxassetdetailcode
            LEFT JOIN asset.fxassettransfer fxtf ON fxtf.fxassetdetailcode = fxdt.fxassetdetailcode
            WHERE fxtp.fxassettypename IN ('Laptop', 'Handset')
            ORDER BY purchase_date";

            $fix_assets = collect($conn->select($query));
            }elseif($branch_id){
                $query = "SELECT
                fxdt.fxbranchcode AS branch_code, fxbr.fxbranchname AS branch_name, fxdp.fxdepartmentname AS department, fxtp.fxassettypename AS asset_type_name,
                fxdt.fxassetdetailcode AS asset_code, fxdt.fxassetdetailname AS asset_name, fxdt.fxdatebuy AS purchase_date, fxdt.fxenddatecal AS stop_cal_date,
                case
                when fxdt.fxstatus = 'C' then 'Cancelled'
                when fxdt.fxstatus = 'T' then 'Transfered'
                when fxdt.fxstatus = 'S' then 'Sold'
                else 'Ongoing'
                end AS status
                FROM asset.fxassetdetail fxdt
                LEFT JOIN asset.fxbranch fxbr ON fxdt.fxbranchcode = fxbr.fxbranchcode
                LEFT JOIN asset.fxdepartment fxdp ON fxdt.fxdepartmentcode = fxdp.fxdepartmentcode
                LEFT JOIN asset.fxassetgroup fxgp ON fxgp.fxassettypecode = fxdt.fxassettypecode
                LEFT JOIN asset.fxassettype fxtp ON fxtp.fxassettypecode = fxdt.fxassettypecode
                LEFT JOIN asset.fxassetcategory fxct ON fxct.fxassetcategorycode = fxdt.fxassetcategorycode
                LEFT JOIN asset.fxassetsale fxsa ON fxsa.fxassetdetailcode = fxdt.fxassetdetailcode
                LEFT JOIN asset.fxassettransfer fxtf ON fxtf.fxassetdetailcode = fxdt.fxassetdetailcode
                WHERE fxtp.fxassettypename IN ('Laptop', 'Handset')
                AND fxbr.fxbranchcode = :fxbranchcode
                ORDER BY purchase_date";

                $fix_assets = collect($conn->select($query, ['fxbranchcode' => $branch_id]));
                }
                $operators=Operator::all();
                return view('laptop_asset_code.fix_asset', compact('fix_assets','departments','branches','operators'));
    }

    public function reMark(Request $request)
    {
        // dd($request->all());
        $asset_code = $request->asset_code;
        $department = $request->department;
        $branch = $request->branch;
        $asset_name = $request->asset_name;
        $asset_type = $request->asset_type;

        Remark::create([
            'asset_code' => $request->input('asset_code'),
            'rank' => $request->input('rank'),
            'contract' => $request->input('contract'),
            'remark' => $request->input('remark'),
        ]);

        for ($i = 0; $i < count($request->phone); $i++) {
            $addasset = [
                'asset_code' => $asset_code,
                'department' => $department,
                'branch'     => $branch,
                'asset_name' => $asset_name,
                'asset_type' => $asset_type,
                'operator'   => $request->operator[$i],
                'phone'      => $request->phone[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('operators')->insert($addasset);
        }

        return back()->with('success', 'Data inserted successfully!');
    }

    public function OpNew(Request $request)
    {
        // dd($request->all());
        $asset_code = $request->asset_code;
        $department = $request->department;
        $branch = $request->branch;
        $asset_name = $request->asset_name;
        $asset_type = $request->asset_type;

        for ($i = 0; $i < count($request->phone); $i++) {
            $addasset = [
                'asset_code' => $asset_code,
                'department' => $department,
                'branch' => $branch,
                'asset_name' => $asset_name,
                'asset_type' => $asset_type,
                'operator' => $request->operator[$i],
                'phone' => $request->phone[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('operators')->insert($addasset);
        }

        return back()->with('success', 'Data inserted successfully!');
    }



    public function updateRemark($id, Request $request){
        Remark::where('id', $id)->update($request->all());
        $data = Remark::whereId($id)->first();
        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function updatestore(Request $request)
    {
            // dd($request->all());
            $id=$request->getID;
            $branch_code=$request->branch_code;
            $department=$request->department;
            $validatedData = $request->validate([
                'assettype.*' => 'required',
                'assetname.*' => 'required',
                'assetcode.*' => 'required',
            ],[
                'assettype.*.required' => 'Asset type ရွေးချယ်ရန်လိုပါသည်။ (Please select at least one Asset type.)',
                'assetname.*.required' => 'Asset Code ရွေးချယ်ရန်လိုပါသည်။ (Please select at least one Asset code.)',
                'assetcode.*.required' => 'Asset Name ရွေးချယ်ရန်လိုပါသည်။ (Please select at least one Asset name.)',

            ]

        );

            // dd($id);
            $assettype                  = $request['assettype'];
            $assetcode                  = $request['assetcode'];
            $assetname                  = $request['assetname'];
            $operator                   = $request['simname'];
            $phone                      = $request['simnumber'];

            for($i=0;$i<count($assetcode);$i++){
                $addasset=[
                    'doc_id'            =>$id,
                    'assettype'         =>$assettype[$i],
                    'department'        =>$department,
                    'branch'            =>$branch_code[$i],
                    'assetcode'         =>$assetcode[$i],
                    'assetname'         =>$assetname[$i],
                    'operator'          =>$operator[$i],
                    'ph'                =>$phone[$i],
                ];

                DB::table('asset_types')->insert($addasset);

            }

        if(isset($request['file']))

                    foreach($request['file'] as $file)
                    {

                        $folderName = "public/asset_upload";
                        $fileName = $file->getClientOriginalName();
                        $originalFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '',$fileName);
                        $savedFileName = $originalFileName.$file->getClientOriginalExtension();
                        $file->storeAs($folderName,$savedFileName);
                        $data_image                 =[
                            'doc_id'                =>$id,
                            'file'                  =>$savedFileName,

                            'created_at'            =>Carbon::now(),
                            'updated_at'            =>Carbon::now(),
                        ];

                        DB::table('assetfiles')->insert($data_image);

                    }



        // return back()->with('success','Successfully your created.');
        return back()->with('success','Successfully your created.');
    }

    public function search_asset_code(Request $request)
    {
        $asset_code = $request->asset_code;
        $conn = DB::connection('Fixasset');
        $query = $conn->select("SELECT fxdt.fxbranchcode AS branch_code, fxbr.fxbranchname AS branch_name, fxdp.fxdepartmentname AS department, fxtp.fxassettypename AS asset_type_name,
        fxdt.fxassetdetailcode AS asset_code, fxdt.fxassetdetailname AS asset_name, fxdt.fxdatebuy AS purchase_date, fxdt.fxenddatecal AS stop_cal_date, fxdt.fxstatus AS status
        FROM asset.fxassetdetail fxdt
        LEFT JOIN asset.fxbranch fxbr ON fxdt.fxbranchcode = fxbr.fxbranchcode
        LEFT JOIN asset.fxdepartment fxdp ON fxdt.fxdepartmentcode = fxdp.fxdepartmentcode
        LEFT JOIN asset.fxassetgroup fxgp ON fxgp.fxassettypecode = fxdt.fxassettypecode
        LEFT JOIN asset.fxassettype fxtp ON fxtp.fxassettypecode = fxdt.fxassettypecode
        LEFT JOIN asset.fxassetcategory fxct ON fxct.fxassetcategorycode = fxdt.fxassetcategorycode
        LEFT JOIN asset.fxassetsale fxsa ON fxsa.fxassetdetailcode = fxdt.fxassetdetailcode
        LEFT JOIN asset.fxassettransfer fxtf ON fxtf.fxassetdetailcode = fxdt.fxassetdetailcode
        WHERE fxdt.fxassetdetailcode ='$asset_code'");
        $remarks = getRemark($asset_code);
        $data = ['info'=>$query[0],'remarks'=>$remarks];

       return response()->json($data, 200);

    }

    public function fix_detail($asset_code)
    {
        $conn = DB::connection('Fixasset');
        $query = $conn->select("SELECT fxdt.fxbranchcode AS branch_code, fxbr.fxbranchname AS branch_name, fxdp.fxdepartmentname AS department, fxtp.fxassettypename AS asset_type_name,
        fxdt.fxassetdetailcode AS asset_code, fxdt.fxassetdetailname AS asset_name, fxdt.fxdatebuy AS purchase_date, fxdt.fxenddatecal AS stop_cal_date, fxdt.fxstatus AS status
        FROM asset.fxassetdetail fxdt
        LEFT JOIN asset.fxbranch fxbr ON fxdt.fxbranchcode = fxbr.fxbranchcode
        LEFT JOIN asset.fxdepartment fxdp ON fxdt.fxdepartmentcode = fxdp.fxdepartmentcode
        LEFT JOIN asset.fxassetgroup fxgp ON fxgp.fxassettypecode = fxdt.fxassettypecode
        LEFT JOIN asset.fxassettype fxtp ON fxtp.fxassettypecode = fxdt.fxassettypecode
        LEFT JOIN asset.fxassetcategory fxct ON fxct.fxassetcategorycode = fxdt.fxassetcategorycode
        LEFT JOIN asset.fxassetsale fxsa ON fxsa.fxassetdetailcode = fxdt.fxassetdetailcode
        LEFT JOIN asset.fxassettransfer fxtf ON fxtf.fxassetdetailcode = fxdt.fxassetdetailcode
        WHERE fxdt.fxassetdetailcode ='$asset_code'");
        // dd($query);
        $remark = getRemark($asset_code);
        $operators = getOperator($asset_code);
        return view('laptop_asset_code.fixasset_detail', compact('query','remark','operators'));
    }

    public function update_operator(Request $request,$id){
        $updateop=Operator::find($id);
        $updateop->operator=$request->operator;
        $updateop->phone=$request->phone;
        $updateop->update();
        return back()->with('success','Successfully your updated.');

    }


    public function update_contract(Request $request, $id) {
        $updatecon = Remark::find($id);

        if (!$updatecon) {
            return back()->with('error', 'Record not found.');
        }

        if ($request->contract === 'No' || $request->contract === 'Yes') {
            $updatecon->contract = $request->contract;
        } else {

            $updatecon->contract = $request->contract_edit;
        }

        $updatecon->rank = $request->rank;
        $updatecon->remark = $request->remark;
        $updatecon->save();

        return back()->with('success', 'Successfully updated.');
    }


    public function non_asset_operator(){
        $branch_id=Auth::user()->getBranch->branch_code;
        if(Auth::user()->type=='Manager'){
        $nonoperators = NonOperator::all();
        }elseif($branch_id){
            $nonoperators = NonOperator::where('branch', 'like', "%$branch_id%")->get();
        }
        $departments=Department::all();
        $branches=Branch::all();
        return view('laptop_asset_code.nonasset_operator',compact('nonoperators','branches','departments'));
    }

    public function nonasset_operator_create(){
        $departments=Department::all();
        $branches=Branch::all();
        return view('laptop_asset_code.nonasset_op_create',compact('departments','branches'));
    }

    public function NonOpCreate(Request $request)
    {

        // dd($request->all());
        $date = Carbon::parse($request->date)->format('Ymd');


        $today = NonRemark::whereDate('created_at', Carbon::today())->distinct('doc_no')->get();
        $suffix = $today->isEmpty() ? 1 : $today->count() + 1;

        $data = sprintf("%'.04d", $suffix);

        $doc_no = 'NASOP' . $date . '-' . $data;
        // dd($doc_no);

        $nonremark = NonRemark::create([
            'doc_no' => $doc_no,
            'emp_id' => $request->emp_id,
            'branch' => $request->branch,
            'department' => $request->department,
            'name' => $request->name,
            'contract' => $request->contract,
            'remark' => $request->remark,
            'rank' => $request->rank,
            'date' => $request->date,
        ]);


        $operators = $request->operator;
        $phones = $request->phone;

        foreach ($phones as $i => $phone) {
            $addnon = [
                'doc_no' => $nonremark->doc_no,
                'branch' => $nonremark->branch,
                'department' => $nonremark->department,
                'operator' => $operators[$i],
                'phone' => $phone,
                'created_at' => now(),
                'updated_at' => now(),
            ];


            NonOperator::create($addnon);
        }

        return redirect('detail_non_asset_code/'.$nonremark->doc_no);
    }

    public function deletRecordNon($id){
        // dd('hi');
        NonOperator::find($id)->delete($id);
        return back()->with('success','Successfully Deleted.');

    }

    public function getEditnonOp($doc_no){

        $getnonRemark=getnonRemark($doc_no);
        $getnonOperator=getnonOperator($doc_no);
        return view('laptop_asset_code.nonasset_operator_detail',compact('getnonOperator','getnonRemark'));
    }

    public function OpNonNew(Request $request)
    {
        // dd($request->all());
        $doc_no = $request->doc_no;
        $phone = $request->phone;
        $name = $request->name;
        $department = $request->department;
        $branch = $request->branch;

        for ($i = 0; $i < count($request->phone); $i++) {
            $addnon = [
                'doc_no' => $doc_no,
                'department' => $department,
                'branch' => $branch,
                'operator' => $request->operator[$i],
                'phone' => $request->phone[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('non_operators')->insert($addnon);
        }

        return back()->with('success', 'Data inserted successfully!');
    }

    public function update_operator_non(Request $request,$id){
        $updateop=NonOperator::find($id);
        $updateop->operator=$request->operator;
        $updateop->phone=$request->phone;
        $updateop->update();
        return back()->with('success','Successfully your updated.');
    }


    public function update_contract_non(Request $request, $id) {
        $updatecon = NonRemark::find($id);

        if (!$updatecon) {
            return back()->with('error', 'Record not found.');
        }

        if ($request->contract === 'No' || $request->contract === 'Yes') {
            $updatecon->contract = $request->contract;
        } else {

            $updatecon->contract = $request->contract_edit;
        }

        $updatecon->rank = $request->rank;
        $updatecon->remark = $request->remark;
        $updatecon->save();

        return back()->with('success', 'Successfully updated.');
    }

    public function deletRemarknon($id)
    {

        // dd('hi');
        $remark = NonRemark::find($id);

        if ($remark) {
            $remark->delete();
            return response()->json(['message' => 'Successfully Deleted', 'redirect' => route('laptop_asset_code.nonasset_operator')], 200);
        }

        return response()->json(['message' => 'Record not found'], 404);
    }


    public function deleteOperatornon($id)
    {
        $operator = NonOperator::find($id);

        // dd($operator);

        if ($operator) {
            $operator->delete();
            return response()->json(['message' => 'Successfully Deleted'], 200);
        } else {
            return response()->json(['message' => 'Operator not found'], 404);
        }
    }



}
