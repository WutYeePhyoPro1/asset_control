<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use App\Models\Department;
use App\Models\LaptopAssetCode;
use App\Models\AssetHistory;
use App\Models\FixAsset;
use App\Models\MasterSim;
use App\Models\NonOperator;
use App\Models\NonRemark;
use App\Models\Remark;
use App\Models\Operator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LaptopAssetCodeController extends Controller
{
    public function deletRecord($id)
    {
        // dd('hi');
        LaptopAssetCode::find($id)->delete($id);
        return back()->with('success', 'Successfully Deleted.');
    }

    public function deletRemark($id)
    {

        $remark = Remark::find($id);
        if ($remark) {
            $remark->delete();
            return response()->json(['message' => 'Successfully Deleted'], 200);
        } else {
        }
        return response()->json(['messagge' => 'Operator and Contract not found', 404]);
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


    public function search_employee(Request $request)
    {
        $validated = $request->validate([
            'employee_data' => ['required', 'string', 'max:100'],
        ]);

        $employeeData = trim($validated['employee_data']);
        $searchTerm = '%' . $employeeData . '%';
        $bindings = [
            'employee_id' => $searchTerm,
            'employee_name' => $searchTerm,
        ];

        $conn = DB::connection('Hremployee');
        $users = $conn->select("
            SELECT
                emp.employeecode AS emp_id,
                emp.employeename AS name,
                emp.positionlevel AS rank,
                emp.department AS department,
                emp.sub_department AS sub_department,
                emp.section AS section,
                emp.brchcode AS branch_code,
                brch.branch_name
            FROM hremployee.all_employee emp
            LEFT JOIN master_data.master_branch brch
                ON brch.branch_code = emp.brchcode
            WHERE (emp.employeecode ILIKE :employee_id
               OR emp.employeename ILIKE :employee_name
               )
            ORDER BY emp.employeename
            LIMIT 20
        ", $bindings);

        return response()->json([
            'status' => 'success',
            'data' => $users,
        ]);
    }

    public function fix_asset()
    {
        $branch_id = Auth::user()->getBranch->branch_code;

        /** @var \App\Models\User $user */

        $user = Auth::user();
        $hasMultiBranchAccess = $user->hasRole('manager')
            || (string) Auth::user()->emp_code === '000-000627';
        $accessibleBranchCodes = ['MM-505', 'MM-510', 'MM-511'];
        $departments = Department::all();
        $branches = $user->hasRole('manager')
            ? Branch::all()
            : ((string) $user->emp_code === '000-000627'
                ? Branch::whereIn('branch_code', ['MM-505', 'MM-510', 'MM-511'])->get()
                : ($user->branch_id
                    ? Branch::where('id', $user->branch_id)->get()
                    : Branch::all()));
        $assetsQuery = FixAsset::query()->orderBy('purchase_date');

        if (!$hasMultiBranchAccess) {
            $assetsQuery->where('branch_code', $branch_id);
        } elseif (!$user->hasRole('manager')) {
            $assetsQuery->whereIn('branch_code', $accessibleBranchCodes);
        }

        $assets = $assetsQuery->get();
        $assetPaginator = null;
        $branchNames = Branch::query()->pluck('branch_name', 'branch_code');
        $remarks = Remark::whereIn('asset_code', $assets->pluck('asset_code'))
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->get()
            ->unique('asset_code')
            ->keyBy('asset_code');

        $fix_assets = $assets->map(function ($asset) use ($remarks, $branchNames) {
            $remark = $remarks->get($asset->asset_code);

            return [
                'asset_code'      => $asset->asset_code,
                'branch_name'     => $remark?->branch_name,
                'department'      => $remark?->department,
                'sub_department'  => $remark?->sub_department,
                'asset_type_name' => $asset->asset_type_name,
                'asset_name'      => $asset->asset_name,
                'purchase_date'   => $asset->purchase_date,
                'stop_cal_date'   => $asset->stop_cal_date,
                'status'          => $asset->status,
                'employee_id'     => $remark?->emp_id,
                'employee_name'   => $remark?->emp_name,
                'contract'        => $remark?->contract,
                'remark'          => $remark?->remark,
            ];
        });

        $operatorsByAsset = Operator::query()
            ->whereIn('asset_code', $assets->pluck('asset_code'))
            ->orderByDesc('id')
            ->get()
            ->groupBy('asset_code');

        

        return view('laptop_asset_code.fix_asset', array_merge(
            compact(
                'fix_assets',
                'departments',
                'branches',
                'operatorsByAsset',
                'assetPaginator'
            ),
            ['minimalAssets' => true]
        ));
    }

    public function refreshFixAssets()
    {
        $conn = DB::connection('Fixasset');
        $departments = Department::all();
        $branches = Branch::all();
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $branch_id = $user->getBranch->branch_code;
        $hasMultiBranchAccess = $user->hasRole('manager')
            || (string) $user->emp_code === '000-000627';
        $accessibleBranchCodes = ['MM-505', 'MM-510', 'MM-511'];
        $fix_assets = collect();
        if ($user->hasRole('manager')) {
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
        } else {
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
                    AND fxbr.fxbranchcode IN (?, ?, ?)
                    ORDER BY purchase_date";

            if ($hasMultiBranchAccess) {
                $fix_assets = collect($conn->select($query, $accessibleBranchCodes));
            } elseif ($branch_id) {
                $query = str_replace('AND fxbr.fxbranchcode IN (?, ?, ?)', 'AND fxbr.fxbranchcode = ?', $query);
                $fix_assets = collect($conn->select($query, [$branch_id]));
            }
        }


        $fix_assets->each(function ($asset) {
            FixAsset::updateOrCreate(
                ['asset_code' => $asset->asset_code],
                [
                    'branch_code' => $asset->branch_code,
                    'branch_name' => $asset->branch_name,
                    'department' => $asset->department,
                    'asset_type_name' => $asset->asset_type_name,
                    'asset_name' => $asset->asset_name,
                    'purchase_date' => $asset->purchase_date,
                    'stop_cal_date' => $asset->stop_cal_date,
                    'status' => $asset->status,
                ]
            );

            AssetHistory::updateOrCreate(
                [
                    'asset_code' => $asset->asset_code,
                    'asset_name' => $asset->asset_name
                ]
            );
        });

        // for user asset history(from helper.php)
        syncAssetHistory();

        return redirect()->route('laptop_asset_code.fix_asset');
    }

    // fix asset update data

    public function reMark(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'emp_id' => ['required', 'string', 'max:100'],
            'emp_name' => ['required', 'string', 'max:255'],
            'employee_branch_code' => ['required', 'string', 'max:255'],
            'employee_department' => ['required', 'string', 'max:255'],
            'employee_sub_department' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'array'],
            'phone.*' => ['nullable', 'regex:/^09(?:\d{9})?$/'],
        ], [
            'emp_id.required' => 'Please search and select an employee.',
            'emp_name.required' => 'Please search and select an employee.',
            'phone.*.regex' => 'Phone number must start with 09 and contain 11 digits.',
        ]);

        $asset_code = $request->asset_code;
        $department = $request->department;
        $branch = $request->branch;
        $asset_name = $request->asset_name;
        $asset_type = $request->asset_type;

        Remark::create([
            'asset_code' => $request->input('asset_code'),
            'emp_id' => $request->input('emp_id'),
            'branch_code' => $request->input('employee_branch_code'),
            'emp_name' => $request->input('emp_name'),
            'rank' => $request->input('rank'),
            'branch_name' => Branch::where('branch_code', $request->input('employee_branch_code'))->value('branch_name'),
            'department' => $request->input('employee_department'),
            'sub_department' => $request->input('employee_sub_department'),
            'contract' => $request->input('contract'),
            'remark' => $request->input('remark'),
        ]);

        for ($i = 0; $i < count($request->phone); $i++) {
            $phone = trim((string) ($request->phone[$i] ?? ''));
            $savedPhone = $phone === '09' ? null : $phone;

            $addasset = [
                'asset_code' => $asset_code,
                'department' => $department,
                'branch'     => $branch,
                'asset_name' => $asset_name,
                'asset_type' => $asset_type,
                'operator'   => $request->operator[$i],
                'phone'      => $savedPhone,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('operators')->insert($addasset);
            $this->markMasterSimAsUsed($savedPhone);
        }

        return back()->with('success', 'Successfully saved.');
    }

    public function OpNew(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'phone' => ['required', 'array'],
            'phone.*' => ['nullable', 'regex:/^09(?:\d{9})?$/'],
        ], [
            'phone.*.regex' => 'Phone number must start with 09 and contain 11 digits.',
        ]);

        $asset_code = $request->asset_code;
        $department = $request->department;
        $branch = $request->branch;
        $asset_name = $request->asset_name;
        $asset_type = $request->asset_type;

        for ($i = 0; $i < count($request->phone); $i++) {
            $phone = trim((string) ($request->phone[$i] ?? ''));
            $savedPhone = $phone === '09' ? null : $phone;

            $addasset = [
                'asset_code' => $asset_code,
                'department' => $department,
                'branch' => $branch,
                'asset_name' => $asset_name,
                'asset_type' => $asset_type,
                'operator' => $request->operator[$i],
                'phone' => $savedPhone,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('operators')->insert($addasset);

            // A number not found in Master SIM is still allowed to save.
            $this->markMasterSimAsUsed($savedPhone);
        }

        return back()->with('success', 'Data inserted successfully!');
    }

    private function markMasterSimAsUsed(?string $phone): void
    {
        if ($phone === null || $phone === '') {
            return;
        }

        MasterSim::query()
            ->where('simcard', $phone)
            ->whereRaw('LOWER(type) = ?', ['available'])
            ->update(['type' => 'used']);
    }



    public function updateRemark($id, Request $request)
    {
        Remark::where('id', $id)->update($request->all());
        $data = Remark::whereId($id)->first();
        return response()->json(['success' => true, 'data' => $data], 200);
    }

    public function updatestore(Request $request)
    {
        // dd($request->all());
        $id = $request->getID;
        $branch_code = $request->branch_code;
        $department = $request->department;
        $validatedData = $request->validate(
            [
                'assettype.*' => 'required',
                'assetname.*' => 'required',
                'assetcode.*' => 'required',
            ],
            [
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

        for ($i = 0; $i < count($assetcode); $i++) {
            $addasset = [
                'doc_id'            => $id,
                'assettype'         => $assettype[$i],
                'department'        => $department,
                'branch'            => $branch_code[$i],
                'assetcode'         => $assetcode[$i],
                'assetname'         => $assetname[$i],
                'operator'          => $operator[$i],
                'ph'                => $phone[$i],
            ];

            DB::table('asset_types')->insert($addasset);
        }

        if (isset($request['file']))

            foreach ($request['file'] as $file) {

                $folderName = "public/asset_upload";
                $fileName = $file->getClientOriginalName();
                $originalFileName = preg_replace('/\\.[^.\\s]{3,4}$/', '', $fileName);
                $savedFileName = $originalFileName . $file->getClientOriginalExtension();
                $file->storeAs($folderName, $savedFileName);
                $data_image                 = [
                    'doc_id'                => $id,
                    'file'                  => $savedFileName,

                    'created_at'            => Carbon::now(),
                    'updated_at'            => Carbon::now(),
                ];

                DB::table('assetfiles')->insert($data_image);
            }



        // return back()->with('success','Successfully your created.');
        return back()->with('success', 'Successfully your created.');
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
        $data = ['info' => $query[0], 'remarks' => $remarks];

        return response()->json($data, 200);
    }

    public function globalAssetSearch(Request $request)
    {
        $assetCode = trim((string) $request->input('asset_code'));

        if ($assetCode === '') {
            return back()->with('error', 'Please enter an asset code.');
        }

        $asset = FixAsset::on('pgsql')
            ->whereRaw('LOWER(asset_code) = ?', [strtolower($assetCode)])
            ->first();

        if (!$asset) {
            $asset = FixAsset::on('pgsql')
                ->whereRaw('LOWER(asset_code) LIKE ?', ['%' . strtolower($assetCode) . '%'])
                ->orderBy('asset_code')
                ->first();
        }

        if (!$asset) {
            return back()
                ->withInput()
                ->with('error', "Asset code '{$assetCode}' was not found.");
        }

        return redirect()->route('detail_fixasset', $asset->asset_code);
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

        $savedAssetTypeName = FixAsset::where('asset_code', $asset_code)->value('asset_type_name');
        if ($savedAssetTypeName !== null) {
            foreach ($query as $asset) {
                $asset->asset_type_name = $savedAssetTypeName;
            }
        }

        $remark = getRemark($asset_code);
        $operators = getOperator($asset_code);
        $assetHistories = AssetHistory::query()
            ->where('asset_code', $asset_code)
            ->orderBy('created_at')
            ->orderBy('id')
            ->get();
        $masterSims = MasterSim::query()
            ->whereRaw('LOWER(type) = ?', ['available'])
            ->orderBy('simcard')
            ->get(['simcard', 'type']);
        return view('laptop_asset_code.fixasset_detail', compact(
            'query',
            'remark',
            'operators',
            'assetHistories',
            'masterSims'
        ));
    }

    public function update_operator(Request $request, $id)
    {

        $request->validate([
            'phone' => ['nullable', 'regex:/^09(?:\d{9})?$/'],
        ], [
            'phone.regex' => 'Phone number must start with 09 and contain 11 digits.',
        ]);

        $updateop = Operator::find($id);
        $updateop->operator = $request->operator;
        $updateop->phone = $request->phone === '09' ? null : $request->phone;
        $updateop->update();
        return back()->with('success', 'Successfully updated.');
    }


    public function update_contract(Request $request, $id)
    {
        $request->validate([
            'asset_type_name' => ['required', 'string', 'max:255'],
        ]);

        $updatecon = Remark::find($id);

        if (!$updatecon) {
            return back()->with('error', 'Record not found.');
        }

        if ($request->contract === 'No' || $request->contract === 'Yes') {
            $updatecon->contract = $request->contract;
        } else {

            $updatecon->contract = $request->contract_edit;
        }

        // $updatecon->rank = $request->rank;
        $updatecon->remark = $request->remark;
        $updatecon->save();

        FixAsset::where('asset_code', $updatecon->asset_code)->update([
            'asset_type_name' => trim($request->asset_type_name),
        ]);

        return back()->with('success', 'Successfully updated.');
    }

    /**
     * Replace the employee currently assigned to an asset remark.
     */
    public function update_remark_employee(Request $request, $id)
    {
   
        $validated = $request->validate([
            'emp_id' => ['required', 'string', 'max:100'],
            'emp_name' => ['required', 'string', 'max:255'],
            'rank' => ['required', 'string', 'max:255'],
            'section' => ['nullable', 'string', 'max:255'],
            'sub_department' => ['nullable', 'string', 'max:255'],
            'branch_code' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'sub_department' => ['required', 'string', 'max:255'],
            'section' => ['required', 'string', 'max:255'],
        ], [
            'emp_id.required' => 'Please search and select an employee.',
            'emp_name.required' => 'Please search and select an employee.',
            'rank.required' => 'Please search and select an employee.',
            'branch_code.required' => 'Please search and select an employee.',
            'department.required' => 'Please search and select an employee.',
            'sub_department.required' => 'Please search and select an employee.',
            'section.required' => 'Please search and select an employee.',
        ]);

        $remark = Remark::findOrFail($id);
        $branchName = Branch::where('branch_code', $validated['branch_code'])->value('branch_name');
        $remark->update([
            'emp_id' => $validated['emp_id'],
            'branch_code' => $validated['branch_code'],
            'emp_name' => $validated['emp_name'],
            'rank' => trim($validated['rank']),
            'branch_name' => $branchName,
            'department' => $validated['department'],
            'sub_department' => trim($validated['section']) != 'Infrastructure' ? trim($validated['section']) : trim($validated['sub_department']),
        ]);

        return back()->with('success', 'Assigned employee updated successfully.');
    }


    public function non_asset_operator()
    {
        /** @var User $user */
        $user = Auth::user();
        $branch_id = $user->getBranch->branch_code;
        if ($user->hasRole('manager')) {
            $nonoperators = NonRemark::latest()->get();
        } elseif ($branch_id) {
            $nonoperators = NonRemark::where('branch', 'like', "%$branch_id%")->get();
        }
        $departments = Department::all();
        $branches = Branch::all();
        //
        return view('laptop_asset_code.nonasset_operator', compact('nonoperators', 'branches', 'departments'));
    }

    public function nonasset_operator_create()
    {
        $departments = Department::all();
        /** @var User $user */
        $user = Auth::user();
        $branches = $user->hasRole('manager')
            ? Branch::all()
            : ((string) $user->emp_code === '000-000627'
                ? Branch::whereIn('branch_code', ['MM-505', 'MM-510', 'MM-511'])->get()
                : ($user->branch_id
                    ? Branch::where('id', $user->branch_id)->get()
                    : collect()));
        return view('laptop_asset_code.nonasset_op_create', compact('departments', 'branches'));
    }

    public function NonOpCreate(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'phone' => ['required', 'array'],
            'phone.*' => ['required', 'regex:/^09\d{9}$/'],
            'section' => ['nullable', 'string', 'max:255'],
            'sub_department' => ['nullable', 'string', 'max:255'],
        ], [
            'phone.*.regex' => 'Phone number must start with 09 and contain 11 digits.',
        ]);

        $date = Carbon::parse($request->date)->format('Ymd');

        $today = NonRemark::whereDate('created_at', Carbon::today())->distinct('doc_no')->get();
        $suffix = $today->isEmpty() ? 1 : $today->count() + 1;

        $data = sprintf("%'.04d", $suffix);

        $doc_no = 'NASOP' . $date . '-' . $data;
        // dd($doc_no);

        $request->merge([
            'sub_department' => trim((string) $request->section) !== 'Infrastructure'
                ? trim((string) $request->section)
                : trim((string) $request->sub_department),
        ]);

        $nonremark = NonRemark::create([
            'doc_no' => $doc_no,
            'emp_id' => $request->emp_id,
            'branch' => $request->branch,
            'department' => $request->department,
            'sub_department' => $request->sub_department,
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
            $this->markMasterSimAsUsed($phone[$i]);
        }

        return redirect('detail_non_asset_code/' . $nonremark->doc_no);
    }

    public function deletRecordNon($id)
    {
        $nonRemark = NonRemark::findOrFail($id);

        // The list passes the NonRemark id. Remove its related operators first,
        // then remove the parent non-asset record.
        NonOperator::where('doc_no', $nonRemark->doc_no)->delete();
        $nonRemark->delete();

        return response()->json([
            'message' => 'Successfully deleted.',
            'redirect' => route('laptop_asset_code.nonasset_operator'),
        ]);
    }

    public function getEditnonOp($doc_no)
    {
        $getnonRemark = getnonRemark($doc_no);
        $getnonOperator = getnonOperator($doc_no);
        $masterSims = MasterSim::query()
            ->whereRaw('LOWER(type) = ?', ['available'])
            ->orderBy('simcard')
            ->get(['simcard', 'type']);

        return view('laptop_asset_code.nonasset_operator_detail', compact(
            'getnonOperator',
            'getnonRemark',
            'masterSims'
        ));
    }

    public function OpNonNew(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'phone' => ['required', 'array'],
            'phone.*' => ['required', 'regex:/^09\d{9}$/'],
        ], [
            'phone.*.regex' => 'Phone number must start with 09 and contain 11 digits.',
        ]);

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
                'phone' => $request->phone[$i] === '09' ? null : $request->phone[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            DB::table('non_operators')->insert($addnon);
        }

        return back()->with('success', 'Data inserted successfully!');
    }

    public function update_operator_non(Request $request, $id)
    {
        $request->validate([
            'phone' => ['nullable', 'regex:/^09(?:\d{9})?$/'],
        ], [
            'phone.regex' => 'Phone number must start with 09 and contain 11 digits.',
        ]);

        $updateop = NonOperator::find($id);
        $updateop->operator = $request->operator;
        $updateop->phone = $request->phone;
        $updateop->update();
        return back()->with('success', 'Successfully updated.');
    }


    public function update_contract_non(Request $request, $id)
    {
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

    /** Replace the employee currently assigned to a non-asset code. */
    public function update_non_remark_employee(Request $request, $id)
    {
        $validated = $request->validate([
            'emp_id' => ['required', 'string', 'max:100'],
            'emp_name' => ['required', 'string', 'max:255'],
            'rank' => ['required', 'string', 'max:255'],
            'section' => ['nullable', 'string', 'max:255'],
            'sub_department' => ['nullable', 'string', 'max:255'],
        ], [
            'emp_id.required' => 'Please search and select an employee.',
            'emp_name.required' => 'Please search and select an employee.',
            'rank.required' => 'Please search and select an employee.',
        ]);

        $request->merge([
            'sub_department' => trim((string) $request->section) !== 'Infrastructure'
                ? trim((string) $request->section)
                : trim((string) $request->sub_department),
        ]);

        $nonRemark = NonRemark::findOrFail($id);
        $nonRemark->update([
            'emp_id' => $validated['emp_id'],
            'name' => $validated['emp_name'],
            'rank' => $validated['rank'],
            'sub_department' => $request->sub_department,
        ]);

        return back()->with('success', 'Assigned employee updated successfully.');
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


    public function moveAsset(Request $request, $id)
    {
        // dd($nonRemark);
        $assetCode = $request->input('asset_code');

        $nonCode = $request->input('none_code');
        $non = NonOperator::where('doc_no', $nonCode)->get();
        // dd($non);
        // dd($nonRemark);
        $query = DB::connection('Fixasset')
            ->select("SELECT fxdt.fxbranchcode AS branch_code, fxbr.fxbranchname AS branch_name, fxdp.fxdepartmentname AS department, fxtp.fxassettypename AS asset_type_name,
            fxdt.fxassetdetailcode AS asset_code, fxdt.fxassetdetailname AS asset_name, fxdt.fxdatebuy AS purchase_date, fxdt.fxenddatecal AS stop_cal_date, fxdt.fxstatus AS status
            FROM asset.fxassetdetail fxdt
            LEFT JOIN asset.fxbranch fxbr ON fxdt.fxbranchcode = fxbr.fxbranchcode
            LEFT JOIN asset.fxdepartment fxdp ON fxdt.fxdepartmentcode = fxdp.fxdepartmentcode
            LEFT JOIN asset.fxassetgroup fxgp ON fxgp.fxassettypecode = fxdt.fxassettypecode
            LEFT JOIN asset.fxassettype fxtp ON fxtp.fxassettypecode = fxdt.fxassettypecode
            LEFT JOIN asset.fxassetcategory fxct ON fxct.fxassetcategorycode = fxdt.fxassetcategorycode
            LEFT JOIN asset.fxassetsale fxsa ON fxsa.fxassetdetailcode = fxdt.fxassetdetailcode
            LEFT JOIN asset.fxassettransfer fxtf ON fxtf.fxassetdetailcode = fxdt.fxassetdetailcode
            WHERE fxdt.fxassetdetailcode = '$assetCode'");

        if (count($query) > 0) {
            $nonRemark = NonRemark::find($id);
            // dd($nonRemark);
            if ($nonRemark) {
                $nonRemark->doc_no = $assetCode;
                $nonRemark->update();
            }


            if ($non->count() > 0) {
                foreach ($non as $item) {
                    $item->doc_no = $assetCode;
                    $item->update();
                }
            }

            return back()->with('success', 'Successfully updated.');
        } else {
            return back()->with('error', 'Your asset code does not exist in the Fixasset database.');
        }
    }
}
