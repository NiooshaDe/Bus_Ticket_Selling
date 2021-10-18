<?php

namespace Database\Seeders;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::insert([
            'id' => 1,
            'name' => 'my image',
            'file_path' => 'C:\Users\IHC\Pictures\Screenshots0',
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Post::insert([
            'id' => 3,
            'name' => 'my image',
            'file_path' => 'C:\Users\IHC\Pictures\Screenshots0',
            'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Post::insert([
            'id' => 2,
            'name' => 'her image',
            'file_path' => 'C:\Users\IHC\Pictures\Screenshots1',
            'user_id' => 1,
            'created_at' => Carbon::yesterday(),
            'updated_at' => Carbon::yesterday(),
        ]);
    }
}
