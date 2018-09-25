<?php

namespace Solunes\Customer\App\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use AdminItem;

class WebServiceController extends Controller {

  public function __construct()
  {
    $this->url = config('customer.main_server_url');
    $this->appKey = config('customer.main_server_app_key');
    //$this->appKey = '61b7109893d07a55bccb86e6a5817a1cb9ad5c6d';//TEST
    //$this->appKey = '47cbc6941fa4375702adb15d49cb1c0b9fb93b75';// PRODUCTION
    $this->userString = 'app_key='.$this->appKey;
    $this->userParameters = ['app_key'=>$this->appKey];
  }

  public function processResponse($response, $action) {
    //if($action!='deudaslpg'){
      \Log::info('Before Process: '.$action.' - '.json_encode($response));
    //}
    $array = json_decode($response, true);
    if($array['status']==200){
      return $array['response'];
    } else if($array['status']==400&&$array['msg']){
      return 'Error: Status de respuesta 400: '.$array['msg'];
    }
  }

  public function processGet($action, $parameters) {
    $url = $this->url.$action; // asmx URL of WSDL

    $url .= '?'.$this->userString;
    foreach($parameters as $parameter_key => $parameter_val){
      $url .= '&'.$parameter_key.'='.$parameter_val;
    }

    $headers = array("Content-type: application/json;charset=\"utf-8\"");

    // PHP cURL  for https connection with auth
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_POST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    //if($action!='deudaslpg'){
      \Log::info('WS URL: '.$action.' - '.$url);
    //}

    // converting
    $response = curl_exec($ch); 
    curl_close($ch);

    //if($action!='deudaslpg'){
      \Log::info('WS Response: '.$action.' - '.json_encode($response));
    //}

    return $this->processResponse($response, $action);
  }

  public function processPost($action, $parameters) {
    $url = $this->url.$action; // asmx URL of WSDL

    $fields = $this->userString;
    $count = 0;
    foreach($parameters as $parameter_key => $parameter_val){
      $fields .= '&'.$parameter_key.'='.$parameter_val;
    }

    $headers = array("Content-type: application/json;charset=\"utf-8\"");

    // PHP cURL  for https connection with auth
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    //if($action!='deudaslpg'){
      \Log::info('WS URL: '.$action.' - '.$url.' - Post Fields: '.$fields);
    //}

    // converting
    $response = curl_exec($ch); 
    curl_close($ch);

    //if($action!='deudaslpg'){
      \Log::info('WS Response: '.$action.' - '.json_encode($response));
    //}

    return $this->processResponse($response, $action);
  }

  public function getCustomerByParameters($email, $ci_number, $cellphone) {
    $array = $this->processGet('customer-by-parameters', ['email'=>$email,'ci_number'=>$ci_number,'cellphone'=>$cellphone]);
    return $array;
  }

  public function getCustomerByExternalId($external_id) {
    $array = $this->processGet('customer-by-external-id', ['external_id'=>$external_id]);
    return $array;
  }

  public function registerCustomer($email, $ci_number, $cellphone, $birth_date, $first_name, $last_name, $ci_expedition, $address, $nit_number, $nit_name, $password) {
    $array = $this->processPost('register-customer', ['email'=>$email,'ci_number'=>$ci_number,'cellphone'=>$cellphone,'birth_date'=>$birth_date,'first_name'=>$first_name,'last_name'=>$last_name,'ci_expedition'=>$ci_expedition,'address'=>$address,'nit_number'=>$nit_number,'nit_name'=>$nit_name,'password'=>$password]);
    return $array;
  }

  public function updateCustomerData($external_id, $email, $ci_number, $cellphone, $birth_date, $first_name, $last_name, $ci_expedition, $address, $nit_number, $nit_name, $password) {
    $array = $this->processPost('update-customer-data', ['external_id'=>$external_id,'email'=>$email,'ci_number'=>$ci_number,'cellphone'=>$cellphone,'birth_date'=>$birth_date,'first_name'=>$first_name,'last_name'=>$last_name,'ci_expedition'=>$ci_expedition,'address'=>$address,'nit_number'=>$nit_number,'nit_name'=>$nit_name,'password'=>$password]);
    return $array;
  }

}