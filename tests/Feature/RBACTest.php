<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RBACTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_admin_can_create_sites()
    {
        $admin = User::factory()->create();
        $admin->roles()->attach(1); // Attach admin role

        $response = $this->actingAs($admin)->postJson('/api/v1/sites', [
            'name' => 'Test Site',
            'address' => '123 Test Street',
        ]);

        $response->assertStatus(201);
    }

    public function test_staff_cannot_create_sites()
    {
        $staff = User::factory()->create();
        $staff->roles()->attach(2); // Attach staff role

        $response = $this->actingAs($staff)->postJson('/api/v1/sites', [
            'name' => 'Test Site',
            'address' => '123 Test Street',
        ]);

        $response->assertStatus(403);
    }

    public function test_unauthenticated_cannot_access_protected_routes()
    {
        $response = $this->getJson('/api/v1/sites');
        $response->assertStatus(401);
    }
}

