<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ExtApiUtils;
use App\Helpers\FailedLoginUtils;
use App\Helpers\SmsUtils;
use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyShareholderVerifyRequest;
use App\Shareholder;
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

    public function verify(VerifyShareholderVerifyRequest $request)
    {
        $shareholder = $request->user();
        if ($request->input('code') == $shareholder->code) {
            $shareholder->resetTwoFactorCode();

            //update shareholder info
            ExtApiUtils::updateShareholderInfo($shareholder->phone);

            //update shareholder headers info
            ExtApiUtils::updateShareholderHeadersInfo($shareholder->id);

            return redirect()->route('client.home');
        }

        FailedLoginUtils::addNewFailEvent($request->ip(), $shareholder->phone, 0);

        return redirect()->back()
            ->withErrors(['code' => 'Введен неверный код']);
    }

    public function resend(Request $request)
    {
        $shareholder = $request->user();
        $shareholder->generateTwoFactorCode();

        SmsUtils::sendSMSCode($shareholder->phone, $shareholder->code, $request->ip());

        return redirect()->back()->withMessage('СМС отправлен повторно');
    }
}
