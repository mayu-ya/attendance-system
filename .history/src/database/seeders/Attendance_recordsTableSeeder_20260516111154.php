<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class Attendance_recordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => 1,
            'date' => 2026/4/1,
            'start_time' => 9:00,
            'end_time' => 17:00,
            'work_total' => 7:00
        ];
        DB::table('attendance_records')->insert($param);
        $param = [
            'user_id' => 1,
            'date' => 2026/4/2,
            'start_time' => 9:00,
            'end_time' => 17:00,
            'work_total' => 7:00
        ];
        DB::table('attendance_records')->insert($param);
        $param = [
            'user_id' => 1,
            'date' => 2026/4/4,
            'start_time' => 9:00,
            'end_time' => 17:00,
            'work_total' => 7:00
        ];
        DB::table('attendance_records')->insert($param);

        $param = [
            'user_id' => 2,
            'date' => 2026/4/1,
            'start_time' => 9:00,
            'end_time' => 17:00,
            'work_total' => 7:00
        ];
        DB::table('attendance_records')->insert($param);
        $param = [
            'user_id' => 2,
            'date' => 2026/4/2,
            'start_time' => 9:00,
            'end_time' => 17:00,
            'work_total' => 7:00
        ];
        DB::table('attendance_records')->insert($param);
        $param = [
            'user_id' => 2,
            'date' => 2026/4/3,
            'start_time' => 9:00,
            'end_time' => 17:00,
            'work_total' => 7:00
        ];
        DB::table('attendance_records')->insert($param);

        $param = [
            'user_id' => 3,
            'date' => 2026/4/1,
            'start_time' => 9:00,
            'end_time' => 17:00,
            'work_total' => 7:00
        ];
        DB::table('attendance_records')->insert($param);
        $param = [
            'user_id' => 3,
            'date' => 2026/4/3,
            'start_time' => 9:00,
            'end_time' => 17:00,
            'work_total' => 7:00
        ];
        DB::table('attendance_records')->insert($param);

        $param = [
            'user_id' => 3,
            'date' => 2026/4/5,
            'start_time' => 9:00,
            'end_time' => 18:00,
            'work_total' => 8:00
        ];
        DB::table('attendance_records')->insert($param);
    }
}
