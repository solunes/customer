<?php

namespace Solunes\Customer\App;

use Illuminate\Database\Eloquent\Model;

class CiExpeditionTranslation extends Model {
    
    protected $table = 'ci_expedition_translation';
    public $timestamps = false;
    protected $fillable = ['name'];
    
}