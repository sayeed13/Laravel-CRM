<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = User::create(
            [
                'name' => 'sanaf',
                'email' => 'sanaf@admin.com',
                'role' => 'admin',
                'password' => Hash::make('admin1234'),
            ]
            );
        $user->assignRole('admin');
    }
}
