<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::where('id', 2)->update(['comments' => 'So great!']);
        Company::where('id', 3)->update(['comments' => 'Not bad!']);
    }
}
