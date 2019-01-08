<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create('vi_VN');
        $limit = 1000;
        $entities = [];

        for ($i = 0; $i < $limit; $i++) {
            $name = $faker->text(30);
            $createAt = $faker->dateTimeThisYear('now', date_default_timezone_get());
            $view = random_int(0, 1000);
            $entity = [
                'created_at' => $createAt,
                'updated_at' => $createAt,
                'name' => $name,
                'slug_name' => str_slug($name),
                'image_url' => $faker->imageUrl(),
                'place' => $faker->address,
                'introduction' => $faker->paragraph(),
                'content' => $faker->paragraph(),
                'view_count' => $view,
                'event_date' => $faker->dateTimeBetween($createAt),
                'status' => random_int(0, 1),
            ];
            $entities[] = $entity;
            if (($i + 1) % 200 === 0) {
                DB::table('events')->insert($entities);
                $entities = [];
            }
        }
        DB::table('events')->insert($entities);
    }
}
