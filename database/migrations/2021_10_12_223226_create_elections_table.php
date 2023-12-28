<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elections', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('city_id');
            $table->integer('year');
            $table->string('job');
            $table->boolean('elected');
            $table->integer('round');
            $table->integer('number');
            $table->string('name');
            $table->string('nickname');
            $table->integer('votes');
            $table->boolean('situation');
            $table->string('situation_detail');
            $table->string('party');
            $table->integer('party_number');
            $table->string('party_name');
            $table->string('situation_candidate');

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
        Schema::dropIfExists('elections');
    }
}
