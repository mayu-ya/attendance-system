<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Database\Seeders\DatabaseSeeder;
use App\Models\User;
use App\Models\AttendanceRecord;
use App\Models\BreakTime;
use \Carbon\Carbon;

class DetailTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_detail_name()
    {
        $user = User::find(1);
        $attendance = AttendanceRecord::create([
            'user_id' => $user->id,
            'date' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
            'end_time' => '17:00',
            'work_total' => '7:00',
            'duration' => '1:00',
        ]);

        $response = $this->actingAs($user)->get('/attendance/detail/' . $attendance->id)->assertStatus(200);

        $name = $attendance->user->name;
        $response->assertSee($name);
    }

    public function test_detail_date()
    {
        $user = User::find(1);
        $attendance = AttendanceRecord::create([
            'user_id' => $user->id,
            'date' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
            'end_time' => '17:00',
            'work_total' => '7:00',
            'duration' => '1:00',
        ]);

        $response = $this->actingAs($user)->get('/attendance/detail/' . $attendance->id)->assertStatus(200);

        $name = $attendance->date;
        $response->assertSee($date);
    }

    public function test_timestamp_work()
    {
        $user = User::find(1);
        $attendance = AttendanceRecord::create([
            'user_id' => $user->id,
            'date' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
            'end_time' => '17:00',
            'work_total' => '7:00',
            'duration' => '1:00',
        ]);

        $response = $this->actingAs($user)->get('/attendance/detail/' . $attendance->id)->assertStatus(200);

        $startTime = Carbon::parse($attendance->start_time)->format('H:i');
        $endTime = Carbon::parse($attendance->end_time)->format('H:i');
        $response->assertSee($startTime);
        $response->assertSee($endTime);
    }

    public function test_timestamp_break()
    {
        $user = User::find(1);
        $attendance = AttendanceRecord::create([
            'user_id' => $user->id,
            'date' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
            'end_time' => '17:00',
            'work_total' => '7:00',
            'duration' => '1:00',
        ]);
        $break = BreakTime::create([
            'attendance_record_id' => $attendance->id,
            'rest_start' => '12:00',
            'rest_end' => '13:00',
            'rest_total' => 60,
        ]);

        $response = $this->actingAs($user)->get('/attendance/detail/' . $attendance->id)->assertStatus(200);

        $restStart = Carbon::parse($break->rest_start)->format('H:i');
        $restEnd = Carbon::parse($break->rest_end)->format('H:i');
        $response->assertSee($restStart);
        $response->assertSee($restEnd);
    }
}
