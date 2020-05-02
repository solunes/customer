<?php

namespace Solunes\Customer\App\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;

use Validator;
use Asset;
use AdminList;
use AdminItem;
use PDF;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProcessController extends Controller {

  protected $request;
  protected $url;

  public function __construct(UrlGenerator $url) {
    $this->prev = $url->previous();
  }

    public function postRegistro(Request $request) {
      $fields_array = [];
      if(config('customer.fields.password')){
        $fields_array[] = 'password';
      }
      if(config('customer.fields.invoice_data')){
        $fields_array[] = 'nit_number';
        $fields_array[] = 'nit_name';
      }
      if(config('customer.fields.birth_date')){
        $fields_array[] = 'birth_date';
      }
      if(config('customer.fields.shirt')){
        $fields_array[] = 'shirt';
      }
      if(config('customer.fields.shirt_size')){
        $fields_array[] = 'shirt_size';
      }
      if(config('customer.fields.emergency_long')){
        $fields_array[] = 'emergency_name';
        $fields_array[] = 'emergency_number';
      }
      if(config('customer.fields.emergency_short')){
        $fields_array[] = 'emergency';
      }
      if(config('customer.different_customers_by_agency')){
        $fields_array[] = 'agency_token';
      }
      $fields_array = array_merge($fields_array, ['ci_number','first_name','last_name','email','cellphone']);
      $rules = config('customer.fields_rules');
      if(config('customer.custom.register_rules')){
          $rules = \CustomFunc::customerCustomRegisterRules($rules);
      }
      $validator = \Validator::make($request->all(), $rules);
      if(!$validator->fails()) {
        $ci_number = $request->input('ci_number');
        $email = $request->input('email');
        $password = NULL;
        if(config('customer.fields.password')){
          $password = $request->input('password');
        }
        $array = [];
        foreach($fields_array as $key => $val){
          if(config('customer.different_customers_by_agency')&&$val=='agency_token'){
            $agency = \Business::getAgencyByToken($request->input($val));
            if($agency){
              $array['agency_id'] = $agency->id;
            }
          } else if(!in_array($val, ['ci_number','email'])){
            $array[$val] = $request->input($val);
          }
        }
        $existing_customer = \Customer::checkCustomer($ci_number, $email, $array, $password);
        if($existing_customer){
          return redirect($this->prev)->with('message_error', 'Usted ya tiene una cuenta de usuario registrada, le recomendamos iniciar sesión.')->withInput();
        }
        $customer = \Customer::generateCustomer($ci_number, $email, $array, $password);
        if(config('customer.custom.after_register')){
          $customer = \CustomFunc::customerCustomAfterRegister($customer, $password, $request);
        }
        \Auth::login($customer->user);
        //\Customer::sendConfirmationEmail($customer);
        return redirect(config('customer.redirect_after_login'))->with('message_success', 'Felicidades, su registro fue realizado correctamente.');
      } else {
        return redirect($this->prev)->with(array('message_error' => 'Debe llenar todos los campos para finalizar'))->withErrors($validator)->withInput();
      }
    }

    public function getCheckCi($ci_number, $agency_token = NULL) {
      $agency = \Business::getAgencyByToken($agency_token);
      $customer = NULL;
      if(config('customer.different_customers_by_agency')&&$agency){
        $customer = \Solunes\Customer\App\Customer::where('agency_id', $agency->id)->where('ci_number', $ci_number)->first();
      } else if(!config('customer.different_customers_by_agency')) {
        $customer = \Solunes\Customer\App\Customer::where('ci_number', $ci_number)->first();
      }
      if($customer){
        // Send Mail
        return ['exists'=>true, 'customer'=>$customer->toArray()];
      } else {
        return ['exists'=>false, 'customer'=>NULL];
      }
    }

    public function getLogin($token, $agency_token = NULL) {
      $array['page'] = \Solunes\Master\App\Page::find(1);
      $array['token'] = $token;
      $array['agency_token'] = $agency_token;
      return view('customer::process.login-2', $array);
    }

    public function getRegister($token, $agency_token = NULL) {
      $array['page'] = \Solunes\Master\App\Page::find(1);
      $array['token'] = $token;
      $array['agency_token'] = $agency_token;
      return view('customer::process.register-2', $array);
    }

    public function getRecoverPassword($token, $agency_token = NULL) {
      $array['page'] = \Solunes\Master\App\Page::find(1);
      $array['token'] = $token;
      $array['agency_token'] = $agency_token;
      return view('customer::process.recover-password-2', $array);
    }

    public function postRecoverPassword(Request $request) {
      $error_messages = array('email.exists' => trans('master::form.email_exists_error'));
      $redirect = $this->prev;
      $rules = \App\PasswordReminder::$rules_reminder;
      // Añadir regla de comprobación Captcha si corresponde
      if(config('solunes.nocaptcha_login')){
        $rules['g-recaptcha-response'] = 'required|captcha';
      }
      if(config('customer.different_customers_by_agency')){
        $rules['agency_token'] = 'required';
        $agency = \Business::getAgencyByToken($request->input('agency_token'));
      } else {
        $agency = NULL;
      }
      \Log::info(json_encode($rules));
      $validator = Validator::make($request->all(), $rules, $error_messages);
      if ($validator->passes()) {
        $email = $request->input('email');
        $token = rand(1000000, 9999999);
        $now = new \DateTime();
        $now->add(new \DateInterval('PT1H'));
        $token = md5($email.rand());
        if (\App\PasswordReminder::where('email', $email)->count()>0) {
            \App\PasswordReminder::where('email', $email)->update(array('token'=>$token, 'created_at'=>$now));
        } else {
            $password_reminder = new \App\PasswordReminder;
            $password_reminder->email = $email;
            $password_reminder->token = $token;
            $password_reminder->created_at = $now;
            $password_reminder->save();
        }
        \Mail::send('customer::emails.reminder', ['token'=>$token, 'agency_token'=>$request->input('agency_token'), 'email'=>$email], function($m) use($email) {
            $m->to($email, 'User')->subject(config('solunes.app_name').' | '.trans('master::mail.remind_password_title'));
        });
        $message = trans('master::form.password_request_success');
        return redirect('account/recovered-password/'.config('customer.customers_token').'/'.$request->input('agency_token'));
      } else {
        return \Login::failed_try($validator, $this->prev, trans('master::form.password_request_error'));
      }
    }

    public function getRecoveredPassword($token, $agency_token = NULL) {
      $array['page'] = \Solunes\Master\App\Page::find(1);
      $array['token'] = $token;
      $array['agency_token'] = $agency_token;
      return view('customer::process.recovered-password-2', $array);
    }

    public function getResetPassword($token, $agency_token = NULL) {
      if (is_null($token)) return redirect('account/recover-password/'.$token.'/'.$agency_token)->with('message_error', trans('master::form.password_reset_error'));
      if (\App\PasswordReminder::where('token', $token)->count()>0) {
        $array = ['token'=>$token];
        $array['page'] = \Solunes\Master\App\Page::find(1);
        $array['agency_token'] = $agency_token;
        return view('customer::process.reset-password-2', $array);
      } else {
        return \Login::failed_try(NULL, 'account/recover-password/'.$token.'/'.$agency_token, trans('master::form.password_reset_error'));
      }
    }

    public function postResetPassword(Request $request) {
      $error_messages = array('reminder_password.confirmed' => trans('master::form.password_match_error'));
      $confirmation_token = $request->input('token');
      $validator = Validator::make($request->all(), \App\User::$rules_edit_pass, $error_messages);
      if ($validator->passes()) {
        $now = new \DateTime();
        if ((\App\PasswordReminder::where('token', $confirmation_token)->count()>0)&&(\App\PasswordReminder::where('token', $confirmation_token)->first()->created_at<$now)) {
          $email = \App\PasswordReminder::where('token', $confirmation_token)->first()->email;
          if(config('customer.different_customers_by_agency')){
            $agency = \Business::getAgencyByToken($request->input('agency_token'));
            if($agency){
              \App\User::where('agency_id', $email)->where('email', $email)->update(array('password' => bcrypt($request->input('password'))));
            } else {
              return \redirect($this->prev)->with('message_error', 'No se encontró una agencia con este código')->withErrors($validator)->withInput();
            }
          } else {
            \App\User::where('email', $email)->update(array('password' => bcrypt($request->input('password'))));
          }
          \App\PasswordReminder::where('token', $confirmation_token)->delete();
          return redirect('account/login/'.config('customer.customers_token').'/'.$request->input('agency_token'))->with('message_success', trans('master::form.password_reset_success'));        
        } else {
          return \Login::failed_try(NULL, $this->prev, trans('master::form.password_reset_error'));
        }
      } else {
          return \redirect($this->prev)->with('message_error', trans('master::form.password_not_edited'))->withErrors($validator)->withInput();
      }
    }

    public function getChangePassword($token) {
      $array['page'] = \Solunes\Master\App\Page::find(1);
      if(!auth()->check()){
        return redirect($this->prev)->with('message_error', 'Debe tener una sesión activa.');
      }
      $user = \Auth::user();
      $array['user'] = $user;
      if($customer = $user->customer){
        $array['customer'] = $customer;
      } else {
        $array['customer'] = NULL;
      }
      return view('customer::process.change-password-2', $array);
    }

    public function postChangePassword(Request $request) {
      $user = \Auth::user();
      $customer = $user->customer;
      if($customer&&$request->has('password')&&$request->has('confirm_password')){ 
        if(strlen($request->input('password'))<6&&strlen($request->input('confirm_password'))<6){
          return redirect($this->prev)->with(array('message_error' => 'Su contraseña debe tener al menos 6 carácteres.'))->withInput();
        } else if($request->input('password')!=$request->input('confirm_password')){
          return redirect($this->prev)->with(array('message_error' => 'Su contraseña no es igual en ambos campos.'))->withInput();
        }
        $customer->password = $request->input('password');
        $customer->save();
        return redirect(config('customer.redirect_after_login'))->with('message_success', 'Felicidades, su contraseña fue cambiada correctamente.');
      } else {
        return redirect($this->prev)->with(array('message_error' => 'Debe llenar todos los campos para finalizar'));
      }
    }

    public function getMyAccount($token) {
      $user = auth()->user();
      $array['page'] = \Solunes\Master\App\Page::find(1);
      $array['user'] = $user;
      if(config('customer.fields.city')){
        $array['cities'] = \Solunes\Business\App\City::get()->lists('name','id')->toArray();
      }
      $array['customer'] = $user->customer;
      if(!$array['customer']){
        return redirect($this->prev)->with('message_error', 'No tiene una cuenta de cliente vigente.');
      }
      return view('customer::process.my-account-2', $array);
    }

    public function getMyPayments($token) {
      $user = auth()->user();
      $array['page'] = \Solunes\Master\App\Page::find(1);
      $array['user'] = $user;
      if(config('customer.fields.city')){
        $array['cities'] = \Solunes\Business\App\City::get()->lists('name','id')->toArray();
      }
      $array['customer'] = $user->customer;
      if(!$array['customer']){
        return redirect($this->prev)->with('message_error', 'No tiene una cuenta de cliente vigente.');
      }
      return view('customer::process.my-payments-2', $array);
    }

    public function getMyCustomerPayments($token) {
      $user = auth()->user();
      $array['page'] = \Solunes\Master\App\Page::find(1);
      $array['user'] = $user;
      if(config('customer.fields.city')){
        $array['cities'] = \Solunes\Business\App\City::get()->lists('name','id')->toArray();
      }
      $array['customer'] = $user->customer;
      if(!$array['customer']){
        return redirect($this->prev)->with('message_error', 'No tiene una cuenta de cliente vigente.');
      }
      return view('customer::process.my-customer-payments-2', $array);
    }

    public function getMyHystory($token) {
      $user = auth()->user();
      $array['page'] = \Solunes\Master\App\Page::find(1);
      $array['user'] = $user;
      if(config('customer.fields.city')){
        $array['cities'] = \Solunes\Business\App\City::get()->lists('name','id')->toArray();
      }
      $array['customer'] = $user->customer;
      if(!$array['customer']){
        return redirect($this->prev)->with('message_error', 'No tiene una cuenta de cliente vigente.');
      }
      return view('customer::process.my-history-2', $array);
    }

    public function postEditCustomer(Request $request) {
      $user = \Auth::user();
      $customer = $user->customer;
      if($customer&&$request->has('first_name')&&$request->has('last_name')){ 
        $customer->first_name = $request->input('first_name');
        $customer->last_name = $request->input('last_name');
        if(config('customer.fields.city')){
          $customer->city_id = $request->input('city_id');
        }
        if(config('customer.fields.address')){
          $customer->address = $request->input('address');
        }
        if(config('customer.fields.invoice_data')){
          $customer->nit_number = $request->input('nit_number');
          $customer->nit_name = $request->input('nit_name');
        }
        $customer->save();
        return redirect($this->prev)->with('message_success', 'Felicidades, sus datos fueron editados correctamente.');
      } else {
        return redirect($this->prev)->with(array('message_error' => 'Debe llenar todos los campos para finalizar'));
      }
    }

    public function postEditImage(Request $request) {
      if(auth()->check()&&$request->hasFile('image')){
        $user = auth()->user();
        if($customer = $user->customer){
          $customer->image = \Asset::upload_image($request->file('image'), 'customer-image');
          $customer->save();
          return redirect($this->prev)->with('message_success', 'Su imagen fue subida correctamente.');
        }

        return redirect($this->prev)->with('message_error', 'No tiene una cuenta de cliente asociada.');
      } else {
        return redirect($this->prev)->with('message_error', 'Debe cargar una imagen válida.');
      }
    }

    public function getDeleteImage($token) {
      if(auth()->check()){
        $user = auth()->user();
        if($customer = $user->customer){
          $customer->image = NULL;
          $customer->save();
          return redirect($this->prev)->with('message_success', 'Su imagen fue eliminada correctamente.');
        }

        return redirect($this->prev)->with('message_error', 'No tiene una cuenta de cliente asociada.');
      } else {
        return redirect($this->prev)->with('message_error', 'Hubo un error al eliminar su foto de perfil.');
      }
    }

    public function getCheckCustomerContact($customer_contact_id) {
      if($customer_contact = \Solunes\Customer\App\CustomerContact::where('triggered', 0)->where('date',date('Y-m-d'))->where('id', $customer_contact_id)->first()){
        if($customer_contact->user){
          $customer = $customer_contact->parent;
          $to_array = [$customer_contact->user->email];
          $vars = ['@customer_name@'=>$customer->name, '@cellphone@'=>$customer->cellphone, '@email@'=>$customer->email, '@date@'=>$customer_contact->date, '@time@'=>$customer_contact->time];
          \FuncNode::make_email('customer-contact-reminder', $to_array, $vars);
        }
        return ['triggered'=>true];
      } else {
        return ['triggered'=>false];
      }
    }

    public function getMySubscriptions($token) {
      $user = auth()->user();
      $customer = $user->customer;
      $array['page'] = \Solunes\Master\App\Page::find(1);
      $array['items'] = $customer->customer_subscriptions;
      return view('customer::process.my-subscriptions', $array);
    }

    public function getSubscriptions($subscription_id, $token) {
      $user = auth()->user();
      $array['page'] = \Solunes\Master\App\Page::find(1);
      $array['subscription'] = \Solunes\Customer\App\Subscription::find($subscription_id);
      if($array['subscription']){
        $array['type'] = 'subscription-plan';
        $array['items'] = \Solunes\Customer\App\SubscriptionPlan::where('parent_id', $subscription_id)->get();
      } else {
        $array['type'] = 'subscription';
        $array['items'] = \Solunes\Customer\App\Subscription::get();
      }
      $array['currency'] = \Solunes\Business\App\Currency::where('type', 'main')->first();
      return view('customer::process.subscriptions', $array);
    }

    public function getAcceptSubscription($subscription_id, $subscription_plan_id) {
      $user = \Auth::user();
      $subscription = \Solunes\Customer\App\Subscription::find($subscription_id);
      $subscription_plan = \Solunes\Customer\App\SubscriptionPlan::where('parent_id', $subscription->id)->where('id', $subscription_plan_id)->first();
      $customer = $user->customer;
      if($customer&&$subscription&&$subscription_plan){ 
        $customer_subscription = \Solunes\Customer\App\CustomerSubscription::where('customer_id', $customer->id)->where('subscription_id', $subscription->id)->first();
        if($customer_subscription){
          if($customer_subscription_month = $customer_subscription->active_customer_subscription_month){
            $sale = $customer_subscription_month->sale;
            $sale->status = 'cancelled';
            $sale->save();
            $payment = $sale->sale_payment->payment;
            $payment->status = 'cancelled';
            $payment->save();
          }
          $customer_subscription->subscription_plan_id = $subscription_plan->id;
          $customer_subscription->save();
          if($customer_subscription->active){
            $initial_date = $customer_subscription->end_date;
          } else {
            $initial_date = date('Y-m-d');
          }
          $customer_subscription_month = new \Solunes\Customer\App\CustomerSubscriptionMonth;
          $customer_subscription_month->parent_id = $customer_subscription->id;
          $customer_subscription_month->subscription_id = $subscription->id;
          $customer_subscription_month->subscription_plan_id = $subscription_plan->id;
          $customer_subscription_month->initial_date = $initial_date;
          $customer_subscription_month->save();
          //$redirect = 'account/my-subscriptions/1354351278';
          $redirect = url('pagostt/make-single-payment/'.$customer_subscription->customer_id.'/'.$customer_subscription_month->sale->sale_payment->payment_id);
          return redirect($redirect)->with('message_success', 'Felicidades, su plan fue extendido para un nuevo periodo, ahora solo debe proceder con el pago.');
        } else {
          $customer_subscription = new \Solunes\Customer\App\CustomerSubscription;
          $customer_subscription->customer_id = $customer->id;
          $customer_subscription->subscription_id = $subscription->id;
          $customer_subscription->subscription_plan_id = $subscription_plan->id;
          $customer_subscription->name = $subscription->name;
          $customer_subscription->initial_date = date('Y-m-d');
          $customer_subscription->save();
          $customer_subscription->load('active_customer_subscription_month');
          if($customer_subscription_month = $customer_subscription->active_customer_subscription_month){
            $redirect = url('pagostt/make-single-payment/'.$customer_subscription->customer_id.'/'.$customer_subscription_month->sale->sale_payment->payment_id);
          } else {
            $redirect = 'account/my-subscriptions/1354351278';
          }
          return redirect($redirect)->with('message_success', 'Felicidades, su suscripción fue creada correctamente.');
        }
      } else {
        return redirect($this->prev)->with(array('message_error' => 'Debe llenar todos los campos para finalizar'));
      }
    }

}