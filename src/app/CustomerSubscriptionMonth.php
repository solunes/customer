<?php

namespace Solunes\Customer\App;

use Illuminate\Database\Eloquent\Model;

class CustomerSubscriptionMonth extends Model {
	
	protected $table = 'customer_subscription_months';
	public $timestamps = true;

	/* Creating rules */
	public static $rules_create = array(
		'subscription_id'=>'required',
		'subscription_plan_id'=>'required',
		'status'=>'required',
		'initial_date'=>'required',
		'amount'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'subscription_id'=>'required',
		'subscription_plan_id'=>'required',
		'status'=>'required',
		'initial_date'=>'required',
		'amount'=>'required',
	);
			
	public function parent() {
        return $this->belongsTo('\Solunes\Customer\App\CustomerSubscription');
    }

	public function customer_subscription() {
        return $this->belongsTo('\Solunes\Customer\App\CustomerSubscription','parent_id');
    }

	public function subscription() {
        return $this->belongsTo('\Solunes\Customer\App\Subscription');
    }

	public function subscription_plan() {
        return $this->belongsTo('\Solunes\Customer\App\SubscriptionPlan');
    }

	public function sale() {
        return $this->belongsTo('Solunes\Sales\App\Sale');
    }

}