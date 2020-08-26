<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ExtApiUtils;
use App\Helpers\FailedLoginUtils;
use App\Http\Controllers\Controller;
use App\Shareholder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ShareholderResetPassController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:shareholder');
    }

    public function index()
    {
        return view('shareholder.auth.reset');
    }

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
            'code' => ['required', 'integer'],
        ], $messages);
    }

    public function update(Request $request)
    {
        $formatedPhone = str_replace('+7', '', $request->phone);
        $formatedPhone = preg_replace('/[^0-9]/', '', $formatedPhone);

        $request['phone'] = $formatedPhone;

        $request->merge([
            'phone' => $formatedPhone,
        ]);

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('phone', 'password', 'password-confirm'));
        }

        $password = $request->password;
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $cyrilicLow = preg_match('@[а-я]@', $password);
        $cyrilicUp = preg_match('@[А-Я]@', $password);

        if (! $lowercase || ! $number || $cyrilicLow || $cyrilicUp) {
            return redirect()->back()
                ->withInput($request->only('phone', 'password', 'password-confirm'))
                ->withErrors(['password' => 'Пароль не должен содержать кириллицу. Пароль должен содержать быть как буквы, так и числа.']);
        }

        $shareholder = Shareholder::where('phone', $formatedPhone)->first();

        if (! $shareholder->code_expires_at || $shareholder->code_expires_at->lessThan(now())) {
            $shareholder->resetTwoFactorCode();

            return redirect()->route('client.login')
                ->withMessage('Срок действия СМС кода истек. Пожалуйста, попробуйте еще раз.');
        }

        if ($shareholder->code != $request->code) {
            FailedLoginUtils::addNewFailEvent($request->ip(), $formatedPhone, 0);

            return redirect()->back()
                ->withInput($request->only('phone', 'password', 'password-confirm'))
                ->withErrors(['code' => 'Введен неверный код']);
        }

        $shareholder->password = Hash::make($request->password);
        $shareholder->save();

        return redirect()->route('client.login')->withMessage('Пароль успешно сброшен');
    }
}
