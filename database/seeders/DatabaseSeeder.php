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
        $this->call([
            AgamaSeeder::class,
            SubMenuSeeder::class
            SchoolLevelSeeder::class,
            MenuSeeder::class,
            SubMenuSeeder::class,
        ]);
    }
}
