<?php

namespace Database\Seeders;

use Illuminate\Database\Console\DbCommand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            "name" => "Admin",
            "phone_number" => "09921802166",
            "email" => "adminSeeder@gmail.com",
            "password" => Hash::make("AdminPass"),
            "gender" => "female",
            "role_id" => 1,
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ];

        DB::table('users')->insert($data);
    }
}
