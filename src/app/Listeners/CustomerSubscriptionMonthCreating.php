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
        $payment_method = \Solunes\Payments\App\PaymentMethod::where('code', config('payments.default_payment_method_code'))->first();
        if($payment_method){
            $payment_method_id = $payment_method->id;
        } else {
            $payment_method_id = 2;
        }
        $sale = \Sales::generateSingleSale($event->parent->customer->user_id, $event->parent->customer_id, 1, $payment_method->id, 1, $event->parent->customer->nit_name, $event->parent->customer->nit_number, $event->subscription_plan->product_bridge->name.' ('.$event->initial_date.' - '.$event->end_date.')', $event->amount, $event->subscription_plan->product_bridge_id);
        $event->sale_id = $sale->id;
        return $event;
    }
}
