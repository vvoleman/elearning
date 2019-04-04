<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizesOpenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizes_open', function (Blueprint $table) {
            $table->increments('id_qo');
            $table->unsignedInteger('quiz_id');
            $table->unsignedInteger('group_id');
            $table->dateTime('opened_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('closing_at');



            $table->foreign('quiz_id')->references('id_q')->on('quizes');
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
        Schema::dropIfExists('quizes_open');
    }
}
