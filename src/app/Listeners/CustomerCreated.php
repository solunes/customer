<?php

namespace Solunes\Customer\App\Listeners;

class CustomerCreated {

    public function handle($event) {
        if(config('customer.send_mail')&&$event->email){
            $email_title = config('app.name').' | Registro Realizado Exitosamente';
            $to_array = [$event->email];
            $message_title = 'Registro Realizado';
            $message_content = 'Felicidades, su registro fue realizado correctamente.';
            \Notification::sendEmail($email_title, $to_array, $message_title, $message_content);
        }
        if(config('customer.tracking')){
            \Customer::createCustomerActivity($event, 'registration', 'El usuario se registró correctamente.');
        }
        return $event;
    }

}