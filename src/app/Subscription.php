<?php

namespace Solunes\Customer\App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model {
	
	protected $table = 'subscriptions';
	public $timestamps = true;
    
	/* Creating rules */
	public static $rules_create = array(
		'season_id'=>'required',
		'name'=>'required',
		'days'=>'required',
		'type'=>'required',
		'status'=>'required',
		'price'=>'required',
	);
	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
		'season_id'=>'required',
		'name'=>'required',
		'days'=>'required',
		'type'=>'required',
		'status'=>'required',
		'price'=>'required',
	);

	public function category() {
        return $this->belongsTo('Solunes\Business\App\Category');
    }

	public function customers_subscription() {
        return $this->hasMany('Solunes\Customer\App\CustomerSubscription');
    }
	
	public function subscription_plans() {
        return $this->hasMany('Solunes\Customer\App\SubscriptionPlan', 'parent_id');
    }
			
	public function subscription_plan() {
        return $this->hasOne('Solunes\Customer\App\SubscriptionPlan', 'parent_id');
    }

	public function subscription_benefits() {
        return $this->hasMany('Solunes\Customer\App\SubscriptionBenefit', 'parent_id');
    }

}