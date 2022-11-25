<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'fullName' =>'Kaleb Tilahun',
            'email' => 'Kaleb@gmail.com',
            'password' =>bcrypt('12345678'),
            'role_id'=>1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('users')->insert([
            'fullName' =>'Isaak Tilahun',
            'email' => 'Isaak@gmail.com',
            'password' =>bcrypt('12345678'),
            'role_id'=>2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        DB::table('users')->insert([
            'fullName' =>'Josh Tilahun',
            'email' => 'Josh@gmail.com',
            'password' =>bcrypt('12345678'),
            'role_id'=>4,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
