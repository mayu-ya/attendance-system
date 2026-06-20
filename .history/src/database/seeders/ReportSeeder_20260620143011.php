<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportSeeder extends Seeder
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
            'month' => '2026-04',
            'total_work' => 1260,
            'total_overtime' => 0,
            'average_work' => 420,
            'behind_time' => 0,
            'leaving_early' => 3,
            'overtime_day' => 0
        ];
        DB::table('reports')->insert($param);
        $param = [
            'user_id' => 2,
            'month' => '2026-04',
            'total_work' => 1260,
            'total_overtime' => 0,
            'average_work' => 420,
            'behind_time' => 0,
            'leaving_early' => 3,
            'overtime_day' => 0
        ];
        DB::table('reports')->insert($param);
        $param = [
            'user_id' => 3,
            'month' => '2026-04',
            'total_work' => 1320,
            'total_overtime' => 0,
            'average_work' => 440,
            'behind_time' => 0,
            'leaving_early' => 2,
            'overtime_day' => 0
        ];
        DB::table('reports')->insert($param);

        $param = [
            'user_id' => 1,
            'month' => '2026-05',
            'total_work' => 1260,
            'total_overtime' => 0,
            'average_work' => 420,
            'behind_time' => 0,
            'leaving_early' => 3,
            'overtime_day' => 0
        ];
        DB::table('reports')->insert($param);
        $param = [
            'user_id' => 2,
            'month' => '2026-05',
            'total_work' => 1260,
            'total_overtime' => 0,
            'average_work' => 420,
            'behind_time' => 0,
            'leaving_early' => 3,
            'overtime_day' => 0
        ];
        DB::table('reports')->insert($param);
        $param = [
            'user_id' => 3,
            'month' => '2026-05',
            'total_work' => 1320,
            'total_overtime' => 0,
            'average_work' => 440,
            'behind_time' => 0,
            'leaving_early' => 2,
            'overtime_day' => 0
        ];
        DB::table('reports')->insert($param);
    }
}
