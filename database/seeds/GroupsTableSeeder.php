<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            "name"=>"3.ITA 2018/19",
            "owner_id"=>2,
        ]);
        DB::table('groups')->insert([
            "name"=>"3.ITB 2018/19",
            "owner_id"=>2,
        ]);
    }
}
