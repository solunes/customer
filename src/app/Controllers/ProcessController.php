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
            $fields_array[] = 'password_confirmation';
        }
        if(config('customer.fields.member_code')){
            $fields_array[] = 'member_code';
        }
        if(config('customer.fields.shirt')){
            $fields_array[] = 'shirt';
        }
        if(config('customer.fields.shirt_size')){
            $fields_array[] = 'shirt_size';
        }
        if(config('customer.fields.invoice_data')){
            $fields_array[] = 'nit_name';
            $fields_array[] = 'nit_number';
        }
        if(config('customer.fields.emergency_long')){
            $fields_array[] = 'emergency_name';
            $fields_array[] = 'emergency_number';
        }
        $fields_array = array_merge($fields_array, ['ci_number','ci_expedition','first_name','last_name','email','cellphone','address','birth_date']);
	    $rules = \Customer::validateRegister($fields_array);
        if(config('customer.fields.password')){
	    	$rules['password'] = 'required|confirmed';
	    }
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
	      if($existing_customer = \Solunes\Customer\App\Customer::where('ci_number', $ci_number)->first()){
	      	if($existing_customer->user&&$existing_customer->team_customers()->where('team_id', $request->input('team_id'))->count()>0){
	      	  auth()->login($existing_customer->user);
	          return redirect('admin/my-payments')->with('message_success', 'Usted ya se encuentra registrado en este torneo con este equipo. Le recomendamos realizar su pago aquí.')->withInput();
	      	}
	      }
	      $array = [];
	      foreach($fields_array as $key => $val){
	      	if(!in_array($val, ['password_confirmation','ci_number','email','age'])){
	        	$array[$val] = $request->input($val);
	      	}
	      }
	      $customer = \Customer::generateCustomer($ci_number, $email, $array, $password);
          if(config('customer.custom.after_register')){
            $customer = \CustomFunc::customerCustomAfterRegister($customer, $password);
          }
	      \Auth::login($customer->user);
	      \Customer::sendConfirmationEmail($customer);
	      return redirect('admin/finish-registration')->with('message_success', 'Felicidades, su registro fue realizado correctamente. Ahora finalice su registro y realice el pago para finalizar.');
	    } else {
	      return redirect($this->prev)->with(array('message_error' => 'Debe llenar todos los campos para finalizar'))->withErrors($validator)->withInput();
	    }
    }

    public function getCheckCi($ci_number) {
	    if($customer = \Solunes\Customer\App\Customer::where('ci_number', $ci_number)->first()){
	      // Send Mail
	      return ['exists'=>true, 'customer'=>$customer->toArray()];
	    } else {
	      return ['exists'=>false, 'customer'=>NULL];
	    }
    }

    public function getLogin($token) {
	    $array['page'] = \Solunes\Master\App\Page::find(1);
	    return view('customer::process.login', $array);
    }

    public function getRecoverPassword($token) {
	    $array['page'] = \Solunes\Master\App\Page::find(1);
	    return view('customer::process.recover-password', $array);
    }

    public function postRecoverPassword(Request $request) {
      $error_messages = array('email.exists' => trans('master::form.email_exists_error'));
      $redirect = $this->prev;
      $rules = \App\PasswordReminder::$rules_reminder;
      // Añadir regla de comprobación Captcha si corresponde
      if(config('solunes.nocaptcha_login')){
        $rules['g-recaptcha-response'] = 'required|captcha';
      }
      $validator = Validator::make($request->all(), $rules, $error_messages);
      if ($validator->passes()) {
        $email = $request->input('email');
        if($request->segment(1)=='password'&&$request->segment(2)=='recover'){
          $redirect = 'auth/login';
        }
        return Login::pass_recover_success($email, $redirect, trans('master::form.password_request_success'), 60);
      } else {
        return Login::failed_try($validator, $this->prev, trans('master::form.password_request_error'));
      }
    }

    public function getResetPassword($token) {
      if (is_null($token)) return redirect('password/forget')->with('message_error', trans('master::form.password_reset_error'));
      if (\App\PasswordReminder::where('token', $token)->count()>0) {
        $array = ['token'=>$token];
	    return view('customer::process.reset-password', $array);
      } else {
        return Login::failed_try(NULL, 'password/recover', trans('master::form.password_reset_error'));
      }
    }

    public function postResetPassword(Request $request) {
      $error_messages = array('reminder_password.confirmed' => trans('master::form.password_match_error'));
      $token = $request->input('token');
      $validator = Validator::make($request->all(), \App\User::$rules_edit_pass, $error_messages);
      if ($validator->passes()) {
        $now = new \DateTime();
        if ((\App\PasswordReminder::where('token', $token)->count()>0)&&(\App\PasswordReminder::where('token', $token)->first()->created_at<$now)) {
          $email = \App\PasswordReminder::where('token', $token)->first()->email;
          \App\User::where('email', $email)->update(array('password' => bcrypt($request->input('password'))));
          \App\PasswordReminder::where('token', $token)->delete();
          return redirect('auth/login')->with('message_success', trans('master::form.password_reset_success'));        
        } else {
          return Login::failed_try($validator, 'password/recover', trans('master::form.password_reset_error'));
        }
      } else {
          return redirect($this->prev)->with('message_error', trans('master::form.password_not_edited'))->withErrors($validator)->withInput();
      }
    }

    public function getChangePassword($token) {
	    $array['page'] = \Solunes\Master\App\Page::find(1);
	    if(!auth()->check()){
	    	return redirect($this->prev)->with('message_error', 'Debe tener una sesión activa.');
	    }
	    $user = \Auth::user();
	    $array['user'] = $user;
	    return view('customer::process.change-password', $array);
    }

    public function postChangePassword(Request $request) {
    	$user = \Auth::user();
	    if($customer = $user->customer&&$request->has('password')&&$request->has('confirm_password')){ 
	      if(strlen($request->input('password'))<6&&strlen($request->input('confirm_password'))<6){
	      	return redirect($this->prev)->with(array('message_error' => 'Su contraseña debe tener al menos 6 carácteres.'))->withErrors($validator)->withInput();
	      } else if($request->input('password')!=$request->input('confirm_password')){
	      	return redirect($this->prev)->with(array('message_error' => 'Su contraseña no es igual en ambos campos.'))->withErrors($validator)->withInput();
	      }
	      $customer->password = $request->input('password');
	      $customer->save();
	      return redirect($this->prev)->with('message_success', 'Felicidades, su contraseña fue cambiada correctamente.');
	    } else {
	      return redirect($this->prev)->with(array('message_error' => 'Debe llenar todos los campos para finalizar'));
	    }
    }

    public function getMyAccount($token) {
	    $user = auth()->user();
	    $array['page'] = \Solunes\Master\App\Page::find(1);
	    $array['user'] = $user;
	    return view('customer::process.my-account', $array);
    }

}