<?php

namespace Solunes\Customer\Database\Seeds;

use Illuminate\Database\Seeder;
use DB;

class TruncateSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(config('customer.dependants')){
        	\Solunes\Customer\App\CustomerDependant::truncate();
        }
        \Solunes\Customer\App\Customer::truncate();
    }
}