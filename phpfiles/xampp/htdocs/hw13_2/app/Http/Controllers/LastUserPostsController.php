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
        $user = User::select('id')->orderBy('created_at', 'desc')->first();
        $result = Post::join('users', 'users.id', '=', 'posts.user_id')
            ->selectRaw('posts.name, posts.file_path')
//            ->select('posts.file_path')
            ->where('users.id', '=', "$user->id")
            ->take(5)
            ->get();

//        dd($user);

//        dd($result);
        return view('testView')->with('results', $result);
//        JavaScript::put(['file_path' => 50]);

    }
}
