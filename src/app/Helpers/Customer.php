<?php 

namespace Solunes\Customer\App\Helpers;

use Validator;

class Customer {
    
    public static function after_seed_actions() {
      $menu = \Solunes\Master\App\Menu::where('permission','todotix')->first();
      if($menu){
        \Solunes\Master\App\Menu::create(['menu_type'=>'admin','level'=>2,'parent_id'=>$menu->id,'icon'=>'table','name'=>'Nómina de Clientes','permission'=>'todotix','link'=>'admin/model-list/customer?search=1']);
        \Solunes\Master\App\Menu::create(['menu_type'=>'admin','level'=>2,'parent_id'=>$menu->id,'icon'=>'table','name'=>'Nómina de Pagos','permission'=>'todotix','link'=>'admin/model-list/payment?search=1']);
      }
      \Solunes\Master\App\Menu::create(['menu_type'=>'admin','icon'=>'dollar','name'=>'Mis Pagos Pendientes','permission'=>'members','link'=>'admin/my-payments']);
      \Solunes\Master\App\Menu::create(['menu_type'=>'admin','icon'=>'table','name'=>'Mi Historial','permission'=>'members','link'=>'admin/my-history']);
    }

    public static function validateRegister($fields_array) {
        $response = [];
        foreach($fields_array as $item){
          if($item=='email'){
            $response[$item] = 'required|email';
          } else {
            $response[$item] = 'required';
          }
        }
        return $response;
    }

    public static function calculateAge($dateOfBirth, $dateNow = NULL) {
        if(!$dateNow){
            $dateNow = date("Y-m-d");
        }
        $diff = date_diff(date_create($dateOfBirth), date_create($dateNow));
        return $diff->format('%y');
    }

    public static function generateCustomer($ci_number, $email, $array, $password) {
        if(!$password){
            $password = rand(100000,999999);
        }
        if(!$customer = \Solunes\Customer\App\Customer::where('ci_number', $ci_number)->first()){
            $customer = new \Solunes\Customer\App\Customer;
            $customer->ci_number = $ci_number;
            $customer->email = $email;
            $customer->active = 1;
        }
        foreach($array as $key => $val){
            $customer->$key = $val;
        }
        if(config('customer.fields.age')){
            $customer->age = \Customer::calculateAge($customer->birth_date);
        }
        $customer->save();
        if(config('customer.custom.register')){
            $customer = \CustomFunc::customerCustomRegister($customer);
        }
        return $customer;
    }
    
    public static function sendConfirmationEmail($main_customer) {
        $link = url('realizar-pago');
        \Mail::send('emails.notifications.succesful-register', ['link'=>$link, 'email'=>$main_customer->email, 'password'=>$main_customer->member_code], function($m) use($main_customer) {
          $m->to($main_customer->email, $main_customer->full_name)->subject('Copa Solunes 2018 | Su registro fue realizado correctamente');
        });
        return true;
    }
     
    public static function checkExternalCustomerById($external_id) {
        $api = app('\Solunes\App\Controllers\WebServiceController')->getCustomerByExternalId($external_id);
        if($api){
            return true;
        } else {
            return false;
        }
    }

    public static function checkExternalCustomerByParameters($request) {
        $api = app('\Solunes\App\Controllers\WebServiceController')->getCustomerByParameters($request->input('email'), $request->input('ci_number'), $request->input('phone'));
        if($api){
            return true;
        } else {
            return false;
        }
    }
      
    public static function registerExternalCustomer($request) {
        $api = app('\Solunes\App\Controllers\WebServiceController')->registerCustomer($request->input('email'), $request->input('ci_number'), $request->input('cellphone'), $request->input('birth_date'), $request->input('first_name'), $request->input('last_name'), $request->input('ci_expedition'), $request->input('address'), $request->input('nit_number'), $request->input('nit_name'), $request->input('password'));
        if($api){
            return $api->id;
        } else {
            return null;
        }
    }
      
    public static function updateExternalCustomer($external_id, $request) {
        $api = app('\Solunes\App\Controllers\WebServiceController')->updateCustomerData($external_id, $request->input('email'), $request->input('ci_number'), $request->input('cellphone'), $request->input('birth_date'), $request->input('first_name'), $request->input('last_name'), $request->input('ci_expedition'), $request->input('address'), $request->input('nit_number'), $request->input('nit_name'), $request->input('password'));
        if($api){
            return true;
        } else {
            return false;
        }
    }

}