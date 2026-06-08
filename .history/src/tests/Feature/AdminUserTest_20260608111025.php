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

class AdminUserTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_staff()
    {
        $admin = Admin::find(1);
        $user = User::find(1);
        $other = User::find(2);

        $userName = $user->name;
        $userEmail = $user->email;
        $otherName = $other->name;
        $otherEmail = $other->email;

        $response = $this->actingAs($admin, 'admin')->get('/admin/staff/list')->assertStatus(200);

        $response->assertSee($userName);
        $response->assertSee($userEmail);
        $response->assertSee($otherName);
        $response->assertSee($otherEmail);
    }

    public function test_user()
    {
        $admin = Admin::find(1);
        $user = User::find(1);
        $attendance = AttendanceRecord::create([
            'user_id' => $user->id,
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

        $response = $this->actingAs($admin, 'admin')->get('/admin/attendance/staff/' . $user->id)->assertStatus(200);

        $response->assertSee($name);
        $response->assertSee($start);
        $response->assertSee($end);
        $response->assertSee($workTotal);
        $response->assertSee($duration);
    }

    public function test_sub_month()
    {
        $admin = Admin::find(1);
        $user = User::find(1);
        $attendance = AttendanceRecord::create([
            'user_id' => $user->id,
            'date' => Carbon::now()->subMonth()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
            'end_time' => '17:00',
            'work_total' => '7:00',
            'duration' => '1:00',
        ]);

        $userId = $attendance->user->id;
        $name = $attendance->user->name;
        $subMonth = Carbon::parse($attendance->date)->format('Y/m');
        $startTime = Carbon::parse($attendance->start_time)->format('H:i');
        $endTime = Carbon::parse($attendance->end_time)->format('H:i');
        $workTotal = Carbon::parse($attendance->work_total)->format('H:i');
        $duration = Carbon::parse($attendance->duration)->format('H:i');

        $response = $this->actingAs($admin, 'admin')->get('/admin/attendance/staff/' . $userId)->assertStatus(200);

        $year = Carbon::today()->format('Y');
        $month = Carbon::today()->format('m');

        $response = $this->from('/admin/attendance/staff/' . $userId)
                    ->followingRedirects()->post('/admin/attendance/staff/' . $userId, [
                        'year' => $year,
                        'month' => $month,
                        'action' => 'sub',
        ]);

        $response->assertSee($subMonth);
        $response->assertSee($name);
        $response->assertSee($startTime);
        $response->assertSee($endTime);
        $response->assertSee($workTotal);
        $response->assertSee($duration);
    }

    public function test_add_month()
    {
        $admin = Admin::find(1);
        $user = User::find(1);
        $attendance = AttendanceRecord::create([
            'user_id' => $user->id,
            'date' => Carbon::now()->addMonth()->isoFormat('YYYY/MM/DD'),
            'start_time' => '9:00',
            'end_time' => '17:00',
            'work_total' => '7:00',
            'duration' => '1:00',
        ]);

        $userId = $attendance->user->id;
        $name = $attendance->user->name;
        $addMonth = Carbon::parse($attendance->date)->format('Y/m');
        $startTime = Carbon::parse($attendance->start_time)->format('H:i');
        $endTime = Carbon::parse($attendance->end_time)->format('H:i');
        $workTotal = Carbon::parse($attendance->work_total)->format('H:i');
        $duration = Carbon::parse($attendance->duration)->format('H:i');

        $response = $this->actingAs($admin, 'admin')->get('/admin/attendance/staff/' . $userId)->assertStatus(200);

        $year = Carbon::today()->format('Y');
        $month = Carbon::today()->format('m');

        $response = $this->from('/admin/attendance/staff/' . $userId)
                    ->followingRedirects()->post('/admin/attendance/staff/' . $userId, [
                        'year' => $year,
                        'month' => $month,
                        'action' => 'add',
        ]);

        $response->assertSee($addMonth);
        $response->assertSee($name);
        $response->assertSee($startTime);
        $response->assertSee($endTime);
        $response->assertSee($workTotal);
        $response->assertSee($duration);
    }

    public function test_staff_detail()
    {
        $admin = Admin::find(1);
        $attendance = AttendanceRecord::with('breaks')->find(2);

        $userId = $attendance->user->id;
        $name = $attendance->user->name;
        $year = Carbon::parse($attendance->date)->isoFormat('YYYY年');
        $day = Carbon::parse($attendance->date)->isoFormat('MM月DD日');
        $startTime = Carbon::parse($attendance->start_time)->format('H:i');
        $endTime = Carbon::parse($attendance->end_time)->format('H:i');
        foreach($attendance->breaks as $break){
            $restStart = Carbon::parse($break->rest_start)->format('H:i');
            $restEnd = Carbon::parse($break->rest_end)->format('H:i');
        }

        $response = $this->actingAs($admin, 'admin')->get('/admin/attendance/staff/' . $userId)->assertStatus(200);

        $response = $this->get('/admin/attendance/' . $attendance->id)->assertStatus(200);

        $response->assertSee($name);
        $response->assertSee($year);
        $response->assertSee($day);
        $response->assertSee($startTime);
        $response->assertSee($endTime);
        $response->assertSee($restStart);
        $response->assertSee($restEnd);
    }
}
