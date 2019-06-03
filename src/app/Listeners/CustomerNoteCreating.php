<?php

namespace Solunes\Customer\App\Listeners;

class CustomerNoteCreating {

    public function handle($event) {
    	if(auth()->check()){
        	$event->user_id = auth()->user()->id;
    	}
        return $event;
    }

}