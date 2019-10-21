<?php

namespace Solunes\Customer\App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionBenefit extends Model {
	
	protected $table = 'subscription_benefits';
	public $timestamps = true;
    
	/* Creating rules */
	public static $rules_create = array(
		'name'=>'required',
	);
	/* Updating rules */
	public static $rules_edit = array(
		'name'=>'required',
	);

	public function parent() {
        return $this->belongsTo('Solunes\Customer\App\Subscription');
    }

	public function subscription() {
        return $this->belongsTo('Solunes\Customer\App\Subscription', 'parent_id');
    }
	
}