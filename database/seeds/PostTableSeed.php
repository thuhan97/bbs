<?php

use Illuminate\Database\Seeder;

class PostTableSeed extends Seeder
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
            $view = random_int(0, 1000);
            $entity = [
                'creator_id' => random_int(1, 1000),
                'created_at' => $createAt,
                'updated_at' => $createAt,
                'name' => $name,
                'image_url' => $faker->imageUrl(),
                'slug_name' => str_slug($name),
                'author_name' => $faker->name(),
                'introduction' => $faker->text(),
                'content' => $faker->paragraph(),
                'view_count' => $view,
                'has_notify' => random_int(0, 1),
                'notify_date' => $faker->dateTimeThisMonth(),
                'status' => random_int(0, 1),
            ];
            $entities[] = $entity;
            if (($i + 1) % 200 === 0) {
                DB::table('posts')->insert($entities);
                $entities = [];
            }
        }
        DB::table('posts')->insert($entities);
    }
}
