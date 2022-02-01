<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function index()
    {
        //ddd(request(['search','category']));
        return view('posts.index', [
            'posts' => Post::/* latest()-> */filter( request(['search', 'category']) )->get(),   //  ['search'] is return the same as request()->only('search')
        ]);
    }

    public function show(Post $post)
    {
        //Find a post by its slug and pass it to a view called "post"

        return view('posts.show', [
            'post' => $post
        ]);
    }

}
