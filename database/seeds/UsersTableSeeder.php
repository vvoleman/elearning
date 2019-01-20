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
            'registered' => \Illuminate\Support\Facades\DB::raw("NOW()"),
            'password' => bcrypt("admin"),
        ]);
        DB::table('users')->insert([
            'role_id'=>2,
            'firstname' => "Vojtěch",
            'surname' => "Voleman",
            'email' => "vojtavol69s@email.cz",
            'registered' => \Illuminate\Support\Facades\DB::raw("NOW()"),
            'password' => bcrypt("heslo"),
        ]);
        DB::table('users')->insert([
            'role_id'=>2,
            'firstname' => "Random",
            'surname' => "Jmeno",
            'email' => "random@jmeno.cz",
            'password' => bcrypt("password"),
            'registered' => \Illuminate\Support\Facades\DB::raw("NOW()"),
            'deact_reason' => "You are too stupid to be here!",
            'deact_date' => "2018-10-23 13:19:35",
        ]);
        $this->seedUsers();
    }
    private function seedUsers(){
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'julian',
            'surname' => 'burke',
            'email' => 'julian.burke@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'ricky',
            'surname' => 'hill',
            'email' => 'ricky.hill@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'sergio',
            'surname' => 'wheeler',
            'email' => 'sergio.wheeler@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'debbie',
            'surname' => 'gray',
            'email' => 'debbie.gray@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'amber',
            'surname' => 'sims',
            'email' => 'amber.sims@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'virgil',
            'surname' => 'williams',
            'email' => 'virgil.williams@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'anna',
            'surname' => 'rose',
            'email' => 'anna.rose@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'ava',
            'surname' => 'knight',
            'email' => 'ava.knight@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'christina',
            'surname' => 'mckinney',
            'email' => 'christina.mckinney@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'patricia',
            'surname' => 'cooper',
            'email' => 'patricia.cooper@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'seth',
            'surname' => 'rivera',
            'email' => 'seth.rivera@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'joel',
            'surname' => 'dean',
            'email' => 'joel.dean@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'nicole',
            'surname' => 'ford',
            'email' => 'nicole.ford@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'darrell',
            'surname' => 'richards',
            'email' => 'darrell.richards@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'kirk',
            'surname' => 'hansen',
            'email' => 'kirk.hansen@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'kristin',
            'surname' => 'chapman',
            'email' => 'kristin.chapman@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'holly',
            'surname' => 'wheeler',
            'email' => 'holly.wheeler@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'andrea',
            'surname' => 'cruz',
            'email' => 'andrea.cruz@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'gilbert',
            'surname' => 'marshall',
            'email' => 'gilbert.marshall@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'ed',
            'surname' => 'baker',
            'email' => 'ed.baker@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'joe',
            'surname' => 'james',
            'email' => 'joe.james@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'sam',
            'surname' => 'brown',
            'email' => 'sam.brown@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'jen',
            'surname' => 'boyd',
            'email' => 'jen.boyd@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'morris',
            'surname' => 'carter',
            'email' => 'morris.carter@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'sharon',
            'surname' => 'lopez',
            'email' => 'sharon.lopez@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'brittany',
            'surname' => 'ramos',
            'email' => 'brittany.ramos@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'leo',
            'surname' => 'kelly',
            'email' => 'leo.kelly@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'patricia',
            'surname' => 'rodriguez',
            'email' => 'patricia.rodriguez@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'martha',
            'surname' => 'hoffman',
            'email' => 'martha.hoffman@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'jennifer',
            'surname' => 'green',
            'email' => 'jennifer.green@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'leonard',
            'surname' => 'henry',
            'email' => 'leonard.henry@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'alvin',
            'surname' => 'hayes',
            'email' => 'alvin.hayes@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'mitchell',
            'surname' => 'chavez',
            'email' => 'mitchell.chavez@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'tammy',
            'surname' => 'fletcher',
            'email' => 'tammy.fletcher@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'freddie',
            'surname' => 'rodriquez',
            'email' => 'freddie.rodriquez@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'clayton',
            'surname' => 'wheeler',
            'email' => 'clayton.wheeler@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'mason',
            'surname' => 'berry',
            'email' => 'mason.berry@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'clifford',
            'surname' => 'hart',
            'email' => 'clifford.hart@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'eric',
            'surname' => 'shelton',
            'email' => 'eric.shelton@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'ashley',
            'surname' => 'gardner',
            'email' => 'ashley.gardner@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'micheal',
            'surname' => 'macrae',
            'email' => 'micheal.macrae@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'wesley',
            'surname' => 'sims',
            'email' => 'wesley.sims@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'megan',
            'surname' => 'macrae',
            'email' => 'megan.macrae@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'allie',
            'surname' => 'elliott',
            'email' => 'allie.elliott@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'kurt',
            'surname' => 'daniels',
            'email' => 'kurt.daniels@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'amelia',
            'surname' => 'ford',
            'email' => 'amelia.ford@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'dylan',
            'surname' => 'vasquez',
            'email' => 'dylan.vasquez@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'melissa',
            'surname' => 'mendoza',
            'email' => 'melissa.mendoza@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'zoe',
            'surname' => 'silva',
            'email' => 'zoe.silva@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'alison',
            'surname' => 'montgomery',
            'email' => 'alison.montgomery@example.com',
            'registered' => '2018-12-08 17:05:39',
            'password' => '$2y$10$g0p/2.9RvDfqTODkesjEEeV.20sAwNDicHMZRibAhScBMs5NtF9LG',
        ]);
    }
}
