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
         \App\Models\Settings::factory()->count(3)->create();
         \App\Models\User::factory(1)->create();
         \App\Models\Location::factory()->count(5)->create();
         \App\Models\Business::factory()->count(5)->create();
         \App\Models\Package::factory()->count(130)->create();
    }
}
