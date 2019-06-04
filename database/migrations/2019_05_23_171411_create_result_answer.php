<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultAnswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('res_opt', function (Blueprint $table) {
            $table->unsignedInteger('option_id');
            $table->unsignedInteger('qr_id');

            $table->foreign('option_id')->references('id_o')->on('options');
            $table->foreign('qr_id')->references('id_qr')->on('quiz_results');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('res_opt');
    }
}
