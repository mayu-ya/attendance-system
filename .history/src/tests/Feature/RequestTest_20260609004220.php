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
use App\Models\Apply;
use App\Models\Rest;
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
        $attendance = AttendanceRecord::find(10);

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
        $attendance = AttendanceRecord::with('breaks')->find(10);

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
        $attendance = AttendanceRecord::with('breaks')->find(10);

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
        $attendance = AttendanceRecord::with('breaks')->find(10);

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

    public function test_rest()
    {
        $user = User::find(2);
        $admin = Admin::find(1);
        $attendance = AttendanceRecord::with('breaks')->find(10);

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
        $name = $apply->user->name;
        $apply->date = Carbon::parse($apply->date)->format('Y/m/d');
        $apply->updated_at_formatted = Carbon::parse($apply->updated_at)->format('Y/m/d');
        $content = $apply->content;

        $year = Carbon::parse($apply->date)->isoFormat('YYYY年');
        $day = Carbon::parse($apply->date)->isoFormat('M月D日');
        $start = Carbon::parse($apply->start_time)->format('H:i');
        $end = Carbon::parse($apply->end_time)->format('H:i');
        foreach($apply->rests as $rest){
            $restStart = Carbon::parse($rest->rest_start)->format('H:i');
            $restEnd = Carbon::parse($rest->rest_start)->format('H:i');
        }

        $response = $this->actingAs($admin, 'admin')->from('/stamp_correction_request/list')
                    ->post('/stamp_correction_request/list', ['action' => 'wait'])->assertStatus(200);
        $response->assertSee('承認待ち');
        $response->assertSee($name);
        $response->assertSee($apply->date);
        $response->assertSee($apply->updated_at_formatted);
        $response->assertSee($content);

        $response = $this->get('/stamp_correction_request/list/approve/' . $apply->id)->assertStatus(200);
        $response->assertSee($name);
        $response->assertSee($year);
        $response->assertSee($day);
        $response->assertSee($start);
        $response->assertSee($end);
        $response->assertSee($restStart);
        $response->assertSee($restEnd);
        $response->assertSee($content);
    }

    public function test_apply_wait_show()
    {
        $user = User::find(2);
        $attendance = Attendance::with('breaks')->find(10);

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
        $name = $apply->user->name;
        $apply->date = Carbon::parse($apply->date)->format('Y/m/d');
        $apply->updated_at_formatted = Carbon::parse($apply->updated_at)->format('Y/m/d');
        $content = $apply->content;

        $response = $this->from('/stamp_correction_request/list')
                    ->post('/stamp_correction_request/list', ['action'=>'wait']);
        $response->assertSee($name);
        $response->assertSee($apply->date);
        $response->assertSee($apply->updated_at_formatted);
        $response->assertSee($content);
    }

    public function test_apply_show()
    {
        $user = User::find(1);
        $admin = Admin::find(1);
        $attendance = Attendance::with('breaks')->find(1);

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

        $response = $this->from('/stamp_correction_request/list')
                    ->post('/stamp_correction_request/list', ['action'=>'apply']);

        $response = $this->actingAs($admin, 'admin')->get('/stamp_correction_request/list/approve/' . $apply->id)->assertStatus(200);

        $response = $this->from('/stamp_correction_request/list/approve')
                    ->post('/stamp_correction_request/list/approve', [
                        'id' => $apply->id,
        ]);

        $apply = Apply::with('rests')->where('attendance_record_id', $attendance->id)->first();
        $name = $apply->user->name;
        $apply->date = Carbon::parse($apply->date)->format('Y/m/d');
        $apply->updated_at_formatted = Carbon::parse($apply->updated_at)->format('Y/m/d');
        $content = $apply->content;

        $response = $this->actingAs($user)->from('/stamp_correction_request/list')
                    ->post('/stamp_correction_request/list', ['action'=>'apply']);

        $response->assertSee($name);
        $response->assertSee($apply->date);
        $response->assertSee($apply->updated_at_formatted);
        $response->assertSee($content);
    }

    public function test_detail()
    {
        $user = User::find(1);
        $attendance = Attendance::with('breaks')->find(1);

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

        $response = $this->from('/stamp_correction_request/list')
                    ->post('/stamp_correction_request/list', ['action'=>'wait']);
        $apply = Apply::with('rests')->where('attendance_record_id', $attendance->id)->first();

        $response = $this->get('/attendance/detail/' . $apply->id)->assertStatus(200);
    }
}
