<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            "name" => "SuperUser",
            "phone_number" => "09921802167",
            "email" => "superUserSeeder@gmail.com",
            "password" => Hash::make("SuperUserPass"),
            "gender" => "male",
            "role_id" => 2,
            'created_at' =>  \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ];

        DB::table('users')->insert($data);
    }
}
