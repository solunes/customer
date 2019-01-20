<?php

namespace Solunes\Customer\Database\Seeds;

use Illuminate\Database\Seeder;
use DB;

class MasterSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Módulo General de Empresa ERP
        if(config('payments.sfv_version')>1||config('customer.ci_expeditions_table')){
            $node_ci_expedition = \Solunes\Master\App\Node::create(['name'=>'ci-expedition', 'location'=>'customer', 'folder'=>'business']);
        }
        $node_customer = \Solunes\Master\App\Node::create(['name'=>'customer', 'location'=>'customer', 'folder'=>'business']);
        if(config('customer.dependants')){
            $node_customer_dependant = \Solunes\Master\App\Node::create(['name'=>'customer-dependant', 'location'=>'customer', 'folder'=>'business']);
        }
        
        if($node_customer = \Solunes\Master\App\Node::where('name', 'customer')->first()){
            \Solunes\Master\App\NodeExtra::create(['parent_id'=>$node_customer->id, 'type'=>'action_field', 'parameter'=>'field', 'value_array'=>json_encode(["login-as","edit"])]);
        }
        if($node_payment = \Solunes\Master\App\Node::where('name', 'payment')->first()){
            \Solunes\Master\App\NodeExtra::create(['parent_id'=>$node_payment->id, 'type'=>'action_field', 'parameter'=>'field', 'value_array'=>json_encode(["manual-pay","edit"])]);
        }

        if(config('customer.fields.image')){
            $image_folder = \Solunes\Master\App\ImageFolder::create(['site_id'=>1, 'name'=>'customer-image', 'extension'=>'jpg']);
            \Solunes\Master\App\ImageSize::create(['parent_id'=>$image_folder->id, 'code'=>'normal', 'type'=>'fit', 'width'=>'240', 'height'=>'240']);
        }

        // Usuarios
        $admin = \Solunes\Master\App\Role::where('name', 'admin')->first();
        $member = \Solunes\Master\App\Role::where('name', 'member')->first();
        $dashboard_perm = \Solunes\Master\App\Permission::where('name','dashboard')->first();
        if(!\Solunes\Master\App\Permission::where('name','solunes')->first()){
            $customer_perm = \Solunes\Master\App\Permission::create(['name'=>'solunes', 'display_name'=>'Solunes']);
            $admin->permission_role()->attach([$customer_perm->id]);
        }
        if(!\Solunes\Master\App\Permission::where('name','members')->first()){
            $members_perm = \Solunes\Master\App\Permission::create(['name'=>'members', 'display_name'=>'Miembros']);
            $member->permission_role()->attach([$dashboard_perm->id, $members_perm->id]);
        }

    }
}