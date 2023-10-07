<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\LaptopAssetCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class LaptopAssetCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas=LaptopAssetCode::latest()->paginate(20);
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
        // dd($request->all());
        $request->validate([
            'file' => 'required|mimes:jpeg,jpg,png,gif,webp|max:3300',
        ], [
            'file.required' => 'Employee profile is required.',
            'file.mimes' => 'Only jpeg, jpg, png,webp and gif file types are allowed.',
            'file.max' => 'File size should not exceed 3MB.',
        ]);
        
        $date = Carbon::parse($request->date)->format('Ymd');
        $today=LaptopAssetCode::where(['date'=>Carbon::parse($request->date)->format('Y-m-d'),'type'=>$request->type])->distinct('doc_no')->get();
        // $today = LaptopAssetCode::where(['date' => Carbon::parse($request->date)->format('Y-m-d')])->orderBy('id', 'DESC')->get();
        
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

        if($request){

        }
        

        $file=rand(0,999999)."_".$request->file('file')->getClientOriginalName();
        $pathfile= Storage::putFileAs('public/emp_profile',$request->file('file'),$file);
        
        $asset=LaptopAssetCode::create([
            'user_id'=>$request->userid,
            'doc_no'=>$doc_no,
            'type'=>$request->type,
            'emp_name'=>$request->empname,
            'emp_code'=>$request->empcode,
            'branch_code'=>$request->branchcode,
            'branch_name'=>$request->branchname,
            'department'=>$request->department,
            'asset_type'=>$request->assettype,
            'laptop_asset_code'=>$request->laptopcode,
            'laptop_asset_name'=>$request->laptopname,
            'handset_asset_code'=>$request->handsetcode,
            'handset_asset_name'=>$request->handsetname,
            'sim_name'=>$request->simname,
            'sim_phone'=>$request->simnumber,
            'receipt_date'=>$request->receiptdate,
            'receipt_type'=>$request->receipttype,
            'remark'=>$request->remark,
            'file'=>$file,
            'date'=>$request->date
        ]);

        // return back()->with('success','Successfully your created.');
        return redirect('employee_benefic/laptop_asset_code/'.$asset->id)->with('success','Successfully your created.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $datas=LaptopAssetCode::find($id);
        $branches=Branch::all();
        $departments=Department::all();
        return view('laptop_asset_code.detail',compact('datas','branches','departments'));
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
        $request->validate([
            'file' => 'mimes:jpeg,jpg,png,gif,webp|max:3300',
        ], [
            'file.mimes' => 'Only jpeg, jpg, png, webp, and gif file types are allowed.',
            'file.max' => 'File size should not exceed 3MB.',
        ]);
        

       
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
        $datas->asset_type=$request->assettype;
        $datas->laptop_asset_code=$request->laptopcode;
        $datas->laptop_asset_name=$request->laptopname;
        $datas->handset_asset_code=$request->handsetcode;
        $datas->handset_asset_name=$request->handsetname;
        $datas->sim_name=$request->simname;
        $datas->sim_phone=$request->simnumber;
        $datas->receipt_type=$request->receipttype;
        $datas->receipt_date=$request->receiptdate;
        $datas->remark=$request->remark;
        $datas->file=$request->file;
        $datas->date=$request->date;
        if($request->hasfile('file'))
        {

            //dd("Testing True... ");
            
            $destnation ='app/public/emp_profile/'.$datas->file;
            if(Storage::exists($destnation)){
                unlink(storage_path('app/public/emp_profile/'.$datas->file));
            }

            //delete exisiting image
            //unlink(storage_path('app/public/iqnposimages/degree/'.$iqnstudents->degreefile));

            $file=rand(0,999999)."_".$request->file('file')->getClientOriginalName();
            $pathfile= Storage::putFileAs('public/emp_profile',$request->file('file'),$file);

            $datas->file=$file;
        }else{
            $datas->file=$request->curr_file;
        }

       
        $datas->update();

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


public function search(Request $request)
{
        $branches=Branch::all();
        $departments=Department::all();
        $query = LaptopAssetCode::query();

        // if($request->branch!=null){
            $branch = $request->branch;
            if($request->branch !=0){
                $query = $query->where('branch_name',$branch);
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
        
            // if ($request->filled('branch')) {
            //     $query->where('branch_name', 'LIKE', '%' . $request->input('branch') . '%');
            // }

            if ($branch == 0) {
                $query=$query->latest();
            }

       
            if ($request->filled('laptop')) {
                $query->orwhere('laptop_asset_code', 'LIKE', '%' . $request->input('laptop') . '%')
                      ->orwhere('handset_asset_code', 'LIKE', '%' . $request->input('laptop') . '%')
                      ->orwhere('sim_phone', 'LIKE', '%' . $request->input('laptop') . '%');
            }
        
            $datas = $query->latest()->paginate(20);
            // $datas->appends($request->all());
       
            return view('laptop_asset_code.index', compact('datas','branches','departments'));
        // }
        // // else{
        // //     return back()->with('fails', 'No result Found');
        // // }
        
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
        $datas   = $conn->select("
        SELECT employeename FROM hremployee.all_employee
        where employeecode='$emp_id'
        ");

        if(!empty($datas)){
            return response()->json([
                'status' => 'success',
                'data' => $datas
            ]);
        }else{
            return response()->json([
                'status' => 'fail'
            ]);
        }
    }
}
