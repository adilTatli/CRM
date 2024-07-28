<?php

namespace Database\Seeders;

use App\Models\PartStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = PartStatus::allStatuses();

        foreach ($statuses as $status) {
            PartStatus::create(['title' => $status]);
        }
    }
}
