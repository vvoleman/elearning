<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class QueAns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('que_ans', function (Blueprint $table) {
            $table->unsignedInteger('question_id');
            $table->unsignedInteger('option_id');

            $table->foreign('question_id')->references('id_quest')->on('questions');
            $table->foreign('option_id')->references('id_o')->on('options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
