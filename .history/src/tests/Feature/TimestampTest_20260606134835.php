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

class TimestampTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_before_work()
    {
        $user = User::find(1);

        $response = $this->actingAs($user)->get('/attendance')->assertStatus(200);

        $response->assertSee('出勤');

        $response = $this->from('/attendance')->post('/working/start', [
            'user_id' => $user->id,
            'date' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
            'start_time' => Carbon::now()->format('H:i'),
        ]);

        $response = $this->get('/attendance')->assertSee('出勤中');
    }

    public function test_work_button()
    {
        $user = User::find(1);
        AttendanceRecord::create([
            'user_id' => 1,
            'date' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
            'end_time' => '17:00',
        ]);

        $response = $this->actingAs($user)->get('/attendance')->assertStatus(200);

        $response->assertDontSee('出勤');
        $response->assertSee('お疲れ様でした。');
    }

    public function test_start_time_list()
    {
        $user = User::find(1);

        $response = $this->actingAs($user)->get('/attendance')->assertStatus(200);

        $day = Carbon::now();
        $time = Carbon::now()->format('H:i');

        $response = $this->from('/attendance')->post('/working/start', [
            'user_id' => $user->id,
            'date' => $day->isoFormat('YYYY/MM/DD/'),
            'start_time' => $time,
        ]);

        $response = $this->get('/attendance/list')->assertStatus(200);
        $response->assertSee($day->isoFormat('YYYY-MM-DD'));
        $response->assertSee($time);
    }

    public function test_before_break()
    {
        $user = User::find(1);
        $attendance = AttendanceRecord::create([
            'user_id' => 1,
            'date' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
        ]);

        $response = $this->actingAs($user)->get('/attendance')->assertStatus(200);

        $response->assertSee('休憩入');

        $response = $this->from('/attendance')->post('/break/start', [
            'attendance_record_id' => $attendance->id,
            'rest_start' => Carbon::now()->format('H:i'),
        ]);

        $response = $this->get('/attendance')->assertSee('休憩中');
    }

    public function test_many_time_breaks()
    {
        $user = User::find(1);
        $attendance = AttendanceRecord::create([
            'user_id' => 1,
            'date' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
        ]);

        $response = $this->actingAs($user)->get('/attendance')->assertStatus(200);

        $restStart = Carbon::now()->format('H:i');
        $break = $this->from('/attendamce')->post('/break/start', [
            'attendance_record_id' => $attendance->id,
            'rest_start' => $restStart,
        ]);

        $this->get('/attendance')->assertSee('休憩戻');

        $now = Carbon::now();
        $breakStart = Carbon::parse($restStart);
        $total = $now->diffInMinutes($breakStart);
        $response = $this->from('/attendamce')->post('/break/end', [
            'rest_end' => Carbon::now()->format('H:i'),
            'rest_total' => $total,
        ]);

        $response = $this->get('/attendance')->assertSee('休憩入');
    }

    public function test_break_button()
    {
        $user = User::find(1);
        $attendance = AttendanceRecord::create([
            'user_id' => 1,
            'date' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
        ]);

        $response = $this->actingAs($user)->get('/attendance')->assertStatus(200);

        $restStart = Carbon::now()->format('H:i');
        $break = $this->from('/attendamce')->post('/break/start', [
            'attendance_record_id' => $attendance->id,
            'rest_start' => $restStart,
        ]);

        $response = $this->get('/attendance')->assertSee('休憩戻');

        $now = Carbon::now();
        $breakStart = Carbon::parse($restStart);
        $total = $now->diffInMinutes($breakStart);
        $response = $this->from('/attendamce')->post('/break/end', [
            'rest_end' => Carbon::now()->format('H:i'),
            'rest_total' => $total,
        ]);

        $response = $this->get('/attendance')->assertSee('出勤中');
    }

    public function test_many_time_end_breaks()
    {
        $user = User::find(1);
        $attendance = AttendanceRecord::create([
            'user_id' => 1,
            'date' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
        ]);

        $response = $this->actingAs($user)->get('/attendance')->assertStatus(200);

        $restStart = Carbon::now()->format('H:i');
        $break = $this->from('/attendamce')->post('/break/start', [
            'attendance_record_id' => $attendance->id,
            'rest_start' => $restStart,
        ]);

        $now = Carbon::now();
        $breakStart = Carbon::parse($restStart);
        $total = $now->diffInMinutes($breakStart);
        $response = $this->from('/attendamce')->post('/break/end', [
            'rest_end' => Carbon::now()->format('H:i'),
            'rest_total' => $total,
        ]);

        $response = $this->from('/attendamce')->post('/break/start', [
            'attendance_record_id' => $attendance->id,
            'rest_start' => Carbon::now()->format('H:i'),
        ]);

        $response = $this->get('/attendance')->assertSee('休憩戻');
    }

    public function test_time_list()
    {
        $user = User::find(1);
        $attendance = AttendanceRecord::create([
            'user_id' => 1,
            'date' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
        ]);

        $response = $this->actingAs($user)->get('/attendance')->assertStatus(200);

        $restStart = Carbon::now()->format('H:i');
        $break = $this->from('/attendamce')->post('/break/start', [
            'attendance_record_id' => $attendance->id,
            'rest_start' => $restStart,
        ]);

        $now = Carbon::now();
        $breakStart = Carbon::parse($restStart);
        $total = $now->diffInMinutes($breakStart);
        $response = $this->from('/attendamce')->post('/break/end', [
            'rest_end' => Carbon::now()->format('H:i'),
            'rest_total' => $total,
        ]);

        $response = $this->from('/attendamce')->post('/break/start', [
            'attendance_record_id' => $attendance->id,
            'rest_start' => Carbon::now()->format('H:i'),
        ]);

        $response = $this->get('/attendance/list')->assertSee('休憩戻');
    }

    public function test_end_work()
    {
        $user = User::find(1);
        $attendance = AttendanceRecord::create([
            'user_id' => 1,
            'date' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
        ]);

        $response = $this->actingAs($user)->get('/attendance')->assertStatus(200);

        $response->assertSee('退勤');

        $work = AttendanceRecord::find($attendance->id);
        $start = Carbon::parse($work->start_time);
        $end = Carbon::now();
        $total = $start->diffInMinutes($end);
        $totalTime = sprintf('%02d:%02d:00', floor($total / 60), $total % 60);

        $response = $this->from('/attendance')->post('/working/end', [
            'end_time' => $end->format('H:i'),
            'work_total' => $totalTime,
            'duration' => '01:00',
        ]);

        $response = $this->get('/attendance')->assertSee('退勤済');
    }
}
