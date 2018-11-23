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

class CustomAdminController extends Controller {

	protected $request;
	protected $url;

	public function __construct(UrlGenerator $url) {
      $this->middleware('auth');
      //$this->middleware('permission:dashboard');
	  $this->prev = $url->previous();
      $this->module = 'custom-admin';
	}

	public function getRedirect() {
		if(!auth()->check()){
			return redirect('auth/login')->with('message_error','Debe iniciar sesión.');
		}
		$user = auth()->user();
		if(!$user->customer){
			return redirect('admin/model-list/payment')->with('message_success','Inició sesión como administrador.');
		}
		return redirect('admin/my-payments')->with('message_success','Inició sesión correctamente, a continuación sus pagos pendientes.');
	}

	public function getMyAccounts() {
		$user = auth()->user();
		$customers = $user->customers;
		$array = ['customers'=>$customers];
		return view('customer::content.my-accounts', $array);
	}

	public function postEditPassword(Request $request) {
		$user = auth()->user();
		if($user->customer){
			$customer = $user->customer;
			$rules = \Solunes\Customer\App\Customer::$rules_password;
	        $validator = \Validator::make($request->all(), $rules);
	        if($validator->passes()) {
	        	$customer->password = $request->input('password');
	        	$customer->save();
	        	$user = $customer->user;
	        	$user->password = $request->input('password');
	        	$user->save();
	        	return redirect($this->prev)->with('message_success', 'Su contraseña fue editada correctamente.');
			} else {
				return redirect($this->prev)->with('message_error', 'Debe llenar todos los campos.')->withInput();
			}
		} else {
			return redirect($this->prev)->with('message_error', 'No tiene una cuenta asociada.');
		}
	}

	public function getMyAccount($customer_id = NULL) {
		$user = auth()->user();
		$dependants = false;
		if($customer = $user->customers()->where('id',$customer_id)->first()){

		} else {
			$customer = NULL;
			return redirect('admin')->with('message_error', 'Su cuenta no tiene un cliente asociado.');
		}
		$expeditions = ['LP'=>'LP','SC'=>'SC','CB'=>'CB','CH'=>'CH','PO'=>'PO','OR'=>'OR','TA'=>'TA','BE'=>'BE','PA'=>'PA','EXTRANJERO'=>'EXTRANJERO'];
		$array = ['customer'=>$customer,'action'=>$action,'expeditions'=>$expeditions];
		return view('content.my-account', $array);
	}

	public function postEditAccount(Request $request) {
		$user = auth()->user();
		if($customer = $user->customers()->where('id', $request->input('customer_id'))->first()){
			$rules = \Solunes\Customer\App\Customer::$rules_send;
	        $validator = \Validator::make($request->all(), $rules);
	        if($validator->passes()&&$customer) {
	        	$customer->first_name = mb_strtoupper($request->input('first_name'), 'UTF-8');
	        	$customer->last_name = mb_strtoupper($request->input('last_name'), 'UTF-8');
	        	$customer->email = $request->input('email');
	        	$customer->phone = $request->input('phone');
	        	$customer->cellphone = $request->input('cellphone');
		        $customer->nit_number = $request->input('nit_number');
		        $customer->nit_name = $request->input('nit_name');
	        	$customer->birth_date = $request->input('birth_date');
	        	if(config('customer.fields.city')||config('sales.delivery_city')){
	        		$customer->city_id = $request->input('city_id');
	        		$customer->city_other = $request->input('city_other');
	        	}
	        	if(config('customer.fields.address')||config('sales.ask_address')){
	        		$customer->address = $request->input('address');
	        		$customer->address_extra = $request->input('address_extra');
	        	}
	        	$customer->save();
	        	return redirect($this->prev)->with('message_success', 'Su cuenta fue editada correctamente.');
			} else {
				return redirect($this->prev)->with('message_error', 'Debe llenar todos los campos.')->withInput();
			}
		} else {
			return redirect($this->prev)->with('message_error', 'No tiene una cuenta asociada.');
		}
	}

	public function getMyDependants() {
		$user = auth()->user();
		$customers = $user->customers;
		$array = ['customers'=>$customers];
		return view('content.my-dependants', $array);
	}

	public function getMyPayments() {
		$array['items'] = [];
		$user = auth()->user();
		if(count($user->customers)>0){
			foreach($user->customers as $customer){
				$array['items'][] = ['customer'=>$customer,'payments'=>$customer->pending_payments];
			}
		}
		return view('customer::content.my-payments', $array);
	}

	public function getMyHistory() {
		$array['items'] = [];
		$user = auth()->user();
		if(count($user->customers)>0){
			foreach($user->customers as $customer){
				$array['items'][] = ['customer'=>$customer,'payments'=>$customer->paid_payments];
			}
		}
		return view('customer::content.my-history', $array);
	}
     
 	public function getManualLogin($customer_id) {
		if($item = \Solunes\Customer\App\Customer::find($customer_id)){
			auth()->login($item->user);
			return redirect('admin/my-payments')->with('message_success', 'Sesión cambiada correctamente.');
		}
		return redirect($this->prev)->with('message_success', 'Hubo un error al cambiar su sesión.');
	}

	public function getCustomerList() {
		$array['items'] = \Solunes\Customer\App\Customer::get();
		return view('customer::content.customer-lists', $array);
	}

}