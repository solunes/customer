<?php

namespace Solunes\Customer\App\Listeners;

class CustomerContactCreated {

    public function handle($event) {
    	if($event->status=='pending'&&$event->date>date('Y-m-d')){
    		// Generar notificacion
    		\External::generateTrigger('Contacto de Cliente: '.$event->parent->name, $event->date, $event->time, url('trigger/check-customer-contact/'.$event->id));
    	}
        if(config('customer.tracking')){
        	\Customer::createCustomerActivity($event->customer, 'general', 'Se generó una cita de contacto para el '.$event->date.' a horas '.$event->time.'.');
        }
        return $event;
    }

}