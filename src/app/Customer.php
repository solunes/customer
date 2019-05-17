<?php

namespace Solunes\Customer\App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model {
    
    protected $table = 'customers';
    public $timestamps = true;
    protected $fillable = ['name', 'email', 'password', 'first_name', 'last_name', 'status', 'user_id'];

    /*if(config('customer.customer_trait')){
        use \App\Traits\Customer;
    }*/

    /* Creating rules */
    public static $rules_password = array(
        'password'=>'required|min:6|confirmed',
        'password_confirmation'=>'required|min:6',
    );

    /* Creating rules */
    public static $rules_send = array(
        'first_name'=>'required',
        'last_name'=>'required',
        'cellphone'=>'required',
        'birth_date'=>'required',
    );

    /* Creating rules */
    public static $rules_create = array(
        'email'=>'email|required_without_all:cellphone,ci_number',
        'cellphone'=>'required_without_all:email,ci_number',
        'ci_number'=>'required_without_all:email,cellphone',
        'status'=>'required',
        'active'=>'required',
    );

    /* Updating rules */
    public static $rules_edit = array(
        'id'=>'required',
        'email'=>'email|required_without_all:cellphone,ci_number',
        'cellphone'=>'required_without_all:email,ci_number',
        'ci_number'=>'required_without_all:email,cellphone',
        'status'=>'required',
        'active'=>'required',
    );
    
    public function user() {
        return $this->belongsTo('App\User');
    }
        
    public function ci_expedition_type() {
        return $this->belongsTo('App\CiExpeditionType');
    }
    
    public function city() {
        return $this->belongsTo('Solunes\Business\App\City');
    }

    public function customer_dependants() {
        return $this->hasMany('Solunes\Customer\App\CustomerDependant');
    }

    public function payments() {
        return $this->hasMany('Solunes\Payments\App\Payment');
    }

    public function pending_payments() {
        return $this->hasMany('Solunes\Payments\App\Payment')->where('status','holding');
    }

    public function paid_payments() {
        return $this->hasMany('Solunes\Payments\App\Payment')->where('status','paid');
    }

    // DEL FUTBOL CTLP

    public function total_goals() {
        return $this->hasMany('App\TotalGoal');
    }

    public function getGoalsAttribute() {
        if($total_goals = $this->total_goals()->orderBy('id','DESC')->first()){
            return $total_goals->goals;
        }
        return 0;
    }

    public function cards() {
        return $this->hasMany('App\Card');
    }

    public function yellow_cards() {
        return $this->hasMany('App\Card')->where('yellow_card','>',0);
    }

    public function red_cards() {
        return $this->hasMany('App\Card')->where('red_card','>',0);
    }

    public function team_customer() {
        return $this->hasOne('App\TeamCustomer');
    }

    public function team_customers() {
        return $this->hasMany('App\TeamCustomer');
    }

    public function customer_activities() {
        return $this->hasMany('Solunes\Customer\App\CustomerActivity', 'parent_id');
    }

    public function customer_notes() {
        return $this->hasMany('Solunes\Customer\App\CustomerNote');
    }

    public function customer_tickets() {
        return $this->hasMany('Solunes\Customer\App\CustomerTicket');
    }
    
}