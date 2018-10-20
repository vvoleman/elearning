<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUseCousTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('use_cous', function (Blueprint $table) {
            $table->unsignedInteger("owner_id");
            $table->unsignedInteger("course_id");
            $table->foreign("owner_id")->references("id_u")->on("users");
            $table->foreign("course_id")->references("id_c")->on("courses");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('use_cous');
    }
}
