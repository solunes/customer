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

Route::group(['prefix'=>'process'], function(){
    if(!config('customer.custom.register')){
        Route::post('registro', 'ProcessController@postRegistro');
    }
    Route::get('check-ci/{ci_number}', 'ProcessController@getCheckCi');
});
Route::group(['prefix'=>'account'], function(){
    // Rutas para Mi Cuenta
    Route::get('register/{token}', 'ProcessController@getRegister')->middleware('guest');
    Route::get('login/{token}', 'ProcessController@getLogin')->middleware('guest');
    Route::get('login/{token}', 'ProcessController@getLogin')->middleware('guest');
    Route::get('recover-password/{token}', 'ProcessController@getRecoverPassword')->middleware('guest');
    Route::post('recover-password', 'ProcessController@postRecoverPassword')->middleware('guest');
    Route::get('recovered-password/{token}', 'ProcessController@getRecoveredPassword')->middleware('guest');
    Route::get('reset-password/{token}', 'ProcessController@getResetPassword')->middleware('guest');
    Route::post('reset-password', 'ProcessController@postResetPassword')->middleware('guest');
    Route::get('change-password/{token}', 'ProcessController@getChangePassword')->middleware('auth');
    Route::post('change-password', 'ProcessController@postChangePassword')->middleware('auth');
    Route::get('my-account/{token}', 'ProcessController@getMyAccount')->middleware('auth');
    Route::get('my-account-2/{token}', 'ProcessController@getMyAccount2')->middleware('auth');
    Route::get('my-payments-2/{token}', 'ProcessController@getMyPayments2')->middleware('auth');
    Route::get('my-history-2/{token}', 'ProcessController@getMyHystory2')->middleware('auth');
    Route::post('edit-customer', 'ProcessController@postEditCustomer')->middleware('auth');
    Route::post('edit-image', 'ProcessController@postEditImage')->middleware('auth');
    Route::get('delete-image/{token}', 'ProcessController@getDeleteImage')->middleware('auth');
});

Route::group(['prefix'=>'trigger'], function(){
    Route::get('check-customer-contact/{customer_contact_id}', 'ProcessController@getCheckCustomerContact');
});

Route::group(['prefix'=>'customer-webservice'], function(){
    Route::get('customer-by-parameters/{email}/{ci_number}/{cellphone}', 'WebServiceController@getCustomerByParameters');
    Route::get('customer-by-external-id/{external_id}', 'WebServiceController@getCustomerByExternalId');
    Route::get('register-customer/{email}/{ci_number}/{cellphone}/{birth_date}/{first_name}/{last_name}/{ci_expedition}/{address}/{nit_number}/{nit_name}/{password}', 'WebServiceController@registerCustomer');
    Route::get('update-customer-data/{external_id}/{email}/{ci_number}/{cellphone}/{birth_date}/{first_name}/{last_name}/{ci_expedition}/{address}/{nit_number}/{nit_name}/{password}', 'WebServiceController@updateCustomerData');
});

Route::group(['prefix'=>'customer-api-server'], function(){
    Route::get('customer-by-id/{id}', 'ApiServerController@getCustomerById');
    Route::get('customer-by-parameters/{ci_number}/{email}/{cellphone}', 'ApiServerController@getCustomerByParameters');
    Route::post('register-customer', 'ApiServerController@registerCustomer');
    Route::post('update-customer-data', 'ApiServerController@updateCustomerData');
});