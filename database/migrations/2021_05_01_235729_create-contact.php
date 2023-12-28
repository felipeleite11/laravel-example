<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('city_id');
            $table->string('name');
            $table->string('nick')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('gender', 1);
            $table->integer('type');
            $table->string('occupation');           
            $table->string('cep', 9)->nullable();
            $table->string('district')->nullable();
            $table->string('address')->nullable();
            $table->string('complement')->nullable();
            $table->string('email')->nullable();
            $table->string('landline', 14)->nullable();
            $table->string('phone', 15)->nullable();
            $table->string('phone_2', 15)->nullable();
            $table->string('observation')->nullable();
            $table->string('political_info')->nullable();
            $table->timestamps();

            $table->foreign('state_id')
                ->references('id')
                ->on('states')
                ->onDelete('cascade')
                ->onUpdate('cascade');
                
            $table->foreign('city_id')
                ->references('id')
                ->on('cities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
