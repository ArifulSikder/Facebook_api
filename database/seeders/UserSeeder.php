<?php

namespace Database\Seeders;
use Faker\Factory as Faker;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $numberOfUsers = 100000;

        foreach (range(1, $numberOfUsers) as $index) {
            User::create([
                'name' => $faker->name,
                'birthday' => $faker->date('Y-m-d', '2000-01-01'),
                'address' => $faker->address,
                'city' => $faker->city,
                'state' => $faker->stateAbbr,
                'zip' => $faker->postcode,
                'phone' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'role' => $faker->randomElement(['user', 'admin']),
                'password' => Hash::make('password123'), // Default password
            ]);
        }

        $this->command->info('Users table seeded!');
}
}
