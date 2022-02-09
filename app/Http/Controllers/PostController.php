<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function index()
    {
        return view('posts.index', [
            'posts' => Post::latest()->filter(      //  ['search'] is return the same as request()->only('search')
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

    public function create(Post $post) { return view('posts.create'); }

    public function store(Post $post) {

        $attributes = request()->validate([
            'title'         => 'required',
            'thumbnail'     => 'required|image',
            'excerpt'       => 'required',
            'body'          => 'required',
            'category_id'   => ['required', Rule::exists('categories','id')]
        ]);

        $attributes['slug'] = Str::slug($attributes['title']);
        $attributes['user_id'] = auth()->user()->id;
        $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');

        Post::create($attributes);

        return redirect('/');
    }

}
