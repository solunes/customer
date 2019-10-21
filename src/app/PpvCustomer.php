<?php

namespace Solunes\Customer\App;

use Illuminate\Database\Eloquent\Model;

class PpvUser extends Model {
	
	protected $table = 'ppv_users';
	public $timestamps = true;

	/* Creating rules */
	public static $rules_create = array(
		'user_id'=>'required',
		'customer_id'=>'required',
		'ppv_id'=>'required',
		'name'=>'required',
		'start_date'=>'required',
		'status'=>'required',
		'price'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'user_id'=>'required',
		'customer_id'=>'required',
		'ppv_id'=>'required',
		'name'=>'required',
		'start_date'=>'required',
		'status'=>'required',
		'price'=>'required',
	);
	
	public function parent() {
        return $this->belongsTo('App\Ppv', 'ppv_id');
    }

	public function ppv() {
        return $this->belongsTo('App\Ppv');
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

}