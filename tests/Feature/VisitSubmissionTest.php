<?php

namespace Tests\Feature;

use App\Jobs\ProcessVisitSubmission;
use App\Models\User;
use App\Models\Visit;
use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class VisitSubmissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_staff_can_create_visit()
    {
        $staff = User::factory()->create();
        $staff->roles()->attach(2); // Attach staff role
        
        $site = Site::factory()->create();

        $response = $this->actingAs($staff)->postJson('/api/v1/visits', [
            'site_id' => $site->id,
            'visited_at' => now()->format('Y-m-d H:i:s'),
            'notes' => 'Test visit',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('visits', ['user_id' => $staff->id, 'status' => 'draft']);
    }

    public function test_staff_can_submit_visit()
    {
        Queue::fake();

        $staff = User::factory()->create();
        $staff->roles()->attach(2); // Attach staff role
        
        $visit = Visit::factory()->create(['user_id' => $staff->id, 'status' => 'draft']);

        $response = $this->actingAs($staff)->postJson("/api/v1/visits/{$visit->id}/submit");

        $response->assertStatus(200);
        Queue::assertPushed(ProcessVisitSubmission::class);
        $this->assertDatabaseHas('visits', ['id' => $visit->id, 'status' => 'submitted']);
    }

    public function test_idempotency_of_submission()
    {
        $staff = User::factory()->create();
        $staff->roles()->attach(2); // Attach staff role
        
        $visit = Visit::factory()->create(['user_id' => $staff->id, 'status' => 'submitted']);

        $response = $this->actingAs($staff)->postJson("/api/v1/visits/{$visit->id}/submit");

        $response->assertStatus(400);
        $this->assertEquals('submitted', $visit->fresh()->status);
    }

    public function test_staff_cannot_submit_other_users_visit()
    {
        $staff1 = User::factory()->create();
        $staff1->roles()->attach(2);
        
        $staff2 = User::factory()->create();
        $staff2->roles()->attach(2);
        
        $visit = Visit::factory()->create(['user_id' => $staff1->id, 'status' => 'draft']);

        $response = $this->actingAs($staff2)->postJson("/api/v1/visits/{$visit->id}/submit");

        $response->assertStatus(403);
    }
}