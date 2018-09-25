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