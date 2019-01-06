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
            "slug"=>"qa4s4hrd",
            "owner_id"=>2,
        ]);
        DB::table('groups')->insert([
            "name"=>"3.ITB 2018/19",
            "slug"=>"czd7vg8q",
            "owner_id"=>2,
        ]);
    }
}
