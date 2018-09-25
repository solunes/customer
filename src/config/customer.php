<?php

return [

    // PARAMETERS
    'send_mail' => false,
    'dependants' => false,
    'enable_test' => true,
    'fields' => [
        'password'=> true,
        'age'=> true,
        'shirt'=> false,
        'shirt_size'=> false,
        'invoice_data'=> true,
        'emergency_short'=> true,
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
    'recieve_from_api' => false,
    'feeds_through_api' => false,
    'main_server_url' => 'http://master.test/customer-api/',
    'main_server_app_key' => '61b7109893d07a55bccb86e6a5817a1cb9ad5c6d',

];