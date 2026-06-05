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

        $response->assertNotSee('出勤');
        $response->assertSee('お疲れ様でした。');
    }
}
