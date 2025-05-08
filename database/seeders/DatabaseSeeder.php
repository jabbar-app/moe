<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Jabbar Ali Panggabean',
            'email' => 'jabbarpanggabean@gmail.com',
            'password' => bcrypt('bism!LLAH99'),
        ]);

        $this->call([
            AttendanceListSeeder::class,
        ]);
    }
}
