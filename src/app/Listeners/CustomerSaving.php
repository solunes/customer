<?php

namespace Solunes\Customer\App\Listeners;

class CustomerSaving {

    public function handle($event) {
        $full_name = $event->first_name.' '.$event->last_name;
        $user = \App\User::Where('username',$event->ci_number)->first();
        $user_email_check = \App\User::where('email',$event->email)->first();
        $user_cellphone_check = \App\User::where('cellphone',$event->cellphone)->first();
        if(!$user){
            if(!$event->password){
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
            $user->save();
            $user->role_user()->attach(2); // Agregar como miembro
        } else {
            if($user->name!=$full_name){
                $user->name = $full_name;
            }
            if(!$user->email&&!\App\User::where('email', $event->email)->first()){
                $user->email = $event->email;
            }
            if(!$user->cellphone&&!\App\User::where('cellphone', $event->cellphone)->first()){
                $user->cellphone = $event->cellphone;
            }
            if(!$user->username&&!\App\User::where('username', $event->ci_number)->first()){
                $user->username = $event->ci_number;
            }
            if(config('sales.delivery_city')){
              $user->city_id = $event->city_id;
              $user->city_other = $event->city_other;
            }
            if(config('sales.ask_address')){
              $user->address = $event->address;
              $user->address_extra = $event->address_extra;
            }
            $user->save();
        }
        if(!$event->user_id){
            $event->user_id = $user->id;
        }
        if($event->password){
            $event->password = NULL;
        }
        $event->name = $full_name;
        return $event;
    }

}