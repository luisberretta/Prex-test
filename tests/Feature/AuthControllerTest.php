<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthControllerTest extends TestCase {
    /**
     * @test.
     */
    public function test_user_can_login_with_correct_credentials(): void {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);
        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200);

        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_credentials(): void {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);

        $this->assertGuest();
    }
}
