<?php

namespace Database\Seeders;

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
        $param = [
            'name' => '西玲奈',
            'email' => 'user1@example.com',
            'password' => 'password'
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => '山田太郎',
            'email' => 'user2@example.com',
            'password' => 'password'
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => '山田花子',
            'email' => 'user3@example.com',
            'password' => 'password'
        ];
        DB::table('users')->insert($param);
    }
}
