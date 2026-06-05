<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Database\Seeders\DatabaseSeeder;
use App\Models\User;
use \Carbon\Carbon;

class StatusTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_example()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->get('/attendance')->assertStatus(200);

        $day = Carbon::now()->isoFormat('YYYY年MM月DD日（ddd）');
        $time = Carbon::now()->format('H:i');

        $response->assertSee($day);
        $response->assertSee($time);
    }
}
