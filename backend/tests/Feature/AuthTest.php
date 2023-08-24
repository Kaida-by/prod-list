<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function testRegistration(): void
    {
        $data = [
            'name' => 'test',
            'phone' => '375001234567',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response = $this->postJson('api/auth/register', $data);

        $response->assertStatus(200);
    }

    public function testLogin(): void
    {
        User::factory()->create([
            'phone' => '375001234567',
            'password' => bcrypt('password'),
        ]);

        $credentials = [
            'phone' => '375001234567',
            'password' => 'password',
        ];

        $response = $this->postJson('api/auth/login', $credentials);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'token',
            ]);
    }

    public function testLogout(): void
    {
        User::factory()->create([
            'phone' => '375001234567',
            'password' => bcrypt('password'),
        ]);

        $credentials = [
            'phone' => '375001234567',
            'password' => 'password',
        ];

        $token = $this->postJson('api/auth/login', $credentials)['token'];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/auth/logout');

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Successfully logged out'
            ]);
        $this->assertFalse(Auth::check());
    }
}
