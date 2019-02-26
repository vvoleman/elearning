<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id_quest');
            $table->unsignedInteger('question_type_id');
            $table->unsignedInteger('quiz_id');
            $table->text('question');
            $table->boolean('isActive')->default(true);
            $table->integer('order')->nullable();
            $table->timestamps();

            $table->foreign('question_type_id')->references('id_qt')->on('question_types');
            $table->foreign('quiz_id')->references('id_q')->on('quizes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
