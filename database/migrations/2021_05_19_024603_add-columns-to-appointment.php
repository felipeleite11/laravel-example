<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToAppointment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['administration', 'situation', 'type']);
            $table->unsignedBigInteger('administration_id');
            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('situation_id');

            $table->foreign('administration_id')
                ->references('id')
                ->on('appointment_administrations')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('type_id')
                ->references('id')
                ->on('appointment_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('situation_id')
                ->references('id')
                ->on('appointment_situations')
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
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['administration_id', 'type_id', 'situation_id']);

            $table->string('administration');
            $table->string('type');
            $table->string('situation');
        });
    }
}
