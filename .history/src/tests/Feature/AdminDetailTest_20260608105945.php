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
        $year = Carbon::parse($attendance->date)->isoFormat('YYYY年');
        $day = Carbon::parse($attendance->date)->isoFormat('MM月DD日');
        $start = Carbon::parse($attendance->start_time)->format('H:i');
        $end = Carbon::parse($attendance->end_time)->format('H:i');
        foreach($attendance->breaks as $break){
            $restStart = Carbon::parse($break->rest_start)->format('H:i');
            $restEnd = Carbon::parse($break->rest_end)->format('H:i');
        }

        $response = $this->actingAs($admin, 'admin')->get('/admin/attendance/' . $attendance->id)->assertStatus(200);

        $response->assertSee($name);
        $response->assertSee($year);
        $response->assertSee($day);
        $response->assertSee($start);
        $response->assertSee($end);
        $response->assertSee($restStart);
        $response->assertSee($restEnd);
    }

    public function test_start_time_before()
    {
        $admin = Admin::find(1);
        $attendance =AttendanceRecord::find(1);

        $response = $this->actingAs($admin, 'admin')->get('/admin/attendance/' . $attendance->id)->assertStatus(200);
        $response = $this->from('/admin/attendance/request/' . $attendance->id)
                    ->post('/admin/attendance/request/' . $attendance->id, [
                        'start_time' => '18:00',
                        'end_time' => '17:00',
                        'breaks' => [
                            [
                                'rest_start' => '12:00',
                                'rest_end' => '13:00',
                            ]
                        ],
                        'content' => 'サンプル'
                    ]);
        
        $response->assertSessionHasErrors([
            'start_time' => '出勤時間もしくは退勤時間が不適切な値です',
        ]);
    }

    public function test_rest_start_before()
    {
        $admin = Admin::find(1);
        $attendance =AttendanceRecord::find(1);

        $response = $this->actingAs($admin, 'admin')->get('/admin/attendance/' . $attendance->id)->assertStatus(200);
        $response = $this->from('/admin/attendance/request/' . $attendance->id)
                    ->post('/admin/attendance/request/' . $attendance->id, [
                        'start_time' => '9:00',
                        'end_time' => '17:00',
                        'breaks' => [
                            [
                                'rest_start' => '18:00',
                                'rest_end' => '13:00',
                            ]
                        ],
                        'content' => 'サンプル'
                    ]);
        
        $response->assertSessionHasErrors([
            'breaks.0.rest_start' => '休憩時間が不適切な値です',
        ]);
    }

    public function test_rest_end_before()
    {
        $admin = Admin::find(1);
        $attendance =AttendanceRecord::find(1);

        $response = $this->actingAs($admin, 'admin')->get('/admin/attendance/' . $attendance->id)->assertStatus(200);
        $response = $this->from('/admin/attendance/request/' . $attendance->id)
                    ->post('/admin/attendance/request/' . $attendance->id, [
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
        
        $response->assertSessionHasErrors([
            'breaks.0.rest_end' => '休憩時間もしくは退勤時間が不適切な値です',
        ]);
    }

    public function test_content()
    {
        $admin = Admin::find(1);
        $attendance =AttendanceRecord::find(1);

        $response = $this->actingAs($admin, 'admin')->get('/admin/attendance/' . $attendance->id)->assertStatus(200);
        $response = $this->from('/admin/attendance/request/' . $attendance->id)
                    ->post('/admin/attendance/request/' . $attendance->id, [
                        'start_time' => '9:00',
                        'end_time' => '17:00',
                        'breaks' => [
                            [
                                'rest_start' => '12:00',
                                'rest_end' => '13:00',
                            ]
                        ],
                        'content' => ''
                    ]);
        
        $response->assertSessionHasErrors([
            'content' => '備考を記入してください',
        ]);
    }
}
