<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegulationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('vi_VN');
        $limit = 200;
        $entities = [];

        for ($i = 0; $i < $limit; $i++) {
            $name = $faker->text(30);
            $createAt = $faker->dateTimeThisYear('now', date_default_timezone_get());
            $entity = [
                'creator_id' => random_int(1, 1000),
                'created_at' => $createAt,
                'updated_at' => $createAt,
                'name' => $name,
                'content' => $faker->paragraph(),
                'status' => random_int(0, 1),
            ];
            $entities[] = $entity;
            if (($i + 1) % 200 === 0) {
                DB::table('regulations')->insert($entities);
                $entities = [];
            }
        }
        DB::table('regulations')->insert($entities);
    }
}
