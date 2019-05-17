<?php

namespace Solunes\Customer\App;

use Illuminate\Database\Eloquent\Model;

class CustomerNote extends Model {
	
	protected $table = 'customer_notes';
	public $timestamps = true;

	/* Creating rules */
	public static $rules_create = array(
		'user_id'=>'required',
		'customer_id'=>'required',
		'name'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
		'user_id'=>'required',
		'customer_id'=>'required',
		'name'=>'required',
	);
    
    public function customer() {
        return $this->belongsTo('Solunes\Customer\App\Customer');
    }

}