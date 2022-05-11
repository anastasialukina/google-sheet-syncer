<?php

namespace Database\Seeders;

use App\Models\TimeEntry;
use App\Models\User;
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
        TimeEntry::factory()
            ->count(15)
            ->create();

        User::factory()
            ->count(30)
            ->create();
    }
}
