<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_name()
    {
        //dd(app('router')->getRoutes()->hasNamedRoute('register'));

        //$this->get('/register')->dump();
        //dd(collect(app('router')->getRoutes())->map(fn($r) => $r->uri())->toArray());

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
    
}
