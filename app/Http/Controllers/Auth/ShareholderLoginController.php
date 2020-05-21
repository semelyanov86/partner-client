<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ExtApiUtils;
use App\Helpers\FailedLoginUtils;
use App\Helpers\SmsUtils;
use App\Http\Controllers\Controller;
use App\Shareholder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class ShareholderLoginController extends Controller
{
    use AuthenticatesUsers;
    public function __construct()
   {
        $this->middleware('guest:shareholder');
   }

    public function showLoginForm()
   {
       return view('shareholder.auth.login');
   }

    public function login(Request $request)
    {
        $formatedPhone = str_replace('+7', '', $request->phone);
        $formatedPhone = preg_replace('/[^0-9]/', '', $formatedPhone);

        $request['phone'] = $formatedPhone;

        $validator = Validator::make($request->all(), [
            'phone' => 'required|min:10|max:10|exists:shareholders,phone',
            'password' => 'required'
        ]);

        if ($validator->fails())
        {
            FailedLoginUtils::addNewFailEvent($request->ip(), $formatedPhone, 0);
            return redirect()->back()->withErrors(['error_msg' =>
                'Указан неверный номер телефона и(или) пароль'])
                ->withInput($request->only('phone'));
        }

        if (Auth::guard('shareholder')->attempt(['phone'=> $formatedPhone, 'password' => $request->password]))
        {
            $shareholder = Shareholder::where("phone", $formatedPhone)->first();
            $shareholder->generateTwoFactorCode();

            SmsUtils::sendSMSCode($formatedPhone, $shareholder->code, $request->ip());

            return redirect()->route('client.verify');
        }

        FailedLoginUtils::addNewFailEvent($request->ip(), $formatedPhone, 0);
        return redirect()->back()->withErrors(['error_msg' =>
            'Указан неверный номер телефона и(или) пароль'])->withInput($request->only('phone'));
    }

    public function username()
    {
        return 'phone';
    }

}
