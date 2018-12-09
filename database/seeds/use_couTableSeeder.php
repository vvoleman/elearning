<?php

use Illuminate\Database\Seeder;

class use_couTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('use_cou')->insert([
            "owner_id"=>2,
            "course_id"=>1,
        ]);
        DB::table('use_cou')->insert([
            "owner_id"=>3,
            "course_id"=>1,
        ]);
        DB::table('use_cou')->insert([
            "owner_id"=>3,
            "course_id"=>2,
        ]);
    }
}
