<?php

namespace Solunes\Customer\App;

use Illuminate\Database\Eloquent\Model;

class CustomerContact extends Model {
	
	protected $table = 'customer_contacts';
	public $timestamps = true;

	/* Creating rules */
	public static $rules_create = array(
		'parent_id'=>'required',
		'status'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
		'parent_id'=>'required',
		'status'=>'required',
	);
    
    public function parent() {
        return $this->belongsTo('Solunes\Customer\App\Customer');
    }
    
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function customer() {
        return $this->belongsTo('Solunes\Customer\App\Customer', 'parent_id');
    }
    
}