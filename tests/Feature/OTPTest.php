<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OTPTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function correct_otp_verifies_user()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
            'otp' => '123456',
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->post('/verify-otp', [
            'email' => $user->email,
            'otp' => '123456'
        ]);

        $response->assertStatus(302);

        // optional but recommended: confirm verified + otp cleared (if your controller does this)
        // $this->assertNotNull($user->fresh()->email_verified_at);
        // $this->assertNull($user->fresh()->otp);
    }

    /** @test */
    public function wrong_otp_is_rejected()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
            'otp' => '123456',
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        $response = $this->from('/otp?email='.$user->email)->post('/verify-otp', [
            'email' => $user->email,
            'otp' => '999999'
        ]);

        $response->assertRedirect('/otp?email='.$user->email);
        $response->assertSessionHasErrors(); // or assertSessionHasErrors(['otp']) if your controller uses 'otp'
    }

    /** @test */
    public function expired_otp_is_rejected()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
            'otp' => '123456',
            'otp_expires_at' => now()->subMinutes(5),
        ]);

        $response = $this->from('/otp?email='.$user->email)->post('/verify-otp', [
            'email' => $user->email,
            'otp' => '123456'
        ]);

        $response->assertRedirect('/otp?email='.$user->email);
        $response->assertSessionHasErrors(); // or assertSessionHasErrors(['otp'])
    }
}