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

    public function test_example()
    {
        $admin = Admin::find(1);
        $applies = Apply::with('rests')->where('status', 'pending')->get();

        $response = $this->actingAs($admin, 'admin')->get('/')->assertStatus(200);

        $response->assertStatus(200);
    }
}
