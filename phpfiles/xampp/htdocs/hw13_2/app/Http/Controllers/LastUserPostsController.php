<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use JavaScript;

class LastUserPostsController extends Controller
{
    public function show()
    {
        $user = User::select('name')->orderBy('created_at', 'desc')->first();
        $result = Post::join('users', 'users.id', '=', 'posts.user_id')
            ->select('posts.file_path')
            ->where('users.id', '=', "$user->id")
            ->take(5)
            ->get();


        return view('pages.tables')->with('result', $result)->with('userName', $user);
//        JavaScript::put(['file_path' => 50]);
//        return view('dashboard');
    }
}
