<?php

use Illuminate\Database\Seeder;

class que_ansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('que_ans')->insert([
            "question_id"=>1,
            "option_id"=>2
        ]);
    }
}
