<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

class CreateQuizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizes', function (Blueprint $table) {
            $table->increments('id_q');
            $table->unsignedInteger('course_id');
            $table->string('name',64);
            $table->dateTime('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('isPrivate')->default(true);
            $table->boolean('editMode')->default(true);
            $table->boolean('randomOrder')->default(false);
            $table->integer('minutesAvailable');
            $table->unsignedInteger('referencedModule')->nullable();
            $table->uuid('uuid')->unique();

            $table->foreign('course_id')->references('id_c')->on('courses');
            $table->foreign('referencedModule')->references('id_m')->on('modules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quizes');
    }
}
