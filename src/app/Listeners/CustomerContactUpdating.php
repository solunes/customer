<?php

namespace Solunes\Customer\App\Listeners;

class CustomerContactUpdating {

    public function handle($event) {
        if($event->status=='reprogrammed'&&$event->reprogrammed!=1){
            $customer_contact = new \Solunes\Customer\App\CustomerContact;
            $customer_contact->parent_id = $event->parent_id;
            $customer_contact->name = $event->name;
            $customer_contact->date = $event->new_date;
            $customer_contact->time = $event->new_time;
            $customer_contact->reason_to_contact = $event->detail.' - '.$event->result;
            $customer_contact->save();
            $event->reprogrammed = 1;
        }
        if($event->status=='attended'&&$event->result){
            $customer = $event->parent;
            $customer->last_contact = date('Y-m-d');
            $customer->save();
            if(config('customer.tracking')){
                \Customer::createCustomerActivity($event->customer, 'general', 'Se atendió una cita con el resultado: '.$event->result.'.');
            }
        }
        return $event;
    }

}