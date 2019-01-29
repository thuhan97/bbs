<?php

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
        $this->call(AdminTableSeeder::class);
        $this->call(PostTableSeed::class);
        $this->call(EventSeed::class);
        $this->call(RegulationTableSeeder::class);
    }
}
