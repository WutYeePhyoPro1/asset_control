<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\LaptopAssetCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        $users = User::latest()->paginate(10);
        return view('admin.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'name'=>'required',
            'department'=>'required',
            'emp_code' => 'required|unique:users',
            'status'=>'required',
            'password' => 'required|confirmed',
            'type'=>'required',
        ],['emp_code'=>'Employee ID has already been taken.']
    );
        

        $file=rand(0,999999)."_".$request->file('profile')->getClientOriginalName();
        $pathfile= Storage::putFileAs('public/profile',$request->file('profile'),$file);

        User::create([
            'profile'=>$file,
            'department' => $request['department'],
            'name' => $request['name'],
            'emp_code' => $request['emp_code'],
            'status' => $request['status'],
            'type' => $request['type'],
            'password' => Hash::make($request['password']),
            
        ]);

        return back()->with('success','Successfully saved...');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user=User::find($id);
        return view('admin.detail',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'profile' => 'mimes:jpeg,jpg,png,gif,webp|max:3300',
        ], [
            'profile.mimes' => 'Only jpeg, jpg, png, webp, and gif file types are allowed.',
            'profile.max' => 'File size should not exceed 3MB.',
        ]);

        $user=User::find($id);
        $user->name=$request->name;
        $user->emp_code=$request->emp_code;
        $user->department=$request->department;
        $user->status=$request->status;
        $user->type=$request->type;
        if($request->hasfile('profile'))
        {

            //dd("Testing True... ");
            
            $destnation ='app/public/profile/'.$user->file;
            if(Storage::exists($destnation)){
                unlink(storage_path('app/public/profile/'.$user->file));
            }

            //delete exisiting image
            //unlink(storage_path('app/public/iqnposimages/degree/'.$iqnstudents->degreefile));

            $file=rand(0,999999)."_".$request->file('profile')->getClientOriginalName();
            $pathfile= Storage::putFileAs('public/profile',$request->file('profile'),$file);

            $user->profile=$file;
        }else{
            $user->profile=$request->curr_file;
        }

       
        $user->update();

        return back()->with('success','successfully updated...');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::find($id)->delete($id);
        return back()->with('success','Successfully Deleted.');
    }

    public function search(Request $request)
    {

        $query = User::query();
    
        if ($request->filled('username')) {
            $query->where('name', 'LIKE', '%' . $request->input('username') . '%');
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
    
        if ($request->filled('status')) {
            $query->where('status', 'LIKE', '%' . $request->input('status') . '%');
        }
    
        $users = $query->latest()->paginate(20);
        // $datas->appends($request->all());
   
        return view('admin.index', compact('users'));
    }

    public function changePassword(Request $request,$id){
        $user=User::find($id);
        $user->password= Hash::make($request['password']);
        $user->update();
        return back()->with('success','successfully updated...');
    }


}
