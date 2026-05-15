<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => '山田花子',
            'email' => 'user3@example.com',
            'password' => 'password'
        ];
        DB::table('admins')->insert($param);
    }
}
