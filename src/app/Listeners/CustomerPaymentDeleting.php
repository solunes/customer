<?php

namespace Solunes\Customer\App\Listeners;

class CustomerPaymentDeleting {

    public function handle($event) {
        if($event->customer){
            $customer = $event->customer;
        } else if($event->customer_code) {
            $customer = \Solunes\Customer\App\Customer::where('member_code', $event->customer_code)->first();
        } else {
            $customer = NULL;
        }
        if($customer&&$event->sale_id&&$event->payment_id&&$event->payment->status=='holding'&&$event->sale->status=='holding'){
            $sale = $event->sale;
            $payment = $event->payment;
            $product_bridge = \Solunes\Business\App\ProductBridge::where('product_type','customer-payment')->where('product_id', $event->id)->first();
            if($payment){
                $payment->delete();
            }
            if($sale){
                $sale->delete();
            }
            if($product_bridge){
                $product_bridge->delete();
            }
            if($payment){
                $payment->delete();
            }
        }
        return $event;
    }

}