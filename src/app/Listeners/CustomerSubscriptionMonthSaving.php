<?php

namespace Solunes\Customer\App\Listeners;

class CustomerSubscriptionMonthSaving
{

    /**
     * Handle the event.
     *
     * @param  PodcastWasPurchased  $event
     * @return void
     */
    public function handle($event) {
        $subscription_plan = $event->subscription_plan;
        $initial_timestamp = strtotime($event->initial_date);
        if($subscription_plan->type=='custom'){
            $event->duration = $subscription_plan->custom_days;
            $event->end_date = date("Y-m-d", strtotime("+".$event->duration." days", $initial_timestamp));
        } else {
            if($subscription_plan->type=='daily'){
                $event->end_date = date("Y-m-d", strtotime("+1 day", $initial_timestamp));
            } else if($subscription_plan->type=='weekly'){
                $event->end_date = date("Y-m-d", strtotime("+1 week", $initial_timestamp));
            } else if($subscription_plan->type=='biweekly'){
                $event->end_date = date("Y-m-d", strtotime("+2 weeks", $initial_timestamp));
            } else if($subscription_plan->type=='monthly'){
                $event->end_date = date("Y-m-d", strtotime("+1 month", $initial_timestamp));
            } else if($subscription_plan->type=='quarterly'){
                $event->end_date = date("Y-m-d", strtotime("+3 months", $initial_timestamp));
            } else if($subscription_plan->type=='half-yearly'){
                $event->end_date = date("Y-m-d", strtotime("+6 months", $initial_timestamp));
            } else if($subscription_plan->type=='yearly'){
                $event->end_date = date("Y-m-d", strtotime("+1 year", $initial_timestamp));
            }
            $final_timestamp = strtotime($event->end_date);
            $event->duration = round( ( $final_timestamp - $initial_timestamp ) / (60 * 60 * 24) );
        }
        $event->amount = $subscription_plan->price;
        if($event->amount<0){
           $event->amount = 0;
        }
        if($event->processing&&$event->status=='paid'){
            $event->processing = 0;
            $customer_subscription = $event->parent;
            if($customer_subscription->end_date<date('Y-m-d')){
                $customer_subscription->initial_date = date('Y-m-d');
                $initial_timestamp = strtotime($customer_subscription->initial_date);
            } else {
                $initial_timestamp = strtotime($customer_subscription->end_date);
            }
            $customer_subscription->end_date = date("Y-m-d", strtotime("+".$event->duration." days", $initial_timestamp));
            $customer_subscription->active = 1;
            $customer_subscription->save();
        }
        return $event;
    }
}
