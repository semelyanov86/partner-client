<?php

Route::redirect('/', '/client/login');

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes();

//clients - shareholders
Route::group(['prefix' => 'client', 'as' => 'client.' ], function () {
    Route::get('/register', 'Auth\ShareholderRegisterController@showRegistrationForm')->name('register');
    Route::post('/register', 'Auth\ShareholderRegisterController@register')->name('register.submit');
    Route::get('/login', 'Auth\ShareholderLoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\ShareholderLoginController@login')->name('login.submit');
    Route::get('/home', 'ShareholderController@index')->name('home');
    Route::redirect('/', '/client/home');
});

// Admin
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Failed Logins
    Route::delete('failed-logins/destroy', 'FailedLoginController@massDestroy')->name('failed-logins.massDestroy');
    Route::resource('failed-logins', 'FailedLoginController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Shareholders
    Route::delete('shareholders/destroy', 'ShareholdersController@massDestroy')->name('shareholders.massDestroy');
    Route::resource('shareholders', 'ShareholdersController');

    // Loan Requests
    Route::delete('loan-requests/destroy', 'LoanRequestController@massDestroy')->name('loan-requests.massDestroy');
    Route::resource('loan-requests', 'LoanRequestController');

    // Deposit Contracts
    Route::delete('deposit-contracts/destroy', 'DepositContractController@massDestroy')->name('deposit-contracts.massDestroy');
    Route::resource('deposit-contracts', 'DepositContractController');

    // Deposit Schedules
    Route::delete('deposit-schedules/destroy', 'DepositScheduleController@massDestroy')->name('deposit-schedules.massDestroy');
    Route::resource('deposit-schedules', 'DepositScheduleController');

    // Loan Contracts
    Route::delete('loan-contracts/destroy', 'LoanContractController@massDestroy')->name('loan-contracts.massDestroy');
    Route::resource('loan-contracts', 'LoanContractController');

    // Loan Main Schedules
    Route::delete('loan-main-schedules/destroy', 'LoanMainScheduleController@massDestroy')->name('loan-main-schedules.massDestroy');
    Route::resource('loan-main-schedules', 'LoanMainScheduleController');

    // Loan Memfee Schedules
    Route::delete('loan-memfee-schedules/destroy', 'LoanMemfeeScheduleController@massDestroy')->name('loan-memfee-schedules.massDestroy');
    Route::resource('loan-memfee-schedules', 'LoanMemfeeScheduleController');

});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
// Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
    }

});
