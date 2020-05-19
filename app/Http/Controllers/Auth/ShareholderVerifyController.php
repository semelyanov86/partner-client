<?php

namespace App\Http\Controllers\Auth;

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
        return redirect()->back()
            ->withErrors(['code' =>
                'Введен неверный код']);
    }

    public function resend()
    {
        $shareholder = Auth::user();
        if ($shareholder->canResendSMS())
        {
            $shareholder->generateTwoFactorCode();
            //TODO Send SMS
            return redirect()->back()->withMessage("СМС отправлен повторно");
        }
        else
        {
            return redirect()->back()
                ->withErrors(['send_sms' =>
                    'СМС не может быть отправлена чаще чем 1 раз в '.env('SMS_RESEND_DELAY_SECONDS', 60)." секунд.  "  ]);
        }

    }

}
