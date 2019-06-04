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
            $table->unsignedInteger('open_id');
            $table->unsignedInteger('student_id');
            $table->dateTime('started_at');
            $table->dateTime('submitted_at')->nullable();
            $table->integer('points')->nullable();
            $table->decimal('percentage',8,2)->nullable();

            $table->foreign('open_id')->references('id_qo')->on('quizes_open');
            $table->foreign('student_id')->references('id_u')->on('users');
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
