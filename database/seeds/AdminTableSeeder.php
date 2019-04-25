<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Đặng Thị Hảo',
                'username' => 'dang.hao',
                'password' => Hash::make('admin123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Đặng Thanh Mai',
                'username' => 'dang.mai',
                'password' => Hash::make('admin123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Cao Ánh Ngọc',
                'username' => 'cao.ngoc',
                'password' => Hash::make('admin123'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
