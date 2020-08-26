<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class TwoFactor
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
        $shareholder = $request->user();

        if ($request->user() && $shareholder->code) {
            if (! $shareholder->code_expires_at || $shareholder->code_expires_at->lessThan(now())) {
                $shareholder->resetTwoFactorCode();
                auth()->logout();

                return redirect()->route('client.login')
                    ->withMessage('Срок действия СМС кода истек. Пожалуйста, войдите еще раз.');
            }

            if (! $request->is('*client/verify*') && ! $request->is('*client/resend*')
                && ! $request->is('*client/logout*') && ! $request->is('*client/block*')) {
                return redirect()->route('client.verify');
            }
        }

        return $next($request);
    }
}
