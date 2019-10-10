<?php

namespace App;

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

	public function season() {
        return $this->belongsTo('App\Season');
    }
    
	public function product_bridge() {
        return $this->belongsTo('Solunes\Business\App\ProductBridge');
    }

	public function subscription_users() {
        return $this->hasMany('App\SubscriptionUser');
    }
	
}