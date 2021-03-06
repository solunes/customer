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
        if(config('customer.addresses')){
            $node_customer_address = \Solunes\Master\App\Node::create(['name'=>'customer-address', 'table_name'=>'customer_addresses', 'location'=>'customer', 'folder'=>'business']);
        }
        if(config('customer.notes')){
            $node_customer_note = \Solunes\Master\App\Node::create(['name'=>'customer-note', 'type'=>'child', 'parent_id'=>$node_customer->id, 'location'=>'customer', 'folder'=>'business']);
            \Solunes\Master\App\NodeExtra::create(['parent_id'=>$node_customer_note->id, 'type'=>'action_field', 'parameter'=>'field', 'value_array'=>json_encode(["edit"])]);
        }
        if(config('customer.tracking')){
            $node_customer_activity = \Solunes\Master\App\Node::create(['name'=>'customer-activity', 'table_name'=>'customer_activities', 'type'=>'child', 'parent_id'=>$node_customer->id, 'location'=>'customer', 'folder'=>'business']);
            \Solunes\Master\App\NodeExtra::create(['parent_id'=>$node_customer_activity->id, 'type'=>'action_field', 'parameter'=>'field', 'value_array'=>json_encode(["view"])]);
        }
        if(config('customer.contacts')){
            $node_customer_contact = \Solunes\Master\App\Node::create(['name'=>'customer-contact', 'type'=>'child', 'parent_id'=>$node_customer->id, 'location'=>'customer', 'folder'=>'business']);
            \Solunes\Master\App\NodeExtra::create(['parent_id'=>$node_customer_contact->id, 'type'=>'action_field', 'parameter'=>'field', 'value_array'=>json_encode(["edit-customer-contact","edit"])]);
            \Solunes\Master\App\Email::create(['name'=>'customer-contact-reminder', 'es'=>['title'=>'Tiene una cita de contacto ahora!', 'content'=>'<p>Estimado Encargado,</p><p>Este es un email automáticopara recordarle que tiene una cita con @customer_id@ el @date@ @time@.</p><p>Los datos del cliente son:<br>Nombre de Cliente: @customer_name@<br>Email: @email@<br>Teléfono: @cellphone@<br></p><p>Saludos,</p><p>Su Sistema</p>']]);
        }
        if(config('customer.tickets')){
            $node_customer_ticket = \Solunes\Master\App\Node::create(['name'=>'customer-ticket', 'location'=>'customer', 'folder'=>'business']);
            $node_customer_ticket_message = \Solunes\Master\App\Node::create(['name'=>'customer-ticket-message', 'type'=>'child', 'parent_id'=>$node_customer_ticket->id, 'location'=>'customer', 'folder'=>'business']);
        }
        if(config('customer.credit_wallet')){
            $node_customer_wallet_transaction = \Solunes\Master\App\Node::create(['name'=>'customer-wallet-transaction', 'location'=>'customer', 'folder'=>'business']);
        }
        if(config('customer.nfcs')){
            $node_nfc = \Solunes\Master\App\Node::create(['name'=>'nfc', 'location'=>'customer', 'folder'=>'business']);
        }
        if(config('customer.payments')){
            $node_customer_payment = \Solunes\Master\App\Node::create(['name'=>'customer-payment', 'type'=>'child', 'parent_id'=>$node_customer->id, 'location'=>'customer', 'folder'=>'business']);
        }
        if(config('customer.ppvs')){
            $node_ppv = \Solunes\Master\App\Node::create(['name'=>'ppv', 'location'=>'customer', 'folder'=>'business']);
            $node_ppv_customer = \Solunes\Master\App\Node::create(['name'=>'ppv-customer', 'location'=>'customer', 'folder'=>'business']);
        }
        if(config('customer.subscriptions')){
            $node_subscription = \Solunes\Master\App\Node::create(['name'=>'subscription', 'location'=>'customer', 'folder'=>'business']);
            $node_subscription_plan = \Solunes\Master\App\Node::create(['name'=>'subscription-plan', 'location'=>'customer', 'folder'=>'business']);
            $node_subscription_benefit = \Solunes\Master\App\Node::create(['name'=>'subscription-benefit', 'location'=>'customer', 'folder'=>'business']);
            $node_customer_subscription = \Solunes\Master\App\Node::create(['name'=>'customer-subscription', 'location'=>'customer', 'folder'=>'business']);
            $node_customer_subscription_month = \Solunes\Master\App\Node::create(['name'=>'customer-subscription-month', 'type'=>'child', 'parent_id'=>$node_customer_subscription->id , 'location'=>'customer', 'folder'=>'business']);
        }

        if($node_customer = \Solunes\Master\App\Node::where('name', 'customer')->first()){
            $subarray = [];
            if(config('customer.contacts')){
                array_push($subarray, "create-customer-contact");
            } 
            if(config('customer.notes')){
                array_push($subarray, "create-customer-note");
                $subarray[] = ["create-customer-note"];
            }
            if(config('customer.login_as')){
                array_push($subarray, "login-as");
            }
            array_push($subarray, "edit");
            \Solunes\Master\App\NodeExtra::create(['parent_id'=>$node_customer->id, 'type'=>'action_field', 'parameter'=>'field', 'value_array'=>json_encode($subarray)]);
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
            $member->permission_role()->attach([$members_perm->id]);
        }

    }
}