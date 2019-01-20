<?php

namespace Solunes\Customer\App;

use Illuminate\Database\Eloquent\Model;

class CiExpedition extends Model {
	
	protected $table = 'ci_expeditions';
	public $timestamps = true;

	public $translatedAttributes = ['name'];
    protected $fillable = ['name', 'active'];

    use \Dimsav\Translatable\Translatable;

	/* Creating rules */
	public static $rules_create = array(
		'name'=>'required',
		'active'=>'required',
	);

	/* Updating rules */
	public static $rules_edit = array(
		'id'=>'required',
		'name'=>'required',
		'active'=>'required',
	);
    
    public function customers() {
        return $this->hasMany('Solunes\Customer\App\Customer');
    }

}