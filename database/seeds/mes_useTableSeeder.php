<?php

use Illuminate\Database\Seeder;

class mes_useTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mes_use')->insert([
            "user_id"=>2,
            "message_id"=>1,
            "seen"=>\Illuminate\Support\Facades\DB::raw("NOW()")
        ]);
    }
}
