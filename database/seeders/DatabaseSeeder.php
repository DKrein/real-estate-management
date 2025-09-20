<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 3 owners
        User::factory(3)->asOwner()->create()->each(function ($owner) {
            // 3-4 team members per owner
            User::factory(rand(3,5))->create([
                'role' => 'member',
            ]);

            // 3-4 buildings per owner
            Building::factory(rand(4,6))->create([
                'owner_id' => $owner->id,
            ])->each(function ($building) {
                // 5-10 units per building
                Unit::factory(rand(5,10))->create([
                    'building_id' => $building->id,
                ]);
            });
        });
    }
}
