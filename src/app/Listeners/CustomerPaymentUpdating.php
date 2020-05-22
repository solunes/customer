<?php

namespace Solunes\Customer\App\Listeners;

class CustomerPaymentUpdating {

    public function handle($event) {
        if($event->customer){
            $customer = $event->customer;
        } else if($event->customer_code) {
            $customer = \Solunes\Customer\App\Customer::where('member_code', $event->customer_code)->first();
        } else {
            $customer = NULL;
        }
        $event->load('sale');
        $event->load('payment');
        if($customer&&$event->sale_id&&$event->payment_id&&$event->payment&&$event->sale&&$event->payment->status=='holding'&&$event->sale->status=='holding'){
            $sale = $event->sale;
            $payment = \Payments::generatePayment($sale);
            $product_bridge = \Solunes\Business\App\ProductBridge::where('product_type','customer-payment')->where('product_id', $event->id)->first();
            if($event->isDirty('message_block')){
                $payment->message_block = $event->message_block;
                $payment->save();
            }
            if($event->isDirty('customer_id')){
                changing_customer();
            }
            if($event->isDirty('payment_code')||$event->isDirty('name')||$event->isDirty('period')){
                $sub_name = $event->name.' - '.$event->payment_code.' - '.$event->period;
                $payment->name = $sub_name;
                $payment->save();
                if($payment_item = $payment->payment_item){
                    $payment_item->name = $sub_name;
                    $payment_item->save();
                }
                $sale->name = $sub_name;
                $sale->save();
                $sale_item = $sale->sale_item;
                $sale_item->detail = $sub_name;
                $sale_item->save();
                if($product_bridge){
                    $product_bridge->name = $sub_name;
                    $product_bridge->save();
                }
            }
            if($event->isDirty('has_invoice')){
                $payment->invoice = $event->has_invoice;
                $payment->save();
                $sale->invoice = $event->has_invoice;
                $sale->save();
            }
            if($event->isDirty('price')){
                $event->price = str_replace(',', '', $event->price);
                $payment->real_amount = $event->price;
                $payment->save();
                if($payment_item = $payment->payment_item){
                    $payment_item->price = $event->price;
                    $payment_item->amount = $event->price;
                    $payment_item->save();                    
                }
                $sale->amount = $event->price;
                $sale->save();
                $sale_item = $sale->sale_item;
                $sale_item->price = $event->price;
                $sale_item->total = $event->price;
                $sale_item->save();
                $sale_payment = $sale->sale_payment;
                $sale_payment->amount = $event->price;
                $sale_payment->pending_amount = $event->price;
                $sale_payment->save();
                if($sale_payment_item = $sale_payment->sale_payment_item){
                    $sale_payment_item = $sale_payment->sale_payment_item;
                    $sale_payment_item->amount = $event->price;
                    $sale_payment_item->save();
                }
                if($product_bridge){
                    $product_bridge->price = $event->price;
                    $product_bridge->save();
                }
            }
        }
        return $event;
    }

}