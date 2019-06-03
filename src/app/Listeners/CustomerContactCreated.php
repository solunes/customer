<?php

namespace Solunes\Customer\App\Listeners;

class CustomerContactCreated {

    public function handle($event) {
        if(config('customer.tracking')){
        	\Customer::createCustomerActivity($event->customer, 'general', 'Se generó una cita de contacto para el '.$event->date.' a horas '.$event->time.'.');
        }
        return $event;
    }

}