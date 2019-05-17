<?php

namespace Solunes\Customer\App\Listeners;

class CustomerItemCreating {

    public function handle($event) {
        if(auth()->check()){
            $user = auth()->user();
            $event->user_id = $user->id;
        }
        return $event;
    }

}