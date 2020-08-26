<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ExtApiUtils;
use App\Helpers\FailedLoginUtils;
use App\Helpers\SmsUtils;
use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Shareholder;
use http\Env\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
        $messages = [
            'phone.exists' => 'Номер телефона не найден в базе',
            'password.min' => 'Пароль слишком короткий',
            'password.same' => 'Пароли должны совпадать',
        ];

        return Validator::make($data, [
            'phone' => ['required', 'string', 'min:10', 'max:10', 'exists:shareholders,phone'],
            'password' => ['required', 'string', 'min:6', 'required_with:password-confirm', 'same:password-confirm'],
        ], $messages);
    }

    protected function phoneValidator(array $data)
    {
        $messages = [
            'phone.required' => 'Введите номер телефона',
            'phone.min' => 'Номер телефона слишком короткий',
            'phone.max' => 'Номер телефона слишком длинный',
        ];

        return Validator::make($data, [
            'phone' => ['required', 'string', 'min:10', 'max:10'],
        ], $messages);
    }

    public function showRegistrationForm()
    {
        return view('shareholder.auth.register');
    }

    public function showVerificationForm()
    {
        return view('shareholder.auth.verify-register');
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
            'password' => Hash::make(Str::random(16)),
            'fio' => '...',
            'is_active' => 0,
        ]);
    }

    public function register(\Illuminate\Http\Request $request)
    {
        $phone = Utils::getFormatedPhone($request->phone);
        $request->merge([
            'phone' => $phone,
        ]);

        $this->phoneValidator($request->all())->validate();

        $shareholder = Shareholder::where('phone', $phone)->whereNull('deleted_at')->first();

        if (! $shareholder) {
            event(new Registered($user = $this->create($request->all())));
        } else {
            if ($shareholder->is_active == true) {
                Log::error('user active, login');

                return redirect()->route('client.login')
                    ->withMessage('Вы уже зарегистрированы');
            }
        }

        $shareholder = Shareholder::where('phone', $phone)->whereNull('deleted_at')->first();
        $shareholder->generateTwoFactorCode();
        SmsUtils::sendSMSCode($shareholder->phone, $shareholder->code, $request->ip());

        return redirect()->route('client.register.verify')
            ->withMessage('Заполните регистрационные данные')
            ->withInput($request->only('phone'));
    }

    public function verifyRegistration(\Illuminate\Http\Request $request)
    {
        $phone = Utils::getFormatedPhone($request->phone);
        $request->merge([
            'phone' => $phone,
        ]);

        //validate fields
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator->errors())
            ->withInput($request->only('phone', 'password', 'password-confirm'));
        }

        //validate password
        $password = $request->password;
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $cyrilicLow = preg_match('@[а-я]@', $password);
        $cyrilicUp = preg_match('@[А-Я]@', $password);

        if (! $lowercase || ! $number || $cyrilicLow || $cyrilicUp) {
            return redirect()->back()
                ->withErrors(['password' => 'Пароль не должен содержать кириллицу. Пароль должен содержать быть как буквы, так и числа.'])
                ->withInput($request->only('phone', 'password', 'password-confirm'));
        }

        //validate code
        $code = $request->input('code');
        $shareholder = Shareholder::where('phone', $phone)->whereNull('deleted_at')->first();
        if ($shareholder->code) {
            if (! $shareholder->code_expires_at || $shareholder->code_expires_at->lessThan(now())) {
                $shareholder->resetTwoFactorCode();

                return redirect()->route('client.register')
                    ->withMessage('Срок действия СМС кода истек. Пожалуйста, попробуйте еще раз.');
            }

            if ($shareholder->code != $code) {
                return redirect()->back()
                    ->withErrors(['code' => 'Введен неверный код'])
                    ->withInput($request->only('phone', 'password', 'password-confirm'));
            }
        }

        //activate user
        $shareholder->resetTwoFactorCode();
        $shareholder->password = Hash::make($password);
        $shareholder->is_active = true;
        $shareholder->save();

        ExtApiUtils::updateShareholderInfo($phone);

        return redirect()->route('client.login')->withMessage('Вы успешно прошли регистрацию');
    }

    public function resend(\Illuminate\Http\Request $request)
    {
        $phone = Utils::getFormatedPhone($request->phone);
        $request->merge([
            'phone' => $phone,
        ]);

        $validator = $this->phoneValidator($request->all());
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors())
                ->withInput($request->only('phone', 'password', 'password-confirm'));
        }

        $shareholder = Shareholder::where('phone', $phone)->whereNull('deleted_at')->first();

        $shareholder->generateTwoFactorCode();
        SmsUtils::sendSMSCode($shareholder->phone, $shareholder->code, $request->ip());

        return redirect()->back()->withMessage('СМС отправлен повторно')
            ->withInput($request->only('phone', 'password', 'password-confirm'));
    }
}
