<?php

namespace Database\Seeders;

use App\Models\FollowUp;
use Illuminate\Database\Seeder;

class FollowUpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FollowUp::factory()
            ->count(5)
            ->create();
    }
}
