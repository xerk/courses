<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'email' => 'admin@admin.com',
                'password' => \Hash::make('admin'),
            ]);

        $this->call(AssigmentSeeder::class);
        $this->call(AssigmentAnswerSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(CompanyLeadSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(CourseGroupSeeder::class);
        $this->call(DocumentSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(FollowUpSeeder::class);
        $this->call(LeadSeeder::class);
        $this->call(TrainerSeeder::class);
        $this->call(UserSeeder::class);
    }
}
