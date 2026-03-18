<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_access_dashboard()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function donor_cannot_access_admin_hospitals_page()
    {
        $donor = User::factory()->create([
            'role' => 'donor',
        ]);

        $this->actingAs($donor);

        $response = $this->get('/hospitals');

        $response->assertStatus(403);
    }

    /** @test */
    public function hospital_cannot_access_admin_hospitals_page()
    {
        $hospitalUser = User::factory()->create([
            'role' => 'hospital',
        ]);

        $this->actingAs($hospitalUser);

        $response = $this->get('/hospitals');

        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_access_admin_hospitals_page()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $response = $this->get('/hospitals');

        $response->assertStatus(200);
    }
}