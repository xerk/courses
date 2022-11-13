<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AssigmentAnswer;

class AssigmentAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AssigmentAnswer::factory()
            ->count(5)
            ->create();
    }
}
