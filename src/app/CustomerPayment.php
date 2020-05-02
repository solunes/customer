<?php

namespace Solunes\Customer\App;

use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model {
	
	protected $table = 'customer_payments';
	public $timestamps = true;

    /* Creating rules */
    public static $rules_create = array(
        'has_invoice'=>'required',
        'payment_code'=>'required',
        'name'=>'required',
        'price'=>'required',
        'period'=>'required',
    );

    /* Updating rules */
    public static $rules_edit = array(
        'id'=>'required',
        'has_invoice'=>'required',
        'payment_code'=>'required',
        'name'=>'required',
        'price'=>'required',
        'period'=>'required',
    );
    
    public function parent() {
        return $this->belongsTo('Solunes\Customer\App\Customer');
    }
    
    public function customer() {
        return $this->belongsTo('Solunes\Customer\App\Customer', 'parent_id');
    }
    
    public function sale() {
        return $this->belongsTo('Solunes\Sales\App\Sale');
    }

    public function payment() {
        return $this->belongsTo('Solunes\Payments\App\Payment');
    }
    
    public function customer_payment_check() {
        return $this->belongsTo('Solunes\Customer\App\CustomerPayment');
    }

}