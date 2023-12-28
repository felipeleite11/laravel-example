<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrefecturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prefectures', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('city_id');
            $table->string('gentilic')->nullable(true);
            $table->string('address')->nullable(true);
            $table->string('zipcode')->nullable(true);
            $table->string('neighborhood')->nullable(true);
            $table->string('association')->nullable(true);
            $table->date('birthdate')->nullable(true);
            $table->string('phone')->nullable(true);
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
        Schema::dropIfExists('prefectures');
    }
}
