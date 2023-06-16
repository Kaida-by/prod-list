<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_user_register(): void
    {
        $payloads = [
            'name' => 'Denis',
            'phone' => '375291481184',
            'password' => '241124112411',
            'password_confirmation' => '241124112411'
        ];

        $response = $this->post('api/auth/register', $payloads);
        dd($response);
        $response->assertStatus(200);
    }
}
