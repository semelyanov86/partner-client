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
Route::group(['prefix' => 'client', 'as' => 'client.', 'middleware' => ['failtoban'] ], function () {
    //Register
    Route::get('/register', 'Auth\ShareholderRegisterController@showRegistrationForm')->name('register');
    Route::post('/register', 'Auth\ShareholderRegisterController@register')->name('register.submit');
    Route::get('/register/verify', 'Auth\ShareholderRegisterController@showVerificationForm')->name('register.verify');
    Route::post('/register/verify', 'Auth\ShareholderRegisterController@verifyRegistration')->name('register.verify.submit');
    Route::POST('/register/resend', 'Auth\ShareholderRegisterController@resend')->name('register.verify.resend');

    //Login
    Route::get('/login', 'Auth\ShareholderLoginController@showLoginForm')->name('login');
    Route::post('/login', 'Auth\ShareholderLoginController@login')->name('login.submit');

    //Verify
    //Route::get('/verify', 'Auth\ShareholderVerifyController@index')->name('verify');
    //Route::post('/verify', 'Auth\ShareholderVerifyController@verify')->name('verify.submit');
    //Route::POST('/resend', 'Auth\ShareholderVerifyController@resend')->name('resend');

    //Forgot-reset
    Route::GET('/forgot', 'Auth\ShareholderForgotPassController@index')->name('forgot');
    Route::POST('/forgot', 'Auth\ShareholderForgotPassController@reset')->name('forgot.submit');
    Route::GET('/reset', 'Auth\ShareholderResetPassController@index')->name('reset');
    Route::POST('/reset', 'Auth\ShareholderResetPassController@update')->name('reset.submit');

    //Home
    Route::get('/home', 'ShareholderController@index')->name('home');
    Route::redirect('/', '/client/home');
    Route::GET('/block', function () {
        return view('shareholder.block');
    })->name('block');

    //Loan Requests
    Route::get('/requests', 'ShareholderRequestsController@index')->name('requests');
    Route::get('/requests/{id}', 'ShareholderRequestsController@item')->name('requests.item');
    Route::GET('/requestsData', 'ShareholderRequestsController@search')->name('requests.data');
    Route::GET('/requestsCreate', 'ShareholderRequestsController@new')->name('requests.create');
    Route::POST('/requestsCreate', 'ShareholderRequestsController@create')->name('requests.create.submit');
    Route::get('/infoForLoanRequest', 'ShareholderRequestsController@getShareholderInfo')->name('infoForLoanRequest');
    Route::POST('/requests/{id}', 'ShareholderRequestsController@update')->name('requests.item.update');
    Route::POST('/requestSendSMS', 'ShareholderRequestsController@sendSMS')->name('requests.sendSMS');
    Route::POST('/requestVerifySMS', 'ShareholderRequestsController@verifySMS')->name('requests.verifySMS');

    //Credit calc
    Route::get('/creditcalc', 'ShareholderCreditCalcController@index')->name('creditcalc');

    //Contract loan
    Route::get('/loans', 'ShareholderLoanController@index')->name('loans');
    Route::get('/loans/{id}', 'ShareholderLoanController@item')->name('loans.item');
    Route::POST('/loans/{id}', 'ShareholderLoanController@update')->name('loans.item.update');
    Route::GET('/loansData', 'ShareholderLoanController@search')->name('loans.data');

    //Contract Deposit
    Route::get('/deposits', 'ShareholderDepositController@index')->name('deposits');
    Route::get('/deposits/{id}', 'ShareholderDepositController@item')->name('deposits.item');
    Route::POST('/deposits/{id}', 'ShareholderDepositController@update')->name('deposits.item.update');
    Route::GET('/depositsData', 'ShareholderDepositController@search')->name('deposits.data');

    //feedback
    Route::get('/feedback', 'ShareholderFeedbackController@index')->name('feedback');
    Route::post('/feedback', 'ShareholderFeedbackController@send')->name('feedback.submit');

    Route::get('/thanks', 'ShareholderController@thanks')->name('thanks');

    //qr-code
    Route::get('/qr-code', function () { abort(404);})->name('qr');
    Route::get('/qr-code&text={text}', 'ShareholderController@qrCode');

    //sbp-qr-code
    Route::get('/sbp-qr-code', function () { abort(404);})->name('sbp-qr');
    Route::get('/sbp-qr-code&purpose={purpose}&amount={amount}', 'ShareholderController@SBPqrCode');
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

    // Posts
    Route::delete('posts/destroy', 'PostsController@massDestroy')->name('posts.massDestroy');
    Route::post('posts/media', 'PostsController@storeMedia')->name('posts.storeMedia');
    Route::post('posts/ckmedia', 'PostsController@storeCKEditorImages')->name('posts.storeCKEditorImages');
    Route::resource('posts', 'PostsController');

    // Places
    Route::delete('places/destroy', 'PlacesController@massDestroy')->name('places.massDestroy');
    Route::resource('places', 'PlacesController');

    // Request Fields
    Route::delete('request-fields/destroy', 'RequestFieldsController@massDestroy')->name('request-fields.massDestroy');
    Route::resource('request-fields', 'RequestFieldsController');

    // Tools
    Route::resource('tools', 'ToolsController', ['except' => ['create', 'store', 'edit', 'update', 'show', 'destroy']]);

    Route::GET('tools/maintenance/up', 'ToolsController@maintenanceUp')->name('tools.maintenance.up');
    Route::GET('tools/maintenance/down', 'ToolsController@maintenanceDown')->name('tools.maintenance.down');
    Route::GET('tools/maintenance/clearCache', 'ToolsController@clearcache')->name('tools.maintenance.clearCache');

});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
// Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
    }

});
