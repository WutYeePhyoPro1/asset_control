<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\LaptopAssetCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

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

        $datas=LaptopAssetCode::latest()->paginate(20);
        $branches=Branch::all();
        $departments=Department::all();
        return view('dashboard',compact('datas','branches','departments'));
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
