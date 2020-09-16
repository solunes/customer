<?php

return [

    // PARAMETERS
    'send_mail' => false,
    'dependants' => false,
    'addresses' => false,
    'tracking' => false,
    'tasks' => false,
    'notes' => false,
    'contacts' => false,
    'tickets' => false,
    'nfcs' => false,
    'payments' => false,
    'ppvs' => false,
    'subscriptions' => false,
    'subscription_products' => false,
    'credit_wallet' => false,
    'credit_wallet_points' => false,
    'login_as' => false,
    'enable_test' => env('ENABLE_TEST', 1),
    'customer_agency' => false,
    'seller_user' => false,
    'detect_ip' => false,
    'after_seed' => true,
    'custom_successful_payment' => true,
    'global_email' => 'edumejia30@gmail.com',
    'after_login_no_password' => 'account/change-password/gLW2fAst39MV',
    'redirect_after_login' => 'inicio',
    'ci_expeditions_table' => false, // Habilitar en caso de extensiones en tabla dinamica
    'allow_login_by_id' => null, // Introducir llave de seguridad para utilizar este comando
    'different_customers_by_agency' => false, // Habilitar cuando cada agencia funcione como una empresa distinta.
    'customers_token' => 'mMLZggHrrFgfF', // Habilitar para validar navegación y demás
    'default_password' => '12345678', // Habilitar para validar navegación y demás
    'fields' => [
        'country'=> false,
        'region'=> false,
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
        'member_code'=> false,
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
        'register'=> true, // Habilitar registro
        'custom_register'=> false, // Habilitar registro totalmente personalizado
        'register_rules'=> false, // Haiblitar reglas de registro personalizadas
        'after_register'=> false, // Habilitar funcion luego de registro
        'after_login'=> false, // Habilitar funcion luego de login
        'after_succesful_payment'=> false, // Habilitar funcion luego de pago
    ],

    // API
    'api_slave' => false,
    'api_master' => false,
    'main_server_url' => 'http://master.test/customer-api-server/',
    'main_server_app_key' => '61b7109893d07a55bccb86e6a5817a1cb9ad5c6d',

];