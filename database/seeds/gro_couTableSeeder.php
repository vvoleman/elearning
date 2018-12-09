<?php

use Illuminate\Database\Seeder;

class gro_couTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gro_cou')->insert([
            "course_id"=>1,
            "group_id"=>1,
        ]);
        DB::table('gro_cou')->insert([
            "course_id"=>1,
            "group_id"=>2,
        ]);
        DB::table('gro_cou')->insert([
            "course_id"=>2,
            "group_id"=>1,
        ]);
    }
}
