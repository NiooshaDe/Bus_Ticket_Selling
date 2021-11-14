<?php

namespace Database\Seeders;

use App\Models\Users;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ["id" => 1, "role" => "admin"],
            ["id" => 2, "role" => "super_user"],
            ["id" => 3, "role" => "common_user"],
            ["id" => 4, "role" => "company"],
        ];

        foreach ($data as $item) {
            \DB::table('roles')->insert($item);
        }
    }
}
