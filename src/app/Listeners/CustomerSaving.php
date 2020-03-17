<?php

namespace Solunes\Customer\App\Listeners;

class CustomerSaving {

    public function handle($event) {
        $user = $user_email_check = $user_username_check = $user_cellphone_check = NULL;
        $full_name = $event->first_name.' '.$event->last_name;
        if(!$event->user_id&&config('customer.different_customers_by_agency')){
            $user_email_check = \App\User::whereNotNull('email')->where('agency_id',$event->agency_id)->where('email',$event->email)->first();
            if($user_email_check){
                $user = $user_email_check;
            } else {
                $user_username_check = \App\User::whereNotNull('username')->where('agency_id',$event->agency_id)->where('username',$event->ci_number)->first();
            }
            if($user_username_check){
                $user = $user_username_check;
            } else {
                $user_cellphone_check = \App\User::whereNotNull('cellphone')->where('agency_id',$event->agency_id)->where('cellphone',$event->cellphone)->first();
            }
            if($user_cellphone_check){
                $user = $user_cellphone_check;
            }
            if(!$event->agency_id&&auth()->check()){
                $admin_user = auth()->user();
                $event->agency_id = $admin_user->agency_id;
            }
        } else if(!$event->user_id){
            $user_email_check = \App\User::whereNotNull('email')->where('email',$event->email)->first();
            if($user_email_check){
                $user = $user_email_check;
            } else {
                $user_username_check = \App\User::whereNotNull('username')->where('username',$event->ci_number)->first();
            }
            if($user_username_check){
                $user = $user_username_check;
            } else {
                $user_cellphone_check = \App\User::whereNotNull('cellphone')->where('cellphone',$event->cellphone)->first();
            }
            if($user_cellphone_check){
                $user = $user_cellphone_check;
            }
        } else {
            $user = $event->user;
        }
        if(!$event->status){
            $event->status = 'normal';
        }
        if(!$user){
            if(!$event->password&&config('customer.default_password')){
                $password = config('customer.default_password');
            } else if(!$event->password){
                $password = rand(100000,999999);
            } else {
                $password = $event->password;
            }
            $user = new \App\User;
            $user->name = $full_name;
            if(!$user_email_check){
                $user->email = $event->email;
            }
           if(!$user_cellphone_check){
                $user->cellphone = $event->cellphone;
            }
            $user->username = $event->ci_number;
            $user->password = $password;
            if(config('sales.delivery_city')){
              $user->city_id = $event->city_id;
              $user->city_other = $event->city_other;
            }
            if(config('sales.ask_address')){
              $user->address = $event->address;
              $user->address_extra = $event->address_extra;
            }
            if(config('customer.different_customers_by_agency')){
              $user->agency_id = $event->agency_id;
            }
            $user->status = $event->status;
            $user->save();
            $user->role_user()->attach(2); // Agregar como miembro
        } else {
            if($user->name!=$full_name){
                $user->name = $full_name;
            }
            if(config('customer.different_customers_by_agency')){
                if(!$user->email&&!\App\User::where('email', $event->email)->where('agency_id', $event->agency_id)->first()){
                    $user->email = $event->email;
                }
                if(!$user->cellphone&&!\App\User::where('cellphone', $event->cellphone)->where('agency_id', $event->agency_id)->first()){
                    $user->cellphone = $event->cellphone;
                }
                if(!$user->username&&!\App\User::where('username', $event->ci_number)->where('agency_id', $event->agency_id)->first()){
                    $user->username = $event->ci_number;
                }
            } else {
                if(!$user->email&&!\App\User::where('email', $event->email)->first()){
                    $user->email = $event->email;
                }
                if(!$user->cellphone&&!\App\User::where('cellphone', $event->cellphone)->first()){
                    $user->cellphone = $event->cellphone;
                }
                if(!$user->username&&!\App\User::where('username', $event->ci_number)->first()){
                    $user->username = $event->ci_number;
                }
            }
            if(config('sales.delivery_city')){
              $user->city_id = $event->city_id;
              $user->city_other = $event->city_other;
            }
            if(config('sales.ask_address')){
              $user->address = $event->address;
              $user->address_extra = $event->address_extra;
            }
            if($event->password){
                $user->password = $event->password;
            }
            if($event->password&&$user->status=='ask_password'){
                $user->status = 'normal';
                $event->status = 'normal';
            }
            $user->save();
        }
        if($event->status=='normal'||$event->status=='ask_password'){
            $event->active = 1;
        } else {
            $event->active = 0;
        }
        if(!$event->user_id){
            $event->user_id = $user->id;
        }
        if($event->password){
            $event->password = NULL;
        }
        if(config('customer.seller_user')){
            if(auth()->check()){
                $event->seller_user_id = auth()->user()->id;
            }
        }
        if(config('customer.customer_agency')&&!$event->agency_id){
            if(auth()->check()&&$agency_id = auth()->user()->agency_id){
                $event->agency_id = $agency_id;
            }
        }
        $event->name = $full_name;
        if(config('customer.tracking')&&$event->id){
            \Customer::createCustomerActivity($event, 'update', 'El perfil del usuario fue modificado.');
        }
        return $event;
    }

}