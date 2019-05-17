<?php

namespace Solunes\Customer\App;

use Illuminate\Database\Eloquent\Model;

class CustomerTicketMessage extends Model {
	
	protected $table = 'customer_ticket_messages';
	public $timestamps = true;

	/* Creating rules */
	public static $rules_create = array(
		'message'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'message'=>'required',
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