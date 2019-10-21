<?php

namespace Solunes\Customer\App\Listeners;

class CustomerSubscriptionCreated
{

    /**
     * Handle the event.
     *
     * @param  PodcastWasPurchased  $event
     * @return void
     */
    public function handle($event) {
        if($event->subscription_plan_id){
            $customer_subscription_month = new \Solunes\Customer\App\CustomerSubscriptionMonth;
            $customer_subscription_month->parent_id = $event->id;
            $customer_subscription_month->subscription_id = $event->subscription_id;
            $customer_subscription_month->subscription_plan_id = $event->subscription_plan_id;
            $customer_subscription_month->initial_date = $event->initial_date;
            $customer_subscription_month->save();
        }
        return $event;
    }
}
