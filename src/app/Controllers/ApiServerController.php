<?php

namespace Solunes\Customer\App\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use AdminItem;

class ApiServerController extends Controller {

    public function __construct()
    {
        $this->appKey = config('customer.main_server_app_key');
        //$this->appKey = '61b7109893d07a55bccb86e6a5817a1cb9ad5c6d';//TEST
        //$this->appKey = '47cbc6941fa4375702adb15d49cb1c0b9fb93b75';// PRODUCTION
    }

    public function getCustomerById($customer_id) {
        if($customer = \Solunes\Customer\App\Customer::find($customer_id)){
            $customer = $customer->toArray();
            unset($customer['member_code']);
            return $customer;
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException('No se encontró un cliente con este ID.');
        }
    }

    public function getCustomerByParameters($ci_number, $email, $phone) {
        if($customer = \Solunes\Customer\App\Customer::where('ci_number', $ci_number)->orWhere('email', $email)->orWhere('phone', $phone)->first()){
            $customer = $customer->toArray();
            unset($customer['member_code']);
            return $customer;
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException('No se encontró un cliente con este carnet de identidad, email o teléfono.');
        }
    }

    public function registerCustomer(Request $request) {
        $customer_id = $request->input('external_id');
        if($customer = \Solunes\Customer\App\Customer::find($customer_id)){
            $customer->first_name = $request->input('first_name');
            $customer->last_name = $request->input('last_name');
            $customer->email = $request->input('email');
            $customer->phone = $request->input('phone');
            $customer->ci_number = $request->input('ci_number');
            $customer->ci_expedition = $request->input('ci_expedition');
            $customer->address = $request->input('address');
            $customer->nit_number = $request->input('nit_number');
            $customer->nit_name = $request->input('nit_name');
            $customer->birth_date = $request->input('birth_date');
            $customer->save();
            $customer = $customer->toArray();
            unset($customer['member_code']);
            return $customer;
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException('No se pudo actualizar los datos de cliente.');
        }
    }

    public function updateCustomerData(Request $request) {
        $customer_id = $request->input('external_id');
        if($customer = \Solunes\Customer\App\Customer::find($customer_id)){
            $customer->first_name = $request->input('first_name');
            $customer->last_name = $request->input('last_name');
            $customer->email = $request->input('email');
            $customer->phone = $request->input('phone');
            $customer->ci_number = $request->input('ci_number');
            $customer->ci_expedition = $request->input('ci_expedition');
            $customer->address = $request->input('address');
            $customer->nit_number = $request->input('nit_number');
            $customer->nit_name = $request->input('nit_name');
            $customer->birth_date = $request->input('birth_date');
            $customer->save();
            $customer = $customer->toArray();
            unset($customer['member_code']);
            return $customer;
        } else {
            throw new \Symfony\Component\HttpKernel\Exception\NotAcceptableHttpException('No se pudo actualizar los datos de cliente.');
        }
    }

}