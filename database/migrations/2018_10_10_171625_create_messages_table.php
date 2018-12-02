<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id_m');
            $table->string('title',32);
            $table->text("message");
            $table->integer("author_id")->unsigned();
            $table->dateTime("sent_at")->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign("author_id")->references("id_u")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
