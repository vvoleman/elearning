<?php

use Illuminate\Database\Seeder;

class OptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('options')->insert([
            "question_id"=>1,
            "value"=>"Labe"
        ]);
        DB::table('options')->insert([
            "question_id"=>1,
            "value"=>"Vltava"
        ]);
        DB::table('options')->insert([
            "question_id"=>1,
            "value"=>"Ohře"
        ]);
        DB::table('options')->insert([
            "question_id"=>1,
            "value"=>"Berounka"
        ]);
    }
}
