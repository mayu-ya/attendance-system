<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
//use App\Http\Models\User;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_name()
    {
        $response = $this->get('/register')->assertStatus(200);
        $response = $this->from('/register')->post('/register', [
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

    public function test_email()
    {
        $response = $this->get('/register')->assertStatus(200);
        $test = $this->from('/register')->post('/register', [
            'name' => "テスト太郎",
            'email'=> "",
            'password' => "password",
            'password_confirmation' => "password",
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/register');

        $response->assertSessionHasErrors([
            'name' => 'メールアドレスを入力してください',
        ]);
    }

    public function test_password_max()
    {
        $response = $this->get('/register')->assertStatus(200);
        $response = $this->from('/register')->post('/register', [
            'name' => "テスト太郎",
            'email'=> "test@example.com",
            'password' => "pass",
            'password_confirmation' => "pass",
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/register');

        $response->assertSessionHasErrors([
            'name' => 'パスワードを8文字以上で入力してください',
        ]);
    }

    public function test_password_confirmation()
    {
        $response = $this->get('/register')->assertStatus(200);
        $response = $this->from('/register')->post('/register', [
            'name' => "テスト太郎",
            'email'=> "test@example.com",
            'password' => "password",
            'password_confirmation' => "pass",
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/register');

        $response->assertSessionHasErrors([
            'name' => 'パスワードと一致しません',
        ]);
    }

    public function test_password()
    {
        $response = $this->get('/register')->assertStatus(200);
        $response = $this->from('/register')->post('/register', [
            'name' => "テスト太郎",
            'email'=> "test@example.com",
            'password' => "",
            'password_confirmation' => "password",
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/register');

        $response->assertSessionHasErrors([
            dd($response->getSession()->get('errors')->getBag('default')->getMessages());
            'name' => 'パスワードを入力してください',
        ]);
    }

    public function test_register()
    {
        $response = $this->get('/register')->assertStatus(200);
        $response = $this->from('/register')->post('/register', [
            'name' => "テスト太郎",
            'email'=> "test@example.com",
            'password' => "password",
            'password_confirmation' => "password",
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/attendance');

        $this->assertDatabaseHas('users', [
            'name' => 'テスト太郎',
            'email'=> "test@example.com",
        ]);

        $user = \App\Models\User::find(1)->first();
        $this->assertTrue(\Hash::check('password', $user->password));
    }
}
