<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
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
                'image_url' => $faker->imageUrl(),
                'customer' => $faker->name(),
                'description' => $faker->paragraph(),
                'scale' => $view,
                'amount_of_time' => $view,
                'start_date' => $faker->dateTimeBetween($createAt),
                'end_date'=>$createAt,
                'status' => random_int(0, 1),
            ];
            $entities[] = $entity;
            if (($i + 1) % 200 === 0) {
                DB::table('projects')->insert($entities);
                $entities = [];
            }
        }
        DB::table('projects')->insert($entities);
    }
}
