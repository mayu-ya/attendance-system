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

class AdminDetailTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_detail()
    {
        $admin = Admin::find(1);
        $attendance =AttendanceRecord::with('breaks')->find(1);

        $name = $attendance->user->name;
        $date = Carbon::parse($date)->isoFormat('YYYY年MM月DD日');
        $start = Carbon::parse($attendance->start_time)->format('H:i');
        $end = Carbon::parse($attendance->end_time)->format('H:i');
        $restStart = Carbon::parse($attendance->break->rest_start)->format('H:i');
        $restEnd = Carbon::parse($attendance->break->rest_end)->format('H:i');

        $response = $this->actingAs($admin, 'admin')->get('/admin/attendance/' . $attendance->id)->assertStatus(200);

        $response->assertSee($name);
        $response->assertSee($date);
        $response->assertSee($start);
        $response->assertSee($end);
        $response->assertSee($restStart);
        $response->assertSee($restEnd);
    }
}
