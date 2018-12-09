<?php

use Illuminate\Database\Seeder;

class use_groTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('use_gro')->insert([
            "student_id"=>5,
            "group_id"=>1,
        ]);
        DB::table('use_gro')->insert([
            "student_id"=>6,
            "group_id"=>1,
        ]);
        DB::table('use_gro')->insert([
            "student_id"=>5,
            "group_id"=>2,
        ]);
        DB::table('use_gro')->insert([
            "student_id"=>7,
            "group_id"=>2,
        ]);
    }
}
