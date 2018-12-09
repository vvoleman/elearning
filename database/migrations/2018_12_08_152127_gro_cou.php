<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GroCou extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gro_cou', function (Blueprint $table) {
            $table->integer('course_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->dateTime('expirate_at')->nullable();
            $table->foreign('course_id')->references('id_c')->on('courses');
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
        Schema::dropIfExists('gro_cou');
    }
}
