<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id'=>3,
            'firstname' => "Marco",
            'surname' => "Polo",
            'email' => "admin@themulti.eu",
            'password' => bcrypt("admin"),
        ]);
        DB::table('users')->insert([
            'role_id'=>1,
            'firstname' => "Vojtěch",
            'surname' => "Voleman",
            'email' => "vojtavol@email.cz",
            'password' => bcrypt("pedro12"),
        ]);
        DB::table('users')->insert([
            'role_id'=>1,
            'firstname' => "Moon",
            'surname' => "Moon",
            'email' => "moon@moon.cz",
            'password' => bcrypt("moon"),
            'deact_reason' => "You are too stupid to be here!",
            'deact_date' => "2018-10-23 13:19:35",
        ]);
    }
}
