<?php

return [

    // PARAMETERS
    'send_mail' => false,
    'dependants' => false,
    'enable_test' => true,
    'custom_successful_payment' => false,
    'after_login_no_password' => 'account/change-password/gLW2fAst39MV',
    'redirect_after_login' => 'inicio',
    'ci_expeditions_table' => false, // Habilitar en caso de extensiones en tabla dinamica
    'fields' => [
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
    'custom' => [
        'register'=> false,
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