<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get("database/data/AdminPermission.json");
        $permissions = json_decode($json);
    DB::table('roles')->insert([
            'roleName' =>'Super admin',
            'isAdmin'=>true,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'permission'=>$json,
        ]
    );
    DB::table('roles')->insert([
        'roleName' =>'Purchaser',
        'isAdmin'=>true,
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'permission'=>$json,
    ]);
    DB::table('roles')->insert([
        'roleName' =>'Main Store keeper',
        'isAdmin'=>true,
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'permission'=>$json,
    ]);
    DB::table('roles')->insert([
        'roleName' =>'Site Engineer',
        'isAdmin'=>true,
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'permission'=>$json,
    ]);
    DB::table('roles')->insert([
        'roleName' =>'Store keeper 2',
        'isAdmin'=>true,
        'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        'permission'=>$json,
    ]);
    }
}
