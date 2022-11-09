<?php

namespace Database\Seeders;

use App\Models\Assigment;
use Illuminate\Database\Seeder;

class AssigmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Assigment::factory()
            ->count(5)
            ->create();
    }
}
