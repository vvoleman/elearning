<?php

use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('messages')->insert([
            "title"=>"Hello from the planet Earth",
            "message"=>"Hello World!",
            "author_id"=>1,
            "sent_at"=>\Illuminate\Support\Facades\DB::raw("NOW()")
        ]);
    }
}
