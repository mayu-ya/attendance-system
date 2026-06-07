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

class AttendanceTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_time_list_show()
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

        $response = $this->actingAs($user)->get('/attendance/list')->assertStatus(200);

        $start = Carbon::parse($attendance->start_time)->format('H:i');
        $end = Carbon::parse($attendance->end_time)->format('H:i');
        $workTotal = Carbon::parse($attendance->work_total)->format('H:i');
        $duration = Carbon::parse($attendance->duration)->format('H:i');

        $response->assertSee($start);
        $response->assertSee($end);
        $response->assertSee($workTotal);
        $response->assertSee($duration);
    }

    public function test_month()
    {
        $user = User::find(1);
        $thisMonth = Carbon::today()->format('Y/m');

        $response = $this->actingAs($user)->get('/attendance/list')->assertStatus(200);

        $response->assertSee($thisMonth);
    }

    

    public function test_detail()
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

        $response = $this->actingAs($user)->get('/attendance/list')->assertStatus(200);
        $response = $this->get('/attendance/detail/' . $attendance->id);

        $year = Carbon::parse($attendance->date)->isoFormat('YYYY年');
        $day = Carbon::parse($attendance->date)->isoFormat('MM月DD日');

        $response->assertSee($year);
        $response->assertSee($day);
    }
}
public function test_sub_month()
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

        $response = $this->actingAs($user)->get('/attendance/list')->assertStatus(200);

        $year = Carbon::today()->format('Y');
        $month = Carbon::today()->format('m');
        $dayYm = Carbon::create($year, $month)->subMonth()->format('Y/m');

        $response = $this->from('/attendance/list')->followingRedirects()->post('/attendance/list', [
            'year' => $year,
            'month' => $month,
            'action' => 'sub',
        ]);

        $response->assertSee($dayYm);
    }

    public function test_add_month()
    {
        $user = User::find(1);
        $attendance = AttendanceRecord::create([
            'user_id' => $user->id,
            'date' => Carbon::now()->subMonth()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
            'end_time' => '17:00',
            'work_total' => '7:00',
            'duration' => '1:00',
        ]);

        $response = $this->actingAs($user)->get('/attendance/list')->assertStatus(200);

        $year = Carbon::today()->format('Y');
        $month = Carbon::today()->format('m');
        $dayYm = Carbon::create($year, $month)->addMonth()->format('Y/m');

        $response = $this->from('/attendance/list')->followingRedirects()->post('/attendance/list', [
            'year' => $year,
            'month' => $month,
            'action' => 'add',
        ]);

        $response->assertSee($dayYm);
    }