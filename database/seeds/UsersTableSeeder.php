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
    }
}
