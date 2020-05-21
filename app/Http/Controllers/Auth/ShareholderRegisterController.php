<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\FailedLoginUtils;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Shareholder;
use http\Env\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ExtApiUtils;

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
        $messages = array(
            'phone.unique' => 'Такой номер телефона уже зарегистрирован',
            'password.min' => 'Пароль слишком короткий',
            'password.same' => 'Пароли должны совпадать',
        );
        return Validator::make($data, [
            'phone' => ['required', 'string', 'min:10', 'max:10', 'unique:shareholders,phone'],
            'password' => ['required', 'string', 'min:6', 'required_with:password-confirm', 'same:password-confirm' ],
        ], $messages);
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
        return Shareholder::create([
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'fio' => '...',
        ]);
    }

    public function register(\Illuminate\Http\Request $request)
    {
        $formatedPhone = str_replace('+7', '', $request->phone);
        $formatedPhone = preg_replace('/[^0-9]/', '', $formatedPhone);

        $request->merge([
            'phone' => $formatedPhone,
        ]);

        $this->validator($request->all())->validate();

        $password = $request->password;
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $cyrilicLow  = preg_match('@[а-я]@', $password);
        $cyrilicUp = preg_match('@[А-Я]@', $password);

        if (!$lowercase || !$number || $cyrilicLow || $cyrilicUp)
        {
            return redirect()->back()
                ->withErrors(['password' => 'Пароль не должен содержать кириллицу. Пароль должен содержать быть как буквы, так и числа.']);
        }

        event(new Registered($user = $this->create($request->all())));

        return redirect()->route('client.login')->withMessage('Вы успешно прошли регистрацию');
    }

}
