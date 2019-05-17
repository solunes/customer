<?php 

namespace Solunes\Customer\App\Helpers;

use Validator;

class Customer {
    
    public static function before_seed_actions() {
      $menu = \Solunes\Master\App\Menu::where('permission','todotix')->first();
      foreach(\Solunes\Master\App\Language::get() as $language){
        \App::setLocale($language->code);
        $menu_labels['nomina-clientes'][$language->code] = ['name'=>trans('customer::admin.nomina-clientes'),'link'=>'admin/model-list/customer?search=1'];
        $menu_labels['nomina-pagos'][$language->code] = ['name'=>trans('customer::admin.nomina-pagos'),'link'=>'admin/model-list/payment?search=1'];
        $menu_labels['pagos-pendientes'][$language->code] = ['name'=>trans('customer::admin.pagos-pendientes'),'link'=>'admin/my-payments'];
        $menu_labels['historial-pagos'][$language->code] = ['name'=>trans('customer::admin.historial-pagos'),'link'=>'admin/my-history'];
      }
      if($menu){
        \Solunes\Master\App\Menu::create(array_merge(['menu_type'=>'admin','level'=>2,'parent_id'=>$menu->id,'icon'=>'table','permission'=>'todotix'],$menu_labels['nomina-clientes']));
        \Solunes\Master\App\Menu::create(array_merge(['menu_type'=>'admin','level'=>2,'parent_id'=>$menu->id,'icon'=>'table','permission'=>'todotix'],$menu_labels['nomina-pagos']));
      }
      \Solunes\Master\App\Menu::create(array_merge(['menu_type'=>'admin','icon'=>'dollar','permission'=>'members'],$menu_labels['pagos-pendientes']));
      \Solunes\Master\App\Menu::create(array_merge(['menu_type'=>'admin','icon'=>'table','permission'=>'members'],$menu_labels['historial-pagos']));
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
        $customer->status = 'normal';
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

    // Encontrar cliente en sistema o devolver nulo
    public static function getCustomer($customer_id, $get_pending_payments = false, $for_api = false, $custom_app_key = 'default') {
        if($customer = \Solunes\Customer\App\Customer::where('id',$customer_id)->first()){
            // Definir variables de cliente en formato PagosTT: email, name, nit_name, nit_number
            $array['id'] = $customer->id;
            $array['email'] = $customer->email;
            //$array['email'] = 'edumejia30@gmail.com';
            $array['ci_number'] = $customer->ci_number;
            if(config('payments.sfv_version')>1||config('customer.fields.ci_extension')){
                $array['ci_extension'] = $customer->ci_extension;
            }
            if(config('payments.sfv_version')>1||config('customer.ci_expeditions_table')){
                $array['ci_expedition'] = $customer->ci_expedition_id;
            }
            if(config('payments.customer_code')>1){
                $array['customer_code'] = $customer->customer_code;
            }
            $array['name'] = $customer->first_name.' '.$customer->last_name;
            $array['first_name'] = $customer->first_name;
            $array['last_name'] = $customer->last_name;
            $array['nit_name'] = $customer->nit_name;
            $array['nit_number'] = $customer->nit_number;
            // Consultar y obtener los pagos pendientes del cliente en formato PagosTT: concepto, cantidad, costo_unitario
            $pending_payments = [];
            $payment = NULL;
            if($get_pending_payments&&config('payments.pagostt_params.customer_all_payments')){
                foreach($customer->pending_payments as $payment){
                    if($for_api){
                        $pending_payments[$payment->id]['name'] = $payment->name;
                        $pending_payments[$payment->id]['due_date'] = $payment->due_date;
                    }
                    if(config('customer.enable_test')==1){
                        $pending_payments[$payment->id]['amount'] = count($payment->payment_items);
                    } else {
                        $pending_payments[$payment->id]['amount'] = $payment->amount;
                    }
                    foreach($payment->payment_items as $payment_item){
                        if(config('customer.enable_test')==1){
                            $amount = 1;
                        } else {
                            $amount = $payment_item->price;
                        }
                        $extra_parameters = \Pagostt::getItemExtraParameters($payment_item);
                        $pending_payment = \Pagostt::generatePaymentItem($payment_item->name, $payment_item->quantity, $amount, $payment->invoice, $extra_parameters);
                        $pending_payments[$payment->id]['items'][] = $pending_payment;
                    }
                }
                if(!$payment){
                    return [];
                }
                $array['payment']['name'] = 'Múltiples Pagos';
                $array['payment']['has_invoice'] = $payment->invoice;
                //$array['payment']['metadata'][] = \Pagostt::generatePaymentMetadata('Tipo de Cambio', $payment->exchange);
                $array['payment'] = \Pagostt::paymentAddPaymentInvoice($array['payment'], $payment);
            }
            $array['pending_payments'] = $pending_payments;
            return $array;
        } else {
            return NULL;
        }
    }

    // Encontrar pago en sistema o devolver nulo
    public static function getPayment($payment_id, $custom_app_key = 'default') {
        if($payment = \Solunes\Payments\App\Payment::where('id', $payment_id)->where('status','holding')->first()){
            // Definir variables de pago en formato PagosTT: name, items[concepto, cantidad, costo_unitario]
            $item = [];
            $item['id'] = $payment->id;
            $item['name'] = $payment->name;
            $item['nit_name'] = $payment->invoice_name;
            $item['nit_number'] = $payment->invoice_nit;
            $subitems_array = [];
            foreach($payment->payment_items as $payment_item){
                if(config('customer.enable_test')==1){
                    $amount = 1;
                } else {
                    $amount = $payment_item->price;
                }
                $extra_parameters = \Pagostt::getItemExtraParameters($payment_item);
                $subitems_array[] = \Pagostt::generatePaymentItem($payment_item->name, $payment_item->quantity, $amount, $payment->invoice, $extra_parameters);
            }
            if(config('customer.enable_test')==1){
                $item['amount'] = count($payment->payment_items);
            } else {
                $item['amount'] = $payment->amount;
            }
            $item['items'] = $subitems_array;
            $item['has_invoice'] = $payment->invoice;
            //$item['metadata'][] = \Pagostt::generatePaymentMetadata('Tipo de Cambio', $payment->exchange);
            $item = \Pagostt::paymentAddPaymentInvoice($item, $payment);
            return $item;
        } else {
            return NULL;
        }
    }

    // Encontrar seleccionados en un checkbox
    public static function getCheckboxPayments($customer_id, $payments_array, $custom_app_key) {
        \Log::info('getCheckboxPayments'.json_encode($payments_array));
        $payments = \Solunes\Payments\App\Payment::whereIn('id', $payments_array)->get();
        if(count($payments)>0){
            $items = [];
            foreach($payments as $payment){
                // Definir variables de pago en formato PagosTT: name, items[concepto, cantidad, costo_unitario]
                $item = [];
                $item['id'] = $payment->id;
                $item['name'] = $payment->name;
                $subitems_array = [];
                foreach($payment->payment_items as $payment_item){
                    if(config('customer.enable_test')==1){
                        $amount = 1;
                    } else {
                        $amount = $payment_item->price;
                    }
                    $extra_parameters = \Pagostt::getItemExtraParameters($payment_item);
                    $subitems_array[] = \Pagostt::generatePaymentItem($payment_item->name, $payment_item->quantity, $amount, $payment->invoice, $extra_parameters);
                }
                if(config('services.enable_test')==1){
                    $item['amount'] = count($payment->payment_items);
                } else {
                    $item['amount'] = $payment->amount;
                }
                $item['items'] = $subitems_array;
                $items[$payment->id] = $item;
            }
            $array['pending_payments'] = $items;
            $array['payment']['name'] = 'Múltiples pagos seleccionados';
            $array['payment']['has_invoice'] = $payment->invoice;
            //$array['payment']['metadata'][] = \Pagostt::generatePaymentMetadata('Tipo de Cambio', $payment->exchange);
            $array['payment'] = \Pagostt::paymentAddPaymentInvoice($array['payment'], $payment);
            return $array;
        } else {
            return NULL;
        }
    }

    // Bridge: Procesar pagos dentro del sistema luego de que la transacción fue procesada correctamente
    public static function transactionSuccesful($transaction) {
        $date = date('Y-m-d');
        if($transaction&&$transaction->status=='paid'){
            foreach($transaction->transaction_payments as $transaction_payment){
                $transaction_payment->processed = 1;
                $transaction_payment->save();
                $payment = $transaction_payment->payment;
                if($transaction_invoice = $transaction->transaction_invoice){
                    $payment->invoice = 1;
                    $payment->invoice_name = $transaction_invoice->customer_name;
                    $payment->invoice_nit = $transaction_invoice->customer_nit;
                    $payment->invoice_url = $transaction_invoice->invoice_url;
                }
                $payment->status = 'paid';
                $payment->payment_date = $date;
                $payment->save();
                if(config('solunes.sales')&&$sale_payment = $payment->sale_payment){
                  if($sale_payment->status!='paid'){
                    $sale_payment->status = 'paid';
                    $sale_payment->pending_amount = $sale_payment->pending_amount - $payment->amount;
                    $sale_payment->save();
                    $sale = $sale_payment->parent;
                    $sale->paid_amount = $payment->real_amount;
                    $sale->status = 'paid';
                    $sale->save();
                    if(config('solunes.inventory')){
                        \Inventory::successful_sale($sale, $sale_payment);
                    }
                  }
                }
                if(config('customer.custom_successful_payment')){
                    \CustomFunc::customer_successful_payment($payment);
                }
            }
            return true;
        } else {
            return false;
        }
    }
    
    // Obtener datos de pago en caja
    public static function cashierPaymentData($user) {
        $sucursal = $user->id;
        $usuario  = $user->name;
        return ['sucursal'=>$sucursal, 'usuario'=>$usuario];
    }

    // Crear Actividad de Cliente   // $type = general, registration, login, contact, action
    public static function createCustomerActivity($customer, $type, $name, $detail = NULL) {
        $customer_activity = new \Solunes\Customer\App\CustomerActivity;
        $customer_activity->parent_id = $customer->id;
        $customer_activity->type = $type;
        $customer_activity->name = $name;
        $customer_activity->detail = $detail;
        $customer_activity->date = date('Y-m-d');
        $customer_activity->time = date('H:i:s');
        $customer_activity->save();
    }

    public static function checkExternalCustomerById($external_id) {
        $api = app('\Solunes\Customer\App\Controllers\WebServiceController')->getCustomerByExternalId($external_id);
        if($api){
            return true;
        } else {
            return false;
        }
    }

    public static function checkExternalCustomerByParameters($request) {
        $api = app('\Solunes\Customer\App\Controllers\WebServiceController')->getCustomerByParameters($request->input('email'), $request->input('ci_number'), $request->input('cellphone'));
        if($api){
            return true;
        } else {
            return false;
        }
    }
      
    public static function registerExternalCustomer($request) {
        $api = app('\Solunes\Customer\App\Controllers\WebServiceController')->registerCustomer($request->input('email'), $request->input('ci_number'), $request->input('cellphone'), $request->input('birth_date'), $request->input('first_name'), $request->input('last_name'), $request->input('ci_expedition'), $request->input('address'), $request->input('nit_number'), $request->input('nit_name'), $request->input('password'));
        if($api){
            return $api->id;
        } else {
            return null;
        }
    }
      
    public static function updateExternalCustomer($external_id, $request) {
        $api = app('\Solunes\Customer\App\Controllers\WebServiceController')->updateCustomerData($external_id, $request->input('email'), $request->input('ci_number'), $request->input('cellphone'), $request->input('birth_date'), $request->input('first_name'), $request->input('last_name'), $request->input('ci_expedition'), $request->input('address'), $request->input('nit_number'), $request->input('nit_name'), $request->input('password'));
        if($api){
            return true;
        } else {
            return false;
        }
    }

}