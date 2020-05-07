<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Auth;


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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected function authenticated(Request $request, $user)
    {
		$role_id=Auth::user()->role_id;
       if ( $role_id==1 || $role_id==2 || $role_id==9 || $role_id==11 || $role_id==12 || $role_id==13) {// do your margic here
             return redirect('admincheck');
        }

             return redirect('salesmancheck');
        }
   

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
