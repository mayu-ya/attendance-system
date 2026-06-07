<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Database\Seeders\DatabaseSeeder;
use App\Models\User;
use App\Models\Admin;
use App\Models\AttendanceRecord;
use App\Models\BreakTime;
use \Carbon\Carbon;

class AdminAttendanceTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_attendance()
    {
        $admin = Admin::find(1);
        $user = User::find(1);
        $other = User::find(2);
        $attendance = AttendanceRecord::create([
            'user_id' => $user->id,
            'date' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
            'end_time' => '17:00',
            'work_total' => '7:00',
            'duration' => '1:00',
        ]);
        $record = AttendanceRecord::create([
            'user_id' => $other->id,
            'date' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
            'end_time' => '17:00',
            'work_total' => '7:00',
            'duration' => '1:00',
        ]);

        $name = $attendance->user->name;
        $start = Carbon::parse($attendance->start_time)->format('H:i');
        $end = Carbon::parse($attendance->end_time)->format('H:i');
        $workTotal = Carbon::parse($attendance->work_total)->format('H:i');
        $duration = Carbon::parse($attendance->duration)->format('H:i');
        $other = $record->user->name;
        $recordStart = Carbon::parse($record->start_time)->format('H:i');
        $recordEnd = Carbon::parse($record->end_time)->format('H:i');
        $recordTotal = Carbon::parse($record->work_total)->format('H:i');
        $recordDuration = Carbon::parse($record->duration)->format('H:i');

        $response = $this->actingAs($admin, 'admin')->get('/admin/attendance/list')->assertStatus(200);

        $response->assertSee($name);
        $response->assertSee($start);
        $response->assertSee($end);
        $response->assertSee($workTotal);
        $response->assertSee($duration);
        $response->assertSee($other);
        $response->assertSee($recordStart);
        $response->assertSee($recordEnd);
        $response->assertSee($recordTotal);
        $response->assertSee($recordDuration);
    }

    public function test_today()
    {
        $admin = Admin::find(1);
        $day = Carbon::now();
        $today = carbon::parse($day)->isoFormat('Y/m/d');

        $response = $this->actingAs($admin, 'admin')->get('/admin/attendance/list')->assertStatus(200);

        $response->assertSee($today);
    }

    public function test_sub_month()
    {
        $user = User::find(1);
        $attendance = AttendanceRecord::create([
            'user_id' => $user->id,
            'date' => Carbon::now()->subDay()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
            'end_time' => '17:00',
            'work_total' => '7:00',
            'duration' => '1:00',
        ]);
        $name = $attendance->user->name;
        $subDay = Carbon::parse($attendance->date)->isoFormat('YYYY/MM/DD');
        $startTime = Carbon::parse($attendance->start_time)->format('H:i');
        $endTime = Carbon::parse($attendance->end_time)->format('H:i');
        $workTotal = Carbon::parse($attendance->work_total)->format('H:i');
        $duration = Carbon::parse($attendance->duration)->format('H:i');

        $response = $this->actingAs($user, 'admin')->get('/admin/attendance/list')->assertStatus(200);

        $day = Carbon::toDay();
        $date = Carbon::parse($day)->isoFormat('YYYY/MM/DD');

        $response = $this->from('/admin/attendance/list')->followingRedirects()->post('/admin/attendance/list', [
            'date' => $date,
            'action' => 'sub',
        ]);

        $response->assertSee($subDay);
        $response->assertSee($name);
        $response->assertSee($startTime);
        $response->assertSee($endTime);
        $response->assertSee($workTotal);
        $response->assertSee($duration);
    }

    public function test_add_month()
    {
        $user = User::find(1);
        $attendance = AttendanceRecord::create([
            'user_id' => $user->id,
            'date' => Carbon::now()->addDay()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
            'end_time' => '17:00',
            'work_total' => '7:00',
            'duration' => '1:00',
        ]);
        $name = $attendance->user->name;
        $addDay = Carbon::parse($attendance->date)->isoFormat('YYYY/MM/DD');
        $startTime = Carbon::parse($attendance->start_time)->format('H:i');
        $endTime = Carbon::parse($attendance->end_time)->format('H:i');
        $workTotal = Carbon::parse($attendance->work_total)->format('H:i');
        $duration = Carbon::parse($attendance->duration)->format('H:i');

        $response = $this->actingAs($user, 'admin')->get('/admin/attendance/list')->assertStatus(200);

        $day = Carbon::toDay();
        $date = Carbon::parse($day)->isoFormat('YYYY/MM/DD');

        $response = $this->from('/admin/attendance/list')->followingRedirects()->post('/admin/attendance/list', [
            'date' => $date,
            'action' => 'add',
        ]);

        $response->assertSee($addDay);
        $response->assertSee($name);
        $response->assertSee($startTime);
        $response->assertSee($endTime);
        $response->assertSee($workTotal);
        $response->assertSee($duration);
    }
}
