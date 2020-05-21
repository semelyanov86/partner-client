<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        switch ($guard) {
            case 'shareholder':
                if (Auth::guard($guard)->check()) {

                    $shareholder = auth()->user();

                    if(auth()->check() && $shareholder->code)
                    {

                        if(!$shareholder->code_expires_at || $shareholder->code_expires_at->lessThan(now()))
                        {
                            $shareholder->resetTwoFactorCode();
                            auth()->logout();
                            return redirect()->route('client.login')
                                ->withMessage('Срок действия СМС кода истек. Пожалуйста, войдите еще раз.'.$shareholder->code_expires_at );
                        }

                        if(!$request->is('*client/verify*'))
                        {
                            return redirect()->route('client.verify');
                        }
                    }

                    return redirect()->route('client.home');
                }
                break;
            default:
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('admin.home');
                }
                break;
        }

        return $next($request);
    }
}
