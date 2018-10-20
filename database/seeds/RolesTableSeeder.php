<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => "user",
        ]);
        DB::table('roles')->insert([
            'name' => "teacher",
        ]);
        DB::table('roles')->insert([
            'name' => "admin",
        ]);
    }
}
