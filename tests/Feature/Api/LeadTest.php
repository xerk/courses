<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Lead;

use App\Models\Category;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeadTest extends TestCase
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
    public function it_gets_leads_list()
    {
        $leads = Lead::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.leads.index'));

        $response->assertOk()->assertSee($leads[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_lead()
    {
        $data = Lead::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.leads.store'), $data);

        $this->assertDatabaseHas('leads', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_lead()
    {
        $lead = Lead::factory()->create();

        $category = Category::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'name_ar' => $this->faker->text(255),
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'category_approved' => $this->faker->text(255),
            'course_type' => 'medical',
            'lead_from' => 'website',
            'status' => $this->faker->word,
            'business_landline' => $this->faker->text(255),
            'note' => $this->faker->text,
            'category_id' => $category->id,
        ];

        $response = $this->putJson(route('api.leads.update', $lead), $data);

        $data['id'] = $lead->id;

        $this->assertDatabaseHas('leads', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_lead()
    {
        $lead = Lead::factory()->create();

        $response = $this->deleteJson(route('api.leads.destroy', $lead));

        $this->assertModelMissing($lead);

        $response->assertNoContent();
    }
}
