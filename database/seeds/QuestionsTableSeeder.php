<?php

use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('questions')->insert([
            "quiz_id" => 1,
            "question_type_id" => 1,
            "question" => "Jaká řeka protéká Prahou?"
        ]);
    }
}
