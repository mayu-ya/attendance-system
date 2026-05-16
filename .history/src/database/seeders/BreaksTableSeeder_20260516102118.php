<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BreaksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'attendance_record_id' => 1,
            'rest_start' => 12:00,
            'rest_end' => 13:00,
            'rest_total' => 1:00
        ]
        DB::table('breaks')->insert($param);
        $param = [
            'attendance_record_id' => 2,
            'rest_start' => 12:00,
            'rest_end' => 13:00,
            'rest_total' => 1:00
        ]
        DB::table('breaks')->insert($param);
        $param = [
            'attendance_record_id' => 3,
            'rest_start' => 12:00,
            'rest_end' => 13:00,
            'rest_total' => 1:00
        ]
        DB::table('breaks')->insert($param);
    }
}
