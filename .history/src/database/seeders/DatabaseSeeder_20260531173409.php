<?php

namespace Database\Seeders;

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
        $this->call(UsersTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(Attendance_recordsTableSeeder::class);
        $this->call(BreaksTableSeeder::class);
        $this->call(AppliesTableSeeder::class);
        $this->call(RestsTableSeeder::class);
    }
}
