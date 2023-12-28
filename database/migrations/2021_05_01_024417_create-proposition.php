<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propositions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('city_id');
            $table->string('type');
            $table->string('number');
            $table->string('year', 4);
            $table->dateTime('date');
            $table->string('description', 200);
            $table->string('observation', 150)->nullable();
            $table->string('reference')->nullable();
            $table->string('area');
            $table->string('situation');
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
        Schema::dropIfExists('propositions');
    }
}
