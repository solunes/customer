<?php

namespace Solunes\Customer\App\Listeners;

class CustomerContactCreating {

    public function handle($event) {
        if(!$event->user_id&&auth()->check()){
            $event->user_id = auth()->user()->id;
        }
        if(config('customer.seller_user')){
            $event->seller_user_id = $event->parent->seller_user_id;
        }
        return $event;
    }

}