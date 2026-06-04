<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_name()
    {
        $response = $this->get('/register')->assertStatus(200);
        $response = $this->from('/register', [
            'name' => "",
            'email'=> "test@example.com",
            'password' => "password",
            'password_confirmation' => "password",
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/register');

        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください',
        ]);
    }
}
