<?php

namespace Database\Seeders;

use App\Models\CourseGroup;
use Illuminate\Database\Seeder;

class CourseGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CourseGroup::factory()
            ->count(5)
            ->create();
    }
}
