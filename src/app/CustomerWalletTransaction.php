<?php

namespace Solunes\Customer\App;

use Illuminate\Database\Eloquent\Model;

class CustomerWalletTransaction extends Model {
	
	protected $table = 'customer_wallet_transactions';
	public $timestamps = true;

	/* Creating rules */
	public static $rules_create = array(
		'transaction_code'=>'required',
		'type'=>'required',
		'amount'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'transaction_code'=>'required',
		'type'=>'required',
		'amount'=>'required',
	);
    
    public function parent() {
        return $this->belongsTo('Solunes\Customer\App\Customer');
    }
    
    public function customer() {
        return $this->belongsTo('Solunes\Customer\App\Customer', 'parent_id');
    }
    
}