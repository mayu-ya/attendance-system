<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ApplyTableSeeder extends Seeder
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
            'admin_id' => 3,
            'attendance_record_id' => 1,
            'date' => '2026/4/1',
            'start_time' => '9:30',
            'end_time' => '17:00',
            'work_total' => '6:30',
            'duration' => '1:15',
            'content' => '電車遅延のため',
            'status' => 'approved'
        ];
        DB::table('attendance_records')->insert($param);

        $param = [
            'user_id' => 2,
            'attendance_record_id' => 10,
            'date' => '2026/5/3',
            'start_time' => '9:30',
            'end_time' => '17:00',
            'content' => '電車遅延のため',
            'status' => 'pending'
        ];
        DB::table('attendance_records')->insert($param);

        $param = [
            'user_id' => 3,
            'attendance_record_id' => 15,
            'date' => '2026/4/5',
            'start_time' => '9:30',
            'end_time' => '17:00',
            'content' => '電車遅延のため',
            'status' => 'pending'
        ];
        DB::table('attendance_records')->insert($param);
    }
}
