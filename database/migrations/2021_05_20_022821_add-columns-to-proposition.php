<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToProposition extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('propositions', function (Blueprint $table) {
            $table->dropColumn(['situation', 'type']);

            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('situation_id');

            $table->foreign('type_id')
                ->references('id')
                ->on('proposition_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('situation_id')
                ->references('id')
                ->on('proposition_situations')
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
        Schema::table('propositions', function (Blueprint $table) {
            $table->dropColumn(['type_id', 'situation_id']);

            $table->string('type');
            $table->string('situation');
        });
    }
}
