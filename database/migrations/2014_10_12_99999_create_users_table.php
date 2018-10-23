<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id_u');
            $table->string('firstname',60);
            $table->string('surname',40);
            $table->string('email',128)->unique();
            $table->string('password');
            $table->integer("role_id")->unsigned();
            $table->foreign('role_id')->references('id_r')->on("roles");
            $table->rememberToken();
            $table->dateTime('registered')->default(\Illuminate\Support\Facades\DB::raw("NOW()"));
            $table->dateTime('last_login')->nullable();
            $table->string('deact_reason')->nullable();
            $table->dateTime('deact_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
