<?php

namespace Solunes\Customer\App\Listeners;

class SubscriptionPlanSaved
{

    /**
     * Handle the event.
     *
     * @param  PodcastWasPurchased  $event
     * @return void
     */
    public function handle($event) {
        if(!$product_bridge = \Solunes\Business\App\ProductBridge::where('product_type','subscription-plan')->where('product_id', $event->id)->first()){
            $product_bridge = new \Solunes\Business\App\ProductBridge;
            $product_bridge->product_type = 'subscription-plan';
            $product_bridge->product_id = $event->id;
        }
        $product_bridge->category_id = $event->parent->category_id;
        $product_bridge->currency_id = 1;
        $product_bridge->price = $event->price;
        $product_bridge->name = $event->parent->name.' / '.$event->name;
        if($event->type=='custom'){
            $product_bridge->name .= ' / '.$event->custom_days.' días';
        } else {
            $product_bridge->name .= ' / '.trans('customer::admin.'.$event->type);
        }
        /*$image = \Asset::get_image_path('product-image','normal',$event->image);
        $product_bridge->image = \Asset::upload_image(asset($image),'product-bridge-image');*/
        $product_bridge->content = $event->content;
        $product_bridge->delivery_type = 'subscription';
        $product_bridge->save();
        if($event->product_bridge_id!=$product_bridge->id){
            $event->product_bridge_id = $product_bridge->id;
            $event->save();
        }
        return $event;
    }
}
