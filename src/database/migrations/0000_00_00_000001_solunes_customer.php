<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SolunesCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Módulo General de Clientes
        if(config('payments.sfv_version')>1||config('customer.ci_expeditions_table')){
            Schema::create('ci_expeditions', function (Blueprint $table) {
                $table->increments('id');
                $table->boolean('active')->nullable()->default(0);
                $table->timestamps();
            });
            Schema::create('ci_expedition_translation', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('ci_expedition_id')->unsigned();
                $table->string('locale')->index();
                $table->string('name')->nullable();
                $table->unique(['ci_expedition_id','locale']);
                $table->foreign('ci_expedition_id')->references('id')->on('ci_expeditions')->onDelete('cascade');
            });
        }
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable();
            if(config('customer.customer_agency')){
                $table->integer('agency_id')->nullable();
            }
            if(config('customer.seller_user')){
                $table->integer('seller_user_id')->nullable();
            }
            $table->integer('user_id')->nullable(); // Obligatorio
            $table->string('name')->nullable(); // Obligatorio
            $table->string('first_name')->nullable(); // Obligatorio
            $table->string('last_name')->nullable(); // Obligatorio
            $table->string('ci_number')->nullable(); // Obligatorio
            if(config('payments.sfv_version')>1||config('customer.fields.ci_extension')){
                $table->string('ci_extension')->nullable();
            }
            if(config('payments.sfv_version')>1||config('customer.ci_expeditions_table')){
                $table->integer('ci_expedition_id')->nullable(); // Obligatorio
            } else {
                $table->enum('ci_expedition_basic', ['LP','SC','CB','CH','TA','OR','PO','BE','PA','OTRO'])->nullable()->default('LP'); // Obligatorio
            }
            if(config('payments.sfv_version')>1){
                $table->string('customer_code')->nullable();
            }
            $table->string('email')->nullable(); // Obligatorio
            $table->string('cellphone')->nullable(); // Obligatorio
            $table->string('nit_number')->nullable(); // Obligatorio
            $table->string('nit_name')->nullable(); // Obligatorio
            $table->date('birth_date')->nullable(); // Obligatorio
            $table->string('password')->nullable(); // Obligatorio
            $table->enum('type', ['business','agency','person'])->default('business'); // Obligatorio
            $table->enum('status', ['normal','ask_password','pending_confirmation','banned'])->default('ask_password'); // Obligatorio
            $table->boolean('active')->default(0); // Obligatorio
            if(config('customer.fields.country')||config('sales.delivery_country')){
                $table->integer('country_id')->nullable();
            }
            if(config('customer.fields.city')||config('sales.delivery_city')){
                $table->integer('city_id')->nullable();
                $table->string('city_other')->nullable();
            }
            if(config('customer.fields.address')||config('sales.ask_address')){
                $table->string('address')->nullable(); // Obligatorio
                $table->string('address_extra')->nullable();
            }
            if(config('customer.fields.coordinates')||config('sales.ask_coordinates')){
                $table->string('latitude')->nullable(); // Obligatorio
                $table->string('longitude')->nullable();
            }
            if(config('customer.fields.member_code')){
                $table->string('member_code')->nullable();
            }
            if(config('customer.fields.age')){
                $table->integer('age')->nullable();
            }
            if(config('customer.fields.shirt')){
                $table->integer('shirt')->nullable();
            }
            if(config('customer.fields.shirt_size')){
                $table->string('shirt_size')->nullable();
            }
            if(config('customer.fields.emergency_short')){
                $table->string('emergency')->nullable();
            }
            if(config('customer.fields.emergency_long')){
                $table->string('emergency_name')->nullable();
                $table->string('emergency_number')->nullable();
            }
            if(config('customer.api_slave')){
                $table->integer('external_id')->nullable();
            }
            if(config('customer.fields.image')){
                $table->string('image')->nullable();
            }
            if(config('customer.contacts')){
                $table->date('last_contact')->nullable();
            }
            $table->timestamps();
        });
        if(config('customer.dependants')){
            Schema::create('customer_dependants', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('customer_id')->nullable();
                $table->string('name')->nullable();
                if(config('customer.dependant_fields.email')){
                    $table->string('email')->nullable();
                }
                if(config('customer.dependant_fields.cellphone')){
                    $table->string('cellphone')->nullable();
                }
                if(config('customer.dependant_fields.ci_number')){
                    $table->string('ci_number')->nullable();
                    if(config('customer.fields.ci_extension')){
                        $table->string('ci_extension')->nullable();
                    }
                    if(config('customer.ci_expeditions_table')){
                        $table->integer('ci_expedition_id')->nullable(); // Obligatorio
                    } else {
                        $table->enum('ci_expedition_basic', ['LP','SC','CB','CH','TA','OR','PO','BE','PA','OTRO'])->nullable()->default('LP'); // Obligatorio
                    }
                }
                if(config('customer.dependant_fields.image')){
                    $table->string('image')->nullable();
                }
                if(config('customer.dependant_fields.birth_date')){
                    $table->string('birth_date')->nullable();
                }
                if(config('customer.dependant_fields.emergency_name')){
                    $table->string('emergency_name')->nullable();
                }
                if(config('customer.dependant_fields.emergency_number')){
                    $table->string('emergency_number')->nullable();
                }
                $table->boolean('active')->nullable()->default(0);
                $table->timestamps();
            });
        }
        if(config('customer.tracking')){
            Schema::create('customer_activities', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('parent_id')->nullable();
                $table->integer('user_id')->nullable();
                $table->enum('type', ['general','registration','update','login','logout','contact','action'])->default('general');
                $table->string('name')->nullable();
                $table->text('detail')->nullable();
                $table->date('date')->nullable();
                $table->time('time')->nullable();
                $table->timestamps();
            });
        }
        if(config('customer.notes')){
            Schema::create('customer_notes', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('parent_id')->nullable();
                $table->integer('user_id')->nullable();
                $table->string('name')->nullable();
                $table->text('detail')->nullable();
                $table->timestamps();
            });
        }
        if(config('customer.contacts')){
            Schema::create('customer_contacts', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('parent_id')->nullable();
                $table->integer('user_id')->nullable();
                if(config('customer.seller_user')){
                    $table->integer('seller_user_id')->nullable();
                }
                $table->string('name')->nullable();
                $table->date('date')->nullable();
                $table->time('time')->nullable();
                $table->text('reason_to_contact')->nullable();
                $table->enum('status', ['pending','attended','reprogrammed','cancelled'])->default('pending');
                $table->boolean('reprogrammed')->nullable()->default(0);
                $table->date('new_date')->nullable();
                $table->time('new_time')->nullable();
                $table->text('result')->nullable();
                $table->boolean('triggered')->nullable()->default(0);
                $table->timestamps();
            });
        }
        if(config('customer.tickets')){
            Schema::create('customer_tickets', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('customer_id')->nullable();
                $table->string('name')->nullable();
                $table->text('observations')->nullable();
                $table->enum('status', ['pending','attending','customer-response','completed','closed'])->default('pending');
                $table->timestamps();
            });
            Schema::create('customer_ticket_messages', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('parent_id')->nullable();
                $table->integer('user_id')->nullable();
                $table->text('message')->nullable();
                $table->timestamps();
            });
        }
        if(config('customer.credit_wallet')){
            Schema::create('customer_wallet_transactions', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('parent_id')->nullable();
                $table->string('transaction_code')->nullable();
                $table->enum('type',['increase','decrease'])->nullable();
                $table->decimal('amount', 10, 2)->nullable();
                $table->decimal('initial_amount', 10, 2)->nullable();
                $table->decimal('current_amount', 10, 2)->nullable();
                $table->timestamps();
            });
        }
        if(config('customer.subscriptions')){
            Schema::create('ppvs', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('season_id')->nullable();
                $table->integer('product_bridge_id')->nullable();
                $table->string('name')->nullable();
                $table->enum('status', ['pending','active','closed'])->default('pending');
                $table->date('date')->nullable();
                $table->time('time_in')->nullable(); // Nuevo campo
                $table->time('time_out')->nullable(); // Nuevo campo
                $table->decimal('price', 10, 2)->nullable();
                $table->timestamps();
            });
            Schema::create('ppv_users', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->nullable();
                $table->integer('customer_id')->nullable();
                $table->integer('sale_id')->nullable();
                $table->integer('ppv_id')->nullable();
                $table->string('name')->nullable();
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->enum('status', ['pending','active','expired'])->default('pending');
                $table->decimal('price', 10, 2)->default(0);
                $table->timestamps();
            });
            Schema::create('subscriptions', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('season_id')->nullable();
                $table->integer('product_bridge_id')->nullable();
                $table->string('name')->nullable();
                $table->integer('days')->nullable();
                $table->enum('type', ['monthly','yearly'])->default('monthly');
                $table->enum('status', ['pending','active','closed'])->default('pending');
                $table->decimal('price', 10, 2)->default(0);
                $table->timestamps();
            });
            Schema::create('subscription_users', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->nullable();
                $table->integer('customer_id')->nullable();
                $table->integer('sale_id')->nullable();
                $table->integer('subscription_id')->nullable();
                $table->string('name')->nullable();
                $table->integer('days')->default(30);
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->enum('status', ['pending','active','closed'])->default('pending');
                $table->decimal('price', 10, 2)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Módulo General de Clientes
        Schema::dropIfExists('customer_wallet_transactions');
        Schema::dropIfExists('customer_ticket_messages');
        Schema::dropIfExists('customer_tickets');
        Schema::dropIfExists('customer_contacts');
        Schema::dropIfExists('customer_notes');
        Schema::dropIfExists('customer_activities');
        Schema::dropIfExists('customer_dependants');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('ci_expedition_translation');
        Schema::dropIfExists('ci_expeditions');


    }
}
