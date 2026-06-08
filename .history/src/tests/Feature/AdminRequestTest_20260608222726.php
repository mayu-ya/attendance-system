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

class AdminRequestTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_apply_pending()
    {
        $admin = Admin::find(1);
        $applies = Apply::where('status', 'pending')->get();

        foreach($applies as $apply){
            $name = $apply->user->name;
            $apply->date = Carbon::parse($apply->date)->format('Y/m/d');
            $apply->updated_at_formatted = Carbon::parse($apply->updated_at)->format('Y/m/d');
            $content = $apply->content;
        }

        $response = $this->actingAs($admin, 'admin')->from('/stamp_correction_request/list')
                    ->post('/stamp_correction_request/list', [
                        'action' => 'wait',
                    ]);

        $response->assertSee('承認待ち');
        $response->assertSee($name);
        $response->assertSee($apply->date);
        $response->assertSee($apply->updated_at_formatted);
        $response->assertSee($content);
    }

    public function test_apply_approved()
    {
        $admin = Admin::find(1);
        $applies = Apply::where('status', 'approved')->get();

        foreach($applies as $apply){
            $name = $apply->user->name;
            $apply->date = Carbon::parse($apply->date)->format('Y/m/d');
            $apply->updated_at_formatted = Carbon::parse($apply->updated_at)->format('Y/m/d');
            $content = $apply->content;
        }

        $response = $this->actingAs($admin, 'admin')->from('/stamp_correction_request/list')
                    ->post('/stamp_correction_request/list', [
                        'action' => 'apply',
                    ]);

        $response->assertSee('承認済み');
        $response->assertSee($name);
        $response->assertSee($apply->date);
        $response->assertSee($apply->updated_at_formatted);
        $response->assertSee($content);
    }

    public function test_apply_detail()
    {
        $admin = Admin::find(1);
        $apply = Apply::with('rests')->find(1);

        $name = $apply->user->name;
        $year = Carbon::parse($apply->date)->isoFormat('YYYY年');
        $day = Carbon::parse($apply->date)->isoFormat('MM月DD日');
        $start = Carbon::parse($apply->start_time)->format('H:i');
        $end = Carbon::parse($apply->end_time)->format('H:i');
        foreach($apply->rests as $rest){
            $restStart = Carbon::parse($rest->rest_start)->format('H:i');
            $restEnd = Carbon::parse($rest->rest_start)->format('H:i');
        }
        $content = $apply->content;

        $response = $this->actingAs($admin, 'admin')->get('/stamp_correction_request/list/approve/' . $apply->id)->assertStatus(200);

        $response->assertSee($name);
        $response->assertSee($year);
        $response->assertSee($day);
        $response->assertSee($start);
        $response->assertSee($end);
        $response->assertSee($restStart);
        $response->assertSee($restEnd);
        $response->assertSee($content);
    }

    public function test_apply()
    {
        $admin = Admin::find(1);
        $apply = Apply::with('rests')->find(2);

        $name = $apply->user->name;
        $apply->date = Carbon::parse($apply->date)->format('Y/m/d');
        $apply->updated_at_formatted = Carbon::parse($apply->updated_at)->format('Y/m/d');
        $content = $apply->content;

        $response = $this->actingAs($admin, 'admin')->get('/stamp_correction_request/list/approve/' . $apply->id)->assertStatus(200);

        $response = $this->form('/stamp_correction_request/list/approve')
                    ->post('/stamp_correction_request/list/approve', [
                        'id' => $apply->id,
        ]);

        $response = $this->from('/stamp_correction_request/list')
                    ->post('/stamp_correction_request/list', [
                        'action' => 'apply',
                    ]);

        $response->assertSee('承認済み');
        $response->assertSee($name);
        $response->assertSee($apply->date);
        $response->assertSee($apply->updated_at_formatted);
        $response->assertSee($content);
    }
}
