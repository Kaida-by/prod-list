<?php

namespace Tests;

use App\Models\User;
use Illuminate\Testing\TestResponse;

trait HelperForTests
{
    public function getAuthUser(): TestResponse
    {
        User::factory()->create([
            'phone' => '375001234567',
            'password' => bcrypt('password'),
        ]);

        $credentials = [
            'phone' => '375001234567',
            'password' => 'password',
        ];

        return $this->postJson('api/auth/login', $credentials);
    }
}
