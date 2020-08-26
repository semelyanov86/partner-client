<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ExtApiUtils;
use App\Helpers\FailedLoginUtils;
use App\Helpers\SmsUtils;
use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Shareholder;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $phone = Utils::getFormatedPhone($request->phone);

        $request['phone'] = $phone;

        $validator = Validator::make($request->all(), [
            'phone' => 'required|min:10|max:10|exists:shareholders,phone',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            FailedLoginUtils::addNewFailEvent($request->ip(), $phone, 0);

            return redirect()->back()->withErrors(['error_msg' => 'Указан неверный номер телефона и(или) пароль'])
                ->withInput($request->only('phone'));
        }

        if (Auth::guard('shareholder')->attempt(['phone'=> $phone, 'password' => $request->password, 'is_active' => 1])) {
            $shareholder = Shareholder::where('phone', $phone)->whereNull('deleted_at')->first();
//            $shareholder->generateTwoFactorCode();
//            SmsUtils::sendSMSCode($phone, $shareholder->code, $request->ip());

            //update shareholder info
            ExtApiUtils::updateShareholderInfo($shareholder->phone);

            //update shareholder headers info
            ExtApiUtils::updateShareholderHeadersInfo($shareholder->id);

            return redirect()->route('client.home');
        }

        FailedLoginUtils::addNewFailEvent($request->ip(), $phone, 0);

        return redirect()->back()->withErrors(['error_msg' => 'Указан неверный номер телефона и(или) пароль'])->withInput($request->only('phone'));
    }

    public function username()
    {
        return 'phone';
    }
}
