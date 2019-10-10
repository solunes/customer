<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriptionUser extends Model {
	
	protected $table = 'subscription_users';
	public $timestamps = true;
    
	/* Creating rules */
	public static $rules_create = array(
		'user_id'=>'required',
		'customer_id'=>'required',
		'subscription_id'=>'required',
		'name'=>'required',
		'start_date'=>'required',
		'status'=>'required',
		'price'=>'required',
	);
	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
		'user_id'=>'required',
		'customer_id'=>'required',
		'subscription_id'=>'required',
		'name'=>'required',
		'start_date'=>'required',
		'status'=>'required',
		'price'=>'required',
	);

	public function parent() {
        return $this->belongsTo('App\Subscription', 'subscription_id');
    }
	
	public function subscription() {
        return $this->belongsTo('App\Subscription');
    }
	
	public function user() {
        return $this->belongsTo('App\User');
    }
		
	public function customer() {
        return $this->belongsTo('Solunes\Customer\App\Customer');
    }
	
	public function sale() {
        return $this->belongsTo('Solunes\Sales\App\Sale');
    }
	
	public function sector_seat() {
        return $this->belongsTo('App\SectorSeat');
    }

}