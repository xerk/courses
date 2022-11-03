<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Course;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseUsersTest extends TestCase
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
    public function it_gets_course_users()
    {
        $course = Course::factory()->create();
        $user = User::factory()->create();

        $course->users()->attach($user);

        $response = $this->getJson(route('api.courses.users.index', $course));

        $response->assertOk()->assertSee($user->name);
    }

    /**
     * @test
     */
    public function it_can_attach_users_to_course()
    {
        $course = Course::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson(
            route('api.courses.users.store', [$course, $user])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $course
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_users_from_course()
    {
        $course = Course::factory()->create();
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route('api.courses.users.store', [$course, $user])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $course
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }
}
