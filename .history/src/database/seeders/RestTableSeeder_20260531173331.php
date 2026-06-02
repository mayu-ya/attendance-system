<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'apply_id' => 1,
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60
        ];
        DB::table('rests')->insert($param);
        $param = [
            'apply_id' => 1,
            'rest_start' => '15:00',
            'rest_end' => '15:15',
            'rest_total' => 15
        ];
        DB::table('rests')->insert($param);
        
        $param = [
            'apply_id' => 2,
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60
        ];
        DB::table('rests')->insert($param);

        $param = [
            'apply_id' => 3,
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60
        ];
        DB::table('rests')->insert($param);
    }
}
