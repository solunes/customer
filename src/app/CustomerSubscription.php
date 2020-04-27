<?php

namespace Solunes\Customer\App;

use Illuminate\Database\Eloquent\Model;

class CustomerSubscription extends Model {
	
	protected $table = 'customer_subscriptions';
	public $timestamps = true;
    
	/* Creating rules */
	public static $rules_create = array(
		'customer_id'=>'required',
		'subscription_id'=>'required',
		'name'=>'required',
		'initial_date'=>'required',
		'active'=>'required',
	);
	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
		'customer_id'=>'required',
		'subscription_id'=>'required',
		'name'=>'required',
		'initial_date'=>'required',
		'active'=>'required',
	);
	
	public function customer() {
        return $this->belongsTo('Solunes\Customer\App\Customer');
    }
	
	public function subscription() {
        return $this->belongsTo('Solunes\Customer\App\Subscription');
    }
		
	public function subscription_plan() {
        return $this->belongsTo('Solunes\Customer\App\SubscriptionPlan');
    }

	public function nfc() {
        return $this->hasOne('Solunes\Customer\App\Nfc');
    }

	public function nfcs() {
        return $this->hasMany('Solunes\Customer\App\Nfc');
    }

	public function customer_subscription_months() {
        return $this->hasMany('Solunes\Customer\App\CustomerSubscriptionMonth', 'parent_id');
    }

	public function customer_subscription_month() {
        return $this->hasOne('Solunes\Customer\App\CustomerSubscriptionMonth', 'parent_id');
    }

	public function active_customer_subscription_months() {
        return $this->hasMany('Solunes\Customer\App\CustomerSubscriptionMonth', 'parent_id')->where('status','!=','cancelled');
    }

	public function active_customer_subscription_month() {
        return $this->hasOne('Solunes\Customer\App\CustomerSubscriptionMonth', 'parent_id')->where('status','!=','cancelled');
    }

	public function super_active_customer_subscription_months() {
		$date = date('Y-m-d');
        return $this->hasMany('Solunes\Customer\App\CustomerSubscriptionMonth', 'parent_id')->where('status','paid')->where('initial_date','<=',$date)->where('end_date','>=',$date);
    }

	public function pending_customer_subscription_months() {
        return $this->hasMany('Solunes\Customer\App\CustomerSubscriptionMonth', 'parent_id')->where('status','pending');
    }

}