<?php

namespace App\Http\Middleware;

use App\Helpers\ExtApiUtils;
use App\Helpers\FailedLoginUtils;
use App\Helpers\Utils;
use App\Shareholder;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FailToBan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //block by ip
        if (FailedLoginUtils::getRemainFailCount($request->ip()) <= 0 && ! $request->is('*client/block*')) {
            return redirect()->route('client.block')
                ->withMessage('Слишком много неправильных попыток. Для вас заблокирована возможность входа в течении '.config('settings.ban_time_minutes').' мин.');
        }

        //block if phone does not exist in 1c
        if ($request->isMethod('POST')
            && ($request->is('*client/login*') || $request->is('*client/register*')
                || $request->is('*client/forgot*') || $request->is('*client/reset*')
                || $request->is('*client/register/verify*'))) {
            $phone = Utils::getFormatedPhone($request->phone);

            if (ExtApiUtils::getShareholderByPhone($phone) == false) {
                FailedLoginUtils::addNewFailEvent($request->ip(), $phone, 0);

                return redirect()->back()->withMessage('Номер телефона не найден в базе');
            }
        }

        //block if SMS does not remain
        if ($request->isMethod('POST')
            && ($request->is('*client/login*') || $request->is('*client/resend*')
                || $request->is('*client/forgot*'))) {
            $phone = '';

            if ($request->user()) {
                $shareholder = $request->user();
                $phone = $shareholder->phone;
            } elseif ($request->phone) {
                $phone = Utils::getFormatedPhone($request->phone);
            }

            if (! FailedLoginUtils::canResendSMS($phone)) {
                return redirect()->back()
                    ->withErrors(['error_msg' => 'СМС не может быть отправлена чаще чем 1 раз в '.config('settings.sms_resend_delay_seconds').' секунд.  ']);
            }

            if (FailedLoginUtils::getRemainSMSCount($phone) <= 0) {
                if ($request->user()) {
                    $shareholder = $request->user();
                    $shareholder->resetTwoFactorCode();
                    auth()->logout();
                }

                return redirect()->route('client.block')
                    ->withMessage('Слишком много неправильных попыток. Для вас заблокирована возможность отправки СМС в течении '.config('settings.ban_time_minutes').' мин.');
            }
        }

        return $next($request);
    }
}
