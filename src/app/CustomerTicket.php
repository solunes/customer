<?php

namespace Solunes\Customer\App;

use Illuminate\Database\Eloquent\Model;

class CustomerTicket extends Model {
	
	protected $table = 'customer_tickets';
	public $timestamps = true;

	/* Creating rules */
	public static $rules_create = array(
		'customer_id'=>'required',
		'name'=>'required',
		'status'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
		'customer_id'=>'required',
		'name'=>'required',
		'status'=>'required',
	);
    
    public function customer() {
        return $this->belongsTo('Solunes\Customer\App\Customer');
    }

    public function customer_ticket_messages() {
        return $this->hasMany('Solunes\Customer\App\CustomerTicketMessage');
    }

}