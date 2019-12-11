<?php

return [

    // PARAMETERS
    'send_mail' => false,
    'dependants' => false,
    'tracking' => false,
    'tasks' => false,
    'notes' => false,
    'contacts' => false,
    'tickets' => false,
    'nfcs' => false,
    'ppvs' => false,
    'subscriptions' => false,
    //
    'subscription_products' => false,
    'credit_wallet' => false,
    'credit_wallet_points' => false,
    'login_as' => false,
    'enable_test' => true,
    'customer_agency' => false,
    'seller_user' => false,
    'after_seed' => true,
    'custom_successful_payment' => false,
    'after_login_no_password' => 'account/change-password/gLW2fAst39MV',
    'redirect_after_login' => 'inicio',
    'ci_expeditions_table' => false, // Habilitar en caso de extensiones en tabla dinamica
    'fields' => [
        'country'=> false,
        'city'=> false,
        'address'=> false,
        'coordinates'=> false,
        'member_code'=> false,
        'ci_extension'=> true,
        'password'=> true,
        'birth_date'=> false,
        'age'=> false,
        'image'=> false,
        'shirt'=> false,
        'shirt_size'=> false,
        'invoice_data'=> true,
        'emergency_short'=> false,
        'emergency_long'=> false,
    ],
    'dependant_fields' => [
        'email'=> false,
        'cellphone'=> false,
        'ci_number'=> false,
        'image'=> false,
        'birth_date'=> false,
        'emergency_name'=> false,
        'emergency_number'=> false,
    ],
    'fields_rules' => [
        'first_name'=> 'required',
        'last_name'=> 'required',
        'email'=> 'required|email',
        'ci_number'=> 'required',
        'password'=> 'required',
    ],
    'custom' => [
        'register'=> true,
        'register_rules'=> false,
        'after_register'=> false,
        'after_login'=> false,
        'after_succesful_payment'=> false,
    ],

    // API
    'api_slave' => false,
    'api_master' => false,
    'main_server_url' => 'http://master.test/customer-api-server/',
    'main_server_app_key' => '61b7109893d07a55bccb86e6a5817a1cb9ad5c6d',

];