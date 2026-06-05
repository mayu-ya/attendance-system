<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Database\Seeders\DatabaseSeeder;
use App\Models\User;
use \Carbon\Carbon;

class StatusTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_time()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->get('/attendance')->assertStatus(200);

        $day = Carbon::now()->isoFormat('YYYY年MM月DD日（ddd）');
        $time = Carbon::now()->format('H:i');

        $response->assertSee($day);
        $response->assertSee($time);
    }

    public function test_status_before_work()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->get('/attendance')->assertStatus(200);

        $response->assertSee('勤務外');
    }

    public function test_status_working()
    {
        $user = User::find(1);
        AttendanceRecord::create([
            'user_id' => 1,
            'date' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
        ]);

        $response = $this->actingAs($user)->get('/attendance')->assertStatus(200);

        $response->assertSee('出勤中');
    }

    public function test_status_break()
    {
        $user = User::find(1);
        AttendanceRecord::create([
            'user_id' => 1,
            'date' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
        ]);
        BreakTime::create([
            'attendance_record_id' => 19,
            'rest_start' =>'12:00',
        ]);

        $response = $this->actingAs($user)->get('/attendance')->assertStatus(200);

        $response->assertSee('休憩中');
    }

    public function test_status_finsh_work()
    {
        $user = User::find(1);
        AttendanceRecord::create([
            'user_id' => 1,
            'date' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
            'end_time' => '17:00',
        ]);

        $response = $this->actingAs($user)->get('/attendance')->assertStatus(200);

        $response->assertSee('退勤済');
    }
}
