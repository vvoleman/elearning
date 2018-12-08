<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UseGro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('use_gro', function (Blueprint $table) {
            $table->integer('student_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->dateTime('added')->default(DB::raw('CURRENT_TIMESTAMP'));
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
        Schema::dropIfExists('use_gro');
    }
}
