<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    // TODO:
    protected $redirectTo = '/en/dashboard/orders';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // 'role' => 'required',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            // FIXME:

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user=User::create([
            // Only $fillable fields insert by Create method.  // FIXME: 
            // Most likely you are missing username in $fillable of your User model.The create method only accept fields coming from $fillable.
            // username added to saving table
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
            'role_id' => $data['role'],
            'restaurant' => $data['restaurant'],
            'restaurant_id' => $data['restaurant'],
        ]);

        $user->roles()->attach($data['role']);
        $user->restaurants()->attach($data['restaurant']);

        return $user;
    }
    // disable to show registration form
    public function showRegistrationForm()
    {
        $roles=\App\Role::orderBy('name')->pluck('name', 'id');
        // TODO: restaurant fetch added on registration page
        $restaurants=\App\Restaurant::orderBy('name')->pluck('name', 'id');
        return view('auth.register', compact('roles', 'restaurants'));
    }

    // public function register()
    // {

    // }
}
