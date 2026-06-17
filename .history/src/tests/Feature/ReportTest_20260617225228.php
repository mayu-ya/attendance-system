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

class ReportTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_report_redirect()
    {
        $response = $this->get('/attendance/report')->assertStatus(302);

        $response->assertRedirect('/login');
    }

    public function test_report()
    {
        $user = User::find(1);
        $user->update(['email_verified_at' => now(),]);
        dd($user);

        AttendanceRecord::create([
            'user_id' => $user->id,
            'date' => Carbon::now()->subDay()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
            'end_time' => '18:00',
            'work_total' => '8:00',
            'duration' => '1:00',
        ]);
        $attendance = AttendanceRecord::create([
            'user_id' => $user->id,
            'date' => Carbon::now()->isoFormat('YYYY/MM/DD/'),
            'start_time' => '9:00',
            'end_time' => '17:00',
            'work_total' => '7:00',
            'duration' => '1:00',
        ]);
        $response = $this->actingAs($user)->from('/attendance')->post('/working/end', [
            'attendance_record_id' => $attendance->id,
        ]);

        $response = $this->actingAs($user)->get('/attendance/report')->assertStatus(200);
        //$response->assertSee();
    }

    public function test_report_user()
    {
        $user = User::find(3);
        $user->create(['email_verified_at' => now(),]);

        $response = $this->actingAs($user)->get('/attendance/report')->assertStatus(200);
        $response->assertSee('0h0m');
    }
}
