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
            'file_path' => 'data:image/png;base64,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',
                'user_id' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Post::insert([
            'id' => 3,
            'name' => 'my image',
            'file_path' => 'C:\Users\IHC\Pictures\Screenshots\Screenshot(18)',
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
