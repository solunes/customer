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
      $fields_array = array_merge($fields_array, ['ci_number','first_name','last_name','email','cellphone']);
      $rules = \Customer::validateRegister($fields_array);
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
        if($existing_customer = \Solunes\Customer\App\Customer::where('ci_number', $ci_number)->where('email', $email)->first()){
          return redirect($this->prev)->with('message_error', 'Usted ya tiene una cuenta de usuario registrada, le recomendamos iniciar sesión.')->withInput();
        }
        $array = [];
        foreach($fields_array as $key => $val){
          if(!in_array($val, ['ci_number','email'])){
            $array[$val] = $request->input($val);
          }
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

    public function getRegister($token) {
      $array['page'] = \Solunes\Master\App\Page::find(1);
      return view('customer::process.register', $array);
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
        \Mail::send('customer::emails.reminder', ['token'=>$token, 'email'=>$email], function($m) use($email) {
            $m->to($email, 'User')->subject(config('solunes.app_name').' | '.trans('master::mail.remind_password_title'));
        });
        $message = trans('master::form.password_request_success');
        return redirect('account/recovered-password/cKeaDssbRd23m9Yb');
      } else {
        return \Login::failed_try($validator, $this->prev, trans('master::form.password_request_error'));
      }
    }

    public function getRecoveredPassword($token) {
      $array['page'] = \Solunes\Master\App\Page::find(1);
      return view('customer::process.recovered-password', $array);
    }

    public function getResetPassword($token) {
      if (is_null($token)) return redirect('account/recover-password/')->with('message_error', trans('master::form.password_reset_error'));
      if (\App\PasswordReminder::where('token', $token)->count()>0) {
        $array = ['token'=>$token];
        $array['page'] = \Solunes\Master\App\Page::find(1);
        return view('customer::process.reset-password', $array);
      } else {
        return \Login::failed_try(NULL, 'account/reset-password', trans('master::form.password_reset_error'));
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
          return redirect(config('customer.redirect_after_login'))->with('message_success', trans('master::form.password_reset_success'));        
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
      return view('customer::process.change-password', $array);
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
        return redirect($this->prev)->with('message_success', 'Felicidades, su contraseña fue cambiada correctamente.');
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
      return view('customer::process.my-account', $array);
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

}