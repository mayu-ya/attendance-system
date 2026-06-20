<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

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
            'email_verified_at' => '2026-06-01 12:00:00',
            'password' =>  Hash::make('password')
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => '山田太郎',
            'email' => 'user2@example.com',
            'email_verified_at' => '2026-06-01 12:00:00',
            'password' =>  Hash::make('password')
        ];
        DB::table('users')->insert($param);
        $param = [
            'name' => '山田花子',
            'email' => 'user3@example.com',
            'email_verified_at' => '2026-06-01 12:00:00',
            'password' =>  Hash::make('password')
        ];
        DB::table('users')->insert($param);
    }
}
