<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Course;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserCoursesTest extends TestCase
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
    public function it_gets_user_courses()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $user->courses()->attach($course);

        $response = $this->getJson(route('api.users.courses.index', $user));

        $response->assertOk()->assertSee($course->title);
    }

    /**
     * @test
     */
    public function it_can_attach_courses_to_user()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $response = $this->postJson(
            route('api.users.courses.store', [$user, $course])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $user
                ->courses()
                ->where('courses.id', $course->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_courses_from_user()
    {
        $user = User::factory()->create();
        $course = Course::factory()->create();

        $response = $this->deleteJson(
            route('api.users.courses.store', [$user, $course])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $user
                ->courses()
                ->where('courses.id', $course->id)
                ->exists()
        );
    }
}
