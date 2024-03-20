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
            } else {
                // dd('hi');
                Auth::logout();
                return redirect()->back()->with('error', 'Your account is inactive.');
            }
        }

        return redirect()->back()->withErrors(['emp_id' => 'Invalid credentials.']);
    }
}
