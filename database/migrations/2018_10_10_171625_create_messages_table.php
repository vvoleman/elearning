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
            $table->text("message");
            $table->unsignedInteger("author_id");
            $table->unsignedInteger("receiver_id");
            $table->dateTime("sent_at");
            $table->dateTime("seen_at");
            $table->foreign("author_id")->references("id_u")->on("users");
            $table->foreign("receiver_id")->references("id_u")->on("users");
            $table->timestamps();
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
