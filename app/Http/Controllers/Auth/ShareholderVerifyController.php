<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\FailedLoginUtils;
use App\Helpers\SmsUtils;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShareholderVerifyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:shareholder');
    }

    public function index()
    {
        return view('shareholder.auth.verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => 'integer|required',
        ]);

        $shareholder = Auth::user();
        if($request->input('code') == $shareholder->code)
        {
            $shareholder->resetTwoFactorCode();
            return redirect()->route('client.home');
        }

        FailedLoginUtils::addNewFailEvent($request->ip(), $shareholder->phone, 0);
        return redirect()->back()
            ->withErrors(['code' =>
                'Введен неверный код']);
    }

    public function resend(Request $request)
    {
        $shareholder = Auth::user();
        $shareholder->generateTwoFactorCode();

        SmsUtils::sendSMSCode($shareholder->phone, $shareholder->code, $request->ip());
        return redirect()->back()->withMessage("СМС отправлен повторно");
    }

}
