<?php

namespace Solunes\Customer\App\Listeners;

class CustomerSubscriptionMonthCreating
{

    /**
     * Handle the event.
     *
     * @param  PodcastWasPurchased  $event
     * @return void
     */
    public function handle($event) {
        foreach($event->parent->pending_customer_subscription_months as $customer_subscription_month){
            $customer_subscription_month->status = 'cancelled';
            $customer_subscription_month->save();
        }
        $sale = \Sales::generateSingleSale($event->parent->user_id, $event->parent_id, 1, 2, 1, $event->parent->nit_name, $event->parent->nit_number, $event->subscription_plan->product_bridge->name.' ('.$event->initial_date.' - '.$event->end_date.')', $event->amount, $event->subscription_plan->product_bridge_id);
        $event->sale_id = $sale->id;
        return $event;
    }
}
