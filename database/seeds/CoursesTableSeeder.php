<?php

use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courses')->insert([
            "name"=>"Český jazyk 3. ročník",
            "desc"=>"Český jazyk neboli čeština je západoslovanský jazyk, nejbližší slovenštině, poté lužické srbštině a polštině. Patří mezi slovanské jazyky, do rodiny jazyků indoevropských. Čeština se vyvinula ze západních nářečí praslovanštiny na konci 10. století. Je částečně ovlivněná latinou a němčinou.",
            "created_at" => \Illuminate\Support\Facades\DB::raw("NOW()")
        ]);
        DB::table('courses')->insert([
            "name"=>"Matematika A 3. ročník",
            "desc"=>"Matematika je věda zabývající se z formálního hlediska kvantitou, strukturou, prostorem a změnou. Matematika je též popisována jako disciplína, jež se zabývá vytvářením abstraktních entit a vyhledáváním zákonitých vztahů mezi nimi.",
            "created_at" => \Illuminate\Support\Facades\DB::raw("NOW()")
            ]);
    }
}
