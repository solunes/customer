<?php 

namespace Solunes\Customer\App\Helpers;

use Form;

class CustomCustomer {
   
    public static function after_seed_actions() {

        $business_menu = \Solunes\Master\App\Menu::where('level',1)->where('permission','business')->where('type','blank')->first();
        \Solunes\Master\App\Menu::create(['parent_id'=>$business_menu->id,'level'=>'2','menu_type'=>'admin','icon'=>'user','permission'=>'business','name'=>'Contactos con Clientes','link'=>'admin/model-list/customer-contact']);
        \Solunes\Master\App\Menu::create(['parent_id'=>$business_menu->id,'level'=>'2','menu_type'=>'admin','icon'=>'user','permission'=>'business','name'=>'Notas de Cliente','link'=>'admin/model-list/customer-note']);

        return 'After seed realizado correctamente.';
    }
       
    public static function get_custom_field($name, $parameters, $array, $label, $col, $i, $value, $data_type) {
        // Type = list, item
        $return = NULL;
        /*if($name=='parcial_cost'){
            $return .= \Field::form_input($i, $data_type, ['name'=>'quantity', 'required'=>true, 'type'=>'string'], ['value'=>1, 'label'=>'Cantidad Comprada', 'cols'=>4]);
            //$return .= \Field::form_input($i, $data_type, ['name'=>'total_cost', 'required'=>true, 'type'=>'string'], ['value'=>0, 'label'=>'Costo Total de Lote', 'cols'=>6], ['readonly'=>true]);
            if(request()->has('purchase_id')){
                $return .= '<input type="hidden" name="purchase_id" value="'.request()->input('purchase_id').'" />';
            }
        }*/
        return $return;
    }

    public static function after_login($user, $last_session, $redirect) {

        return true;
    }
    
    public static function check_permission($type, $module, $node, $action, $id = NULL) {
        // Type = list, item
        $return = 'none';
        /*if($node->name=='sale'){
            if($type=='item'&&$action=='edit'){
                $pending = \Solunes\Sales\App\Sale::find($id);
                if($pending->status=='paid'||$pending->status=='delivered'){
                    $return = 'false';
                }
            }
        }*/
        return $return;
    }

    public static function get_options_relation($submodel, $field, $subnode, $id = NULL) {
        /*if($field->relation_cond=='account_concepts'){
            $node_name = request()->segment(3);
            if($id){
                $node = \Solunes\Master\App\Node::where('name', request()->segment(3))->first();
                $model = \FuncNode::node_check_model($node);
                $model = $model->find($id);
                $submodel = $submodel->where('id', $model->account_id);
            } else {
                if(auth()->check()&&auth()->user()->hasRole('admin')){
                    if($node_name=='income'||$node_name=='accounts-receivable'){
                        $submodel = $submodel->where('code', 'income_other');
                    } else if($node_name=='expense'||$node_name=='accounts-payable'){
                        $submodel = $submodel->whereIn('code', ['expense_operating_com','expense_operating_adm','expense_operating_dep','expense_operating_int','expense_other']);
                    }
                } else {
                    if($node_name=='income'){
                        $submodel = $submodel->where('code', 'income_other');
                    } else if($node_name=='expense'){
                        $submodel = $submodel->where('code', 'expense_other');
                    }
                }
            }
        }*/
        return $submodel;
    }

}