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
            $event->triggered = 0;
            if($customer_contact->date>date('Y-m-d')){
                // Generar notificacion
                \External::generateTrigger('Contacto de Cliente: '.$customer_contact->parent->name, $customer_contact->date, $customer_contact->time, url('trigger/check-customer-contact/'.$customer_contact->id));
            }
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