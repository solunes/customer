<?php

namespace Solunes\Customer\App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model {
	
	protected $table = 'subscription_plans';
	public $timestamps = true;
    
	/* Creating rules */
	public static $rules_create = array(
		'product_bridge_id'=>'required',
		'name'=>'required',
		'type'=>'required',
		'active'=>'required',
		'price'=>'required',
	);
	/* Updating rules */
	public static $rules_edit = array(
		'product_bridge_id'=>'required',
		'name'=>'required',
		'type'=>'required',
		'active'=>'required',
		'price'=>'required',
	);

	public function parent() {
        return $this->belongsTo('Solunes\Customer\App\Subscription');
    }

	public function subscription() {
        return $this->belongsTo('Solunes\Customer\App\Subscription', 'parent_id');
    }

	public function product_bridge() {
        return $this->belongsTo('Solunes\Business\App\ProductBridge');
    } 

	public function subscription_customers() {
        return $this->hasMany('Solunes\Customer\App\SubscriptionCustomer');
    }
	
}