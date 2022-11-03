<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lead;
use App\Models\FollowUp;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeadFollowUpsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_lead_follow_ups()
    {
        $lead = Lead::factory()->create();
        $followUps = FollowUp::factory()
            ->count(2)
            ->create([
                'lead_id' => $lead->id,
            ]);

        $response = $this->getJson(route('api.leads.follow-ups.index', $lead));

        $response->assertOk()->assertSee($followUps[0]->title);
    }

    /**
     * @test
     */
    public function it_stores_the_lead_follow_ups()
    {
        $lead = Lead::factory()->create();
        $data = FollowUp::factory()
            ->make([
                'lead_id' => $lead->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.leads.follow-ups.store', $lead),
            $data
        );

        unset($data['lead_id']);

        $this->assertDatabaseHas('follow_ups', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $followUp = FollowUp::latest('id')->first();

        $this->assertEquals($lead->id, $followUp->lead_id);
    }
}
