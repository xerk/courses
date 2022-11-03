<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Lead;

use App\Models\Category;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LeadControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_leads()
    {
        $leads = Lead::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('leads.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.leads.index')
            ->assertViewHas('leads');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_lead()
    {
        $response = $this->get(route('leads.create'));

        $response->assertOk()->assertViewIs('app.leads.create');
    }

    /**
     * @test
     */
    public function it_stores_the_lead()
    {
        $data = Lead::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('leads.store'), $data);

        $this->assertDatabaseHas('leads', $data);

        $lead = Lead::latest('id')->first();

        $response->assertRedirect(route('leads.edit', $lead));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_lead()
    {
        $lead = Lead::factory()->create();

        $response = $this->get(route('leads.show', $lead));

        $response
            ->assertOk()
            ->assertViewIs('app.leads.show')
            ->assertViewHas('lead');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_lead()
    {
        $lead = Lead::factory()->create();

        $response = $this->get(route('leads.edit', $lead));

        $response
            ->assertOk()
            ->assertViewIs('app.leads.edit')
            ->assertViewHas('lead');
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

        $response = $this->put(route('leads.update', $lead), $data);

        $data['id'] = $lead->id;

        $this->assertDatabaseHas('leads', $data);

        $response->assertRedirect(route('leads.edit', $lead));
    }

    /**
     * @test
     */
    public function it_deletes_the_lead()
    {
        $lead = Lead::factory()->create();

        $response = $this->delete(route('leads.destroy', $lead));

        $response->assertRedirect(route('leads.index'));

        $this->assertModelMissing($lead);
    }
}
