<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function registered_email_can_request_password_reset()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com'
        ]);

        $response = $this->post('/forgot-password', [
            'email' => 'test@example.com'
        ]);

        $response->assertStatus(302);
    }

    /** @test */
    public function unregistered_email_cannot_request_password_reset()
    {
        $response = $this->post('/forgot-password', [
            'email' => 'unknown@example.com'
        ]);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function correct_otp_resets_password()
    {
        $user = User::factory()->create([
            'otp' => '123456'
        ]);

        $response = $this->post('/reset-password', [
            'email' => $user->email,
            'otp' => '123456',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ]);

        $response->assertStatus(302);
    }

    /** @test */
    public function wrong_reset_otp_is_rejected()
    {
        $user = User::factory()->create([
            'otp' => '123456'
        ]);

        $response = $this->post('/reset-password', [
            'email' => $user->email,
            'otp' => '999999',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123'
        ]);

        $response->assertSessionHasErrors();
    }
}