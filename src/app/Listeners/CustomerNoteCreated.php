<?php

namespace Solunes\Customer\App\Listeners;

class CustomerNoteCreated {

    public function handle($event) {
        $customer = $event->parent;
        $customer->last_contact = date('Y-m-d');
        $customer->save();
        if(config('customer.tracking')){
        	\Customer::createCustomerActivity($customer, 'general', 'Se generó una Nota de Cliente: '.$event->name.'.');
        }
        return $event;
    }

}