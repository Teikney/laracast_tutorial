<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index()
    {
        //dd(Gate::allows('admin'));
        //dd(request()->user()->can('admin'));
        //$this->authorize('admin');
        return view('posts.index', [
            'posts' => Post::latest()->filter(      //  ['search'] return's the same as request()->only('search')
                request([
                    'search',
                    'category',
                    'author'
                ])
            )->paginate(6)->withQueryString(),
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
