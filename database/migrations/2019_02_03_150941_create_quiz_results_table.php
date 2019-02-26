<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->increments('id_qr');
            $table->unsignedInteger('quiz_id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('group_id');
            $table->dateTime('started_at');
            $table->dateTime('submitted_at');
            $table->tinyInteger('percentage');
            $table->text('context');

            $table->foreign('quiz_id')->references('id_q')->on('quizes');
            $table->foreign('student_id')->references('id_u')->on('users');
            $table->foreign('group_id')->references('id_g')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_results');
    }
}
