<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Company;
use App\Models\Trainer;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTrainersTest extends TestCase
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
    public function it_gets_company_trainers()
    {
        $company = Company::factory()->create();
        $trainers = Trainer::factory()
            ->count(2)
            ->create([
                'company_id' => $company->id,
            ]);

        $response = $this->getJson(
            route('api.companies.trainers.index', $company)
        );

        $response->assertOk()->assertSee($trainers[0]->occupation);
    }

    /**
     * @test
     */
    public function it_stores_the_company_trainers()
    {
        $company = Company::factory()->create();
        $data = Trainer::factory()
            ->make([
                'company_id' => $company->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.companies.trainers.store', $company),
            $data
        );

        unset($data['user_id']);
        unset($data['company']);
        unset($data['company_id']);
        unset($data['occupation']);
        unset($data['work_place']);
        unset($data['sufer_diseases']);
        unset($data['diseases_note']);
        unset($data['job_title']);
        unset($data['note']);

        $this->assertDatabaseHas('trainers', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $trainer = Trainer::latest('id')->first();

        $this->assertEquals($company->id, $trainer->company_id);
    }
}
