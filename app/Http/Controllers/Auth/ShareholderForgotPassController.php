<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ExtApiUtils;
use App\Helpers\FailedLoginUtils;
use App\Helpers\SmsUtils;
use App\Http\Controllers\Controller;
use App\Shareholder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShareholderForgotPassController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:shareholder');
    }

    public function index()
    {
        return view('shareholder.auth.forgot');
    }

    public function reset(Request $request)
    {
        $formatedPhone = str_replace('+7', '', $request->phone);
        $formatedPhone = preg_replace('/[^0-9]/', '', $formatedPhone);

        $request['phone'] = $formatedPhone;

        $validator = Validator::make($request->all(), [
            'phone' => 'required|min:10|max:10|exists:shareholders,phone',
        ]);

        if ($validator->fails())
        {
            FailedLoginUtils::addNewFailEvent($request->ip(), $formatedPhone, 0);
            return redirect()->back()->withErrors(['error_msg' =>
                'Указан несуществующий номер телефона'])
                ->withInput($request->only('phone'));
        }

        $shareholder = Shareholder::where("phone", $formatedPhone)->first();
        $shareholder->generateTwoFactorCode();

        SmsUtils::sendSMSCode($formatedPhone, $shareholder->code, $request->ip());

        return redirect()->route('client.reset')->withInput($request->only('phone'));
    }
}
