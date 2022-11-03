<?php

namespace Database\Seeders;

use App\Models\CompanyLead;
use Illuminate\Database\Seeder;

class CompanyLeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompanyLead::factory()
            ->count(5)
            ->create();
    }
}
