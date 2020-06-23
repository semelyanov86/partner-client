<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
    // Permissions
    Route::apiResource('permissions', 'PermissionsApiController');

    // Roles
    Route::apiResource('roles', 'RolesApiController');

    // Users
    Route::apiResource('users', 'UsersApiController');

    // Failed Logins
    Route::apiResource('failed-logins', 'FailedLoginApiController');

    // Shareholders
    Route::apiResource('shareholders', 'ShareholdersApiController');

    // Loan Requests
    Route::apiResource('loan-requests', 'LoanRequestApiController');

    // Deposit Contracts
    Route::apiResource('deposit-contracts', 'DepositContractApiController');

    // Deposit Schedules
    Route::apiResource('deposit-schedules', 'DepositScheduleApiController');

    // Loan Contracts
    Route::apiResource('loan-contracts', 'LoanContractApiController');

    // Loan Main Schedules
    Route::apiResource('loan-main-schedules', 'LoanMainScheduleApiController');

    // Loan Memfee Schedules
    Route::apiResource('loan-memfee-schedules', 'LoanMemfeeScheduleApiController');

    // Posts
    Route::post('posts/media', 'PostsApiController@storeMedia')->name('posts.storeMedia');
    Route::apiResource('posts', 'PostsApiController');

    // Places
    Route::apiResource('places', 'PlacesApiController');

    // Request Fields
    Route::apiResource('request-fields', 'RequestFieldsApiController');
});
