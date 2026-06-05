<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Database\Seeders\DatabaseSeeder;

class AdminLoginTest extends TestCase
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
        $response = $this->get('/admin/login')->assertStatus(200);
        $response = $this->from('/admin/login')->post('/admin/login', [
            'email'=> "",
            'password' => "password",
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }

    public function test_password()
    {
        $response = $this->get('/admin/login')->assertStatus(200);
        $response = $this->from('/admin/login')->post('/admin/login', [
            'email'=> "user1@example.com",
            'password' => "",
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
    }

    public function test_example()
    {
        $response = $this->get('/admin/login')->assertStatus(200);
        $response = $this->from('/admin/login')->post('/admin/login', [
            'email'=> "user1@example.com",
            'password' => "pass",
        ]);
        $response->dumpSession();
        $response->dump(); 

        $response->assertStatus(302);
        $response->assertRedirect('/admin/login');

        $response->assertSessionHasErrors([
            'email' => 'ログイン情報が登録されていません',
        ]);
    }
}
