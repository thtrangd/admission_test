<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Application;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_application() {
        $response = $this->postJson('/api/applications', [
            'applicant_name' => 'John Doe',
            'programme' => 'CS',
            'intake' => 'Fall 2025',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('applications', ['applicant_name' => 'John Doe']);
    }

    public function test_can_update_application() {
        $app = Application::factory()->create();

        $response = $this->putJson("/api/applications/{$app->id}", [
            'status' => 'Accepted',
            'payment_status' => 'paid',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('applications', ['status' => 'Accepted', 'payment_status' => 'paid']);
    }
}
