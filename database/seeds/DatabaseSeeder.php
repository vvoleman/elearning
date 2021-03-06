<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(mes_useTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(CoursesTableSeeder::class);
        $this->call(use_couTableSeeder::class);
        $this->call(gro_couTableSeeder::class);
        $this->call(use_groTableSeeder::class);
        $this->call(QuizesTableSeeder::class);
        $this->call(QuestionTypesTableSeeder::class);
        $this->call(QuestionsTableSeeder::class);
        $this->call(OptionsTableSeeder::class);
        $this->call(que_ansTableSeeder::class);
    }
}
