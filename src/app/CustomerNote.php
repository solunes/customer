<?php

namespace Solunes\Customer\App;

use Illuminate\Database\Eloquent\Model;

class CustomerNote extends Model {
	
	protected $table = 'customer_notes';
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
        return $this->belongsTo('Solunes\Customer\App\Customer');
    }
    
    public function customer() {
        return $this->belongsTo('Solunes\Customer\App\Customer', 'parent_id');
    }

}