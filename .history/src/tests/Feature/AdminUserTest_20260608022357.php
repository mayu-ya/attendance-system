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
}
