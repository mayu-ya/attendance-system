<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Database\Seeders\DatabaseSeeder;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_email()
    {
        $response = $this->get('/login')->assertStatus(200);
        $response = $this->from('/login')->post('/login', [
            'email'=> "",
            'password' => "password",
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/login');

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }

    public function test_password()
    {
        $response = $this->get('/login')->assertStatus(200);
        $response = $this->from('/login')->post('/login', [
            'email'=> "user1@example.com",
            'password' => "",
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/login');

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
    }

    public function test_example()
    {
        $response = $this->get('/login')->assertStatus(200);
        $response = $this->from('/login')->post('/login', [
            'email'=> "user1@example.com",
            'password' => "pass",
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/login');

        $response->assertSessionHasErrors([
            'password' => 'ログイン情報が登録されていません',
        ]);
    }
}
