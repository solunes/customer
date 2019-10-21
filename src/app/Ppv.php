<?php

namespace Solunes\Customer\App;

use Illuminate\Database\Eloquent\Model;

class Ppv extends Model {
	
	protected $table = 'ppvs';
	public $timestamps = true;

	/* Creating rules */
	public static $rules_create = array(
		'season_id'=>'required',
		'name'=>'required',
		'status'=>'required',
		'date'=>'required',
		'price'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
		'season_id'=>'required',
		'name'=>'required',
		'status'=>'required',
		'date'=>'required',
		'price'=>'required',
	);
	
	public function season() {
        return $this->belongsTo('App\Season');
    }
    	
	public function product_bridge() {
        return $this->belongsTo('Solunes\Business\App\ProductBridge');
    }

	public function ppv_users() {
        return $this->hasMany('App\PpvUser');
    }
	
}