<?php

namespace Solunes\Customer\App;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model {
	
	protected $table = 'customer_addresses';
	public $timestamps = true;

	/* Creating rules */
	public static $rules_create = array(
		'parent_id'=>'required',
		'name'=>'required',
		'address'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
		'parent_id'=>'required',
		'name'=>'required',
		'address'=>'required',
	);
        
    public function parent() {
        return $this->belongsTo('Solunes\Customer\App\Customer');
    }

    public function customer() {
        return $this->belongsTo('Solunes\Customer\App\Customer', 'parent_id');
    }

}