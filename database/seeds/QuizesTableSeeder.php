<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class QuizesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('quizes')->insert([
            "course_id" => 1,
            "name" => "test",
            "editMode" => 0,
            "uuid" => Str::uuid(),
            "minutesAvailable" => 20
        ]);
    }
}
