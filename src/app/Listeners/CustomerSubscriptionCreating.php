<?php

namespace Solunes\Customer\App\Listeners;

class CustomerSubscriptionCreating
{

    /**
     * Handle the event.
     *
     * @param  PodcastWasPurchased  $event
     * @return void
     */
    public function handle($event) {
        if(!$event->initial_date){
            $event->initial_date = date('Y-m-d');
        }
        return $event;
    }
}
