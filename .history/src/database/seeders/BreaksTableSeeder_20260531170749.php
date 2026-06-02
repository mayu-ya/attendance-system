<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60
        ];
        DB::table('breaks')->insert($param);
        $param = [
            'attendance_record_id' => 2,
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60
        ];
        DB::table('breaks')->insert($param);
        $param = [
            'attendance_record_id' => 3,
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60
        ];
        DB::table('breaks')->insert($param);

        $param = [
            'attendance_record_id' => 4,
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60
        ];
        DB::table('breaks')->insert($param);
        $param = [
            'attendance_record_id' => 5,
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60
        ];
        DB::table('breaks')->insert($param);
        $param = [
            'attendance_record_id' => 6,
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60
        ];
        DB::table('breaks')->insert($param);

        $param = [
            'attendance_record_id' => 7,
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60
        ];
        DB::table('breaks')->insert($param);
        $param = [
            'attendance_record_id' => 8,
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60
        ];
        DB::table('breaks')->insert($param);
        $param = [
            'attendance_record_id' => 9,
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60
        ];
        DB::table('breaks')->insert($param);
        $param = [
            'attendance_record_id' => 10,
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60
        ];
        DB::table('breaks')->insert($param);
        $param = [
            'attendance_record_id' => 11,
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60
        ];
        DB::table('breaks')->insert($param);
        $param = [
            'attendance_record_id' => 12,
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60
        ];
        DB::table('breaks')->insert($param);

        $param = [
            'attendance_record_id' => 13,
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60
        ];
        DB::table('breaks')->insert($param);
        $param = [
            'attendance_record_id' => 14,
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60
        ];
        DB::table('breaks')->insert($param);
        $param = [
            'attendance_record_id' => 15,
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60
        ];
        DB::table('breaks')->insert($param);

        $param = [
            'attendance_record_id' => 16,
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60
        ];
        DB::table('breaks')->insert($param);
        $param = [
            'attendance_record_id' => 17,
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60
        ];
        DB::table('breaks')->insert($param);
        $param = [
            'attendance_record_id' => 18,
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60
        ];
        DB::table('breaks')->insert($param);
    }
}
