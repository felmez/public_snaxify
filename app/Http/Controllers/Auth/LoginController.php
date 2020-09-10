<?php

namespace App\Http\Controllers\Auth;

// you need these two line if you use logout by request
// use Auth;
// use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    // redirect to dashboard directly after success login TODO:
    protected $redirectTo = '/en/dashboard/orders';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    // no need to enable then while authenticated users redirection is on
    // public function logout(Request $request)
    // {
    //     Auth::logout();
    //     return redirect('/en/dashboard');
    // }
}
