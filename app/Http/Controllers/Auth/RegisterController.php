<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Invite;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            // 'password' => [
            //                   'required',
            //                   'string',
            //                   'min:8',             // must be at least 10 characters in length
            //                   'regex:/[a-z]/',      // must contain at least one lowercase letter
            //                   'regex:/[A-Z]/',      // must contain at least one uppercase letter
            //                   'regex:/[0-9]/',      // must contain at least one digit
            //                   'regex:/[@$!%*#?&]/', // must contain a special character
            //                   'confirmed'
            //               ],
            'phone' => ['required'],
            'timezone' => ['required'],
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
        $invite = Invite::where('token', $data['token'])->first();
        $invite->delete();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'username' => $data['username'],
            'client_id' => $data['client_id'],
            'phone' => $data['phone'],
            'timezone' => $data['timezone'],
        ]);
        $user->assignRole('user');

        return $user;

    }

    protected function registered(Request $request, $user)
    {
        // set timezone
        if ($timezone = $this->getTimezone($request))
         {
            $user->timezone = $timezone;
            $user->save();
            // return  response()->json($request);
        }
    }

    protected function getTimezone(Request $request)
    {
        if ($timezone = $request->get('timezone')) {
            return $timezone;
        }
    }

}
