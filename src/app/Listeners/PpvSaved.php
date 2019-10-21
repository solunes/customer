<?php

namespace Solunes\Customer\App\Listeners;

class PpvSaved
{

    /**
     * Handle the event.
     *
     * @param  PodcastWasPurchased  $event
     * @return void
     */
    public function handle($event) {
        if(!$product_bridge = \Solunes\Business\App\ProductBridge::where('product_type','ppv')->where('product_id', $event->id)->first()){
            $product_bridge = new \Solunes\Business\App\ProductBridge;
            $product_bridge->product_type = 'ppv';
            $product_bridge->product_id = $event->id;
        }
        $product_bridge->currency_id = 1;
        $product_bridge->price = $event->price;
        $product_bridge->name = $event->name;
        /*$image = \Asset::get_image_path('product-image','normal',$event->image);
        $product_bridge->image = \Asset::upload_image(asset($image),'product-bridge-image');*/
        $product_bridge->content = $event->content;
        $product_bridge->save();
        if($event->product_bridge_id!=$product_bridge->id){
            $event->product_bridge_id = $product_bridge->id;
            $event->save();
        }
        return $event;
    }
}
