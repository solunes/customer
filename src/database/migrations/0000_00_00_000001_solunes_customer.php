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
                $table->enum('ci_expedition_basic', ['LP','SC','CB','CH','TA','OR','PO','BE','PA','OTRO'])->default('LP'); // Obligatorio
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
            $table->timestamps();
        });
        if(config('customer.dependants')){
            Schema::create('customer_dependants', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('customer_id')->nullable();
                $table->string('name')->nullable();
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Módulo General de Clientes
        Schema::dropIfExists('customer_ticket_messages');
        Schema::dropIfExists('customer_tickets');
        Schema::dropIfExists('customer_notes');
        Schema::dropIfExists('customer_activities');
        Schema::dropIfExists('customer_dependants');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('ci_expedition_translation');
        Schema::dropIfExists('ci_expeditions');


    }
}
