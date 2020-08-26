<?php

namespace App\Providers;

use App\DepositContract;
use App\LoanContract;
use App\LoanRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $requestsCount = LoanRequest::where('shareholder_id', Auth::id())->count();
                $loansCount = LoanContract::where('shareholder_id', Auth::id())->count();
                $depositsCount = DepositContract::where('shareholder_id', Auth::id())->count();

                $view->with('loans_badge', $loansCount);
                $view->with('loan_requests_badge', $requestsCount);
                $view->with('deposits_badge', $depositsCount);
            }
        });
    }
}
