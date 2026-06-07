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

class RequestTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_start_time_before()
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
        $response = $this->from('/attendance/request/' . $attendance->id)
                    ->post('/attendance/request/' . $attendance->id, [
                        'start_time' => '17:30',
                    ]);

        $response->assertStatus(302);
        $response->assertRedirect('/attendance/request/' . $attendance->id);

        $response->assertSessionHasErrors([
            'start_time' => '出勤時間もしくは退勤時間が不適切な値です',
        ]);
    }

    public function test_rest_start_after()
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
            'rest_total' =>60,
        ]);

        $response = $this->actingAs($user)->get('/attendance/detail/' . $attendance->id)->assertStatus(200);
        $response = $this->from('/attendance/request/' . $attendance->id)
                    ->post('/attendance/request/' . $attendance->id, [
                        'start_time' => '9:00',
                        'end_time' => '17:00',
                        'breaks' => [
                            [
                                'rest_start' => '17:30',
                                'rest_end' => '13:00',
                            ]
                        ],
                        'content' => 'サンプル'
                    ]);

        $response->assertStatus(302);
        $response->assertRedirect('/attendance/request/' . $attendance->id);

        $response->assertSessionHasErrors([
            'breaks.0.rest_start' => '休憩時間が不適切な値です',
        ]);
    }

    public function test_rest_end_before()
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
            'rest_total' =>60,
        ]);

        $response = $this->actingAs($user)->get('/attendance/detail/' . $attendance->id)->assertStatus(200);
        $response = $this->from('/attendance/request/' . $attendance->id)
                    ->post('/attendance/request/' . $attendance->id, [
                        'start_time' => '9:00',
                        'end_time' => '17:00',
                        'breaks' => [
                            [
                                'rest_start' => '12:00',
                                'rest_end' => '18:00',
                            ]
                        ],
                        'content' => 'サンプル'
                    ]);

        $response->assertStatus(302);
        $response->assertRedirect('/attendance/request/' . $attendance->id);

        $response->assertSessionHasErrors([
            'breaks.0.rest_end' => '休憩時間もしくは退勤時間が不適切な値です',
        ]);
    }

    public function test_content()
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
        $response = $this->from('/attendance/request/' . $attendance->id)
                    ->post('/attendance/request/' . $attendance->id, [
                        'start_time' => '9:00',
                        'end_time' => '17:00',
                        'content' => ''
                    ]);

        $response->assertStatus(302);
        $response->assertRedirect('/attendance/request/' . $attendance->id);

        $response->assertSessionHasErrors([
            'content' => '備考を記入してください',
        ]);
    }

    public function test_rest_end_before()
    {
        $user = User::find(1);
        $admin = Admin::find(1);
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
            'rest_total' =>60,
        ]);

        $response = $this->actingAs($user)->get('/attendance/detail/' . $attendance->id)->assertStatus(200);
        $response = $this->from('/attendance/request/' . $attendance->id)
                    ->post('/attendance/request/' . $attendance->id, [
                        'start_time' => '9:00',
                        'end_time' => '17:00',
                        'breaks' => [
                            [
                                'rest_start' => '12:00',
                                'rest_end' => '13:10',
                            ]
                        ],
                        'content' => 'サンプル'
                    ]);

        $apply = Apply::with('rests')->where('attendance_record_id', $attendance->id)->first();
        $ = Carbon
        $response = $this->actingAs($admin)->form('/stamp_correction_request/list/admin')
                    ->post('/stamp_correction_request/list/admin', ['action' => 'wait'])->assertStatus(200);

        $response = $this->actingAs($admin)->get('/stamp_correction_request/list/approve/' . $apply->id)->assertStatus(200);
    }
}
