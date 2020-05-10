<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Shareholder;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ShareholderRegisterController extends Controller
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
        $this->middleware('guest:shareholder');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $formatedPhone = str_replace('+7', '', $data['phone']);
        $formatedPhone = preg_replace('/[^0-9]/', '', $formatedPhone);

        $data['phone'] = $formatedPhone;

        return Validator::make($data, [
            'phone' => ['required', 'string', 'min:10', 'max:10', 'unique:shareholders,phone'],
            'password' => ['required', 'string', 'min:4' ],
        ]);
    }

    public function showRegistrationForm()
    {
        return view('shareholder.auth.register');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $formatedPhone = str_replace('+7', '', $data['phone']);
        $formatedPhone = preg_replace('/[^0-9]/', '', $formatedPhone);

        return Shareholder::create([
            'phone' => $formatedPhone,
            'password' => Hash::make($data['password']),
            'fio' => '...',
        ]);
    }
}
