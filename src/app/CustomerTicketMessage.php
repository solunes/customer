<?php

namespace Solunes\Customer\App;

use Illuminate\Database\Eloquent\Model;

class CustomerTicketMessage extends Model {
	
	protected $table = 'customer_ticket_messages';
	public $timestamps = true;

	/* Creating rules */
	public static $rules_create = array(
		'customer_id'=>'required',
		'name'=>'required',
		'active'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
		'customer_id'=>'required',
		'name'=>'required',
		'active'=>'required',
	);
    
    public function customer_ticket() {
        return $this->belongsTo('Solunes\Customer\App\CustomerTicket', 'parent_id');
    }    
    
    public function parent() {
        return $this->belongsTo('Solunes\Customer\App\CustomerTicket');
    }    

    public function user() {
        return $this->belongsTo('App\User');
    }

}