<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['prefix'=>'admin'], function(){
    // Users
    Route::get('redirect', 'CustomAdminController@getRedirect');
    Route::get('my-accounts', 'CustomAdminController@getMyAccounts');
    Route::post('edit-password', 'CustomAdminController@postEditPassword');
    Route::get('my-account/{customer_id?}', 'CustomAdminController@getMyAccount');
    Route::post('edit-account', 'CustomAdminController@postEditAccount');
    Route::get('my-dependants', 'CustomAdminController@getMyDependants');
    Route::get('my-payments', 'CustomAdminController@getMyPayments');
    Route::get('my-history', 'CustomAdminController@getMyHistory');
    // Admin
    Route::get('list-customers', 'CustomAdminController@getCustomerList');
    Route::get('list-payments', 'CustomAdminController@getPaymentsList');
    Route::get('login-as/{token}/{customer_id}', 'CustomAdminController@getManualLogin');
});