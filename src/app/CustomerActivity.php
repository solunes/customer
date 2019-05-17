<?php

namespace Solunes\Customer\App;

use Illuminate\Database\Eloquent\Model;

class CustomerActivity extends Model {
	
	protected $table = 'customer_activities';
	public $timestamps = true;

	/* Creating rules */
	public static $rules_create = array(
		'type'=>'required',
		'name'=>'required',
		'date'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'type'=>'required',
		'name'=>'required',
		'date'=>'required',
	);
    
    public function parent() {
        return $this->belongsTo('Solunes\Customer\App\Customer');
    }
    
    public function customer() {
        return $this->belongsTo('Solunes\Customer\App\Customer', 'parent_id');
    }

}