<?php

namespace Solunes\Customer\App\Listeners;

class CustomerPaymentCreating {

    public function handle($event) {
        if(!$product_bridge = \Solunes\Business\App\ProductBridge::where('product_type','customer-payment')->where('product_id', $event->id)->first()){
            $product_bridge = new \Solunes\Business\App\ProductBridge;
            $product_bridge->product_type = 'customer-payment';
            $product_bridge->product_id = $event->id;
        }
        $product_bridge->currency_id = 1;
        $product_bridge->price = $event->price;
        $product_bridge->name = $event->name.' - '.$event->payment_code.' - '.$event->period;
        /*$image = \Asset::get_image_path('product-image','normal',$event->image);
        $product_bridge->image = \Asset::upload_image(asset($image),'product-bridge-image');*/
        $product_bridge->content = $event->name.' - '.$event->payment_code.' - '.$event->period;
        $product_bridge->save();
        /*if($event->product_bridge_id!=$product_bridge->id){
            $event->product_bridge_id = $product_bridge->id;
            $event->save();
        }*/
        if($event->customer){
            $customer = $event->customer;
        } else if($event->customer_code) {
            $customer = \Solunes\Customer\App\Customer::where('member_code', $event->customer_code)->first();
        } else {
            $customer = NULL;
        }
        if($customer){
            $related_customer_payment = \Solunes\Customer\App\CustomerPayment::where('parent_id',$customer->id)->where('payment_code', $event->payment_code)->orderBy('id','DESC')->first();
            if($related_customer_payment){
                $event->customer_payment_check_id = $related_customer_payment->id;
            }
        }
        if($customer&&!$event->sale_id&&!$event->payment_id){
            $event->parent_id = $customer->id;
            $sale = \Sales::generateSingleSale($customer->user->id, $customer->id, $product_bridge->currency_id, 2, $event->has_invoice, $customer->last_name, $customer->ci_number, $event->name.' - '.$event->payment_code.' - '.$event->period, $event->price, $product_bridge->id, 1);
            $payment = $sale->sale_payment->payment;
            if($event->customer_payment_check_id){
                $payment->payment_check_id = $event->customer_payment_check->payment_id;
                $payment->save();
            } 
            if($event->message_block){
                $payment->message_block = $event->message_block;
                $payment->save();
            }
            $event->sale_id = $sale->id;
            $event->payment_id = $payment->id;
        }
        return $event;
    }

}