<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Team;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\Lead::factory(50)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(RoleSeeder::class);
        $this->call(AdminSeeder::class);

        // \App\Models\Team::factory(2)->create();

        // $faker = Faker::create();

        // foreach (range(1, 500) as $index) {
        //     DB::table('leads')->insert([
        //         'phone' => $faker->randomNumber(5, true),
        //         'status' => 1,
        //         'username' => $faker->unique()->randomNumber(),
        //         'ftd' => 1,
        //         'country' => $faker->country(),
        //         'lead_agent_id' => User::where('role', 'agent')->get()->random()->id,
        //         'team_id' => Team::all()->random()->id,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }
    }
}
