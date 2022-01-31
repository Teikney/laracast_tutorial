<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //if you need to debug queries, use this and check the /storage/logs/laravel.log
    // DB::listen(function ($query) {
    //     logger($query->sql,$query->bindings);
    // });

    return view('posts', [
        'posts' => Post::latest()->with('category','author')->get()
    ]);
});

Route::get('posts/{post:slug}', function (Post $post) {     //Post::where('slug',$post)->firstOrFail()
    //Find a post by its slug and pass it to a view called "post"

    return view('post', [
        'post' => $post
    ]);
});
//->where('post','[A-z_\-]+');         //whereAlpha, whereNumber

Route::get('categories/{category:slug}', function (Category $category) {
    return view('posts', [
        'posts' => $category->posts
    ]);
});

Route::get('authors/{author:username}', function (User $author) {
    //ddd($author);
    return view('posts', [
        'posts' => $author->posts
    ]);
});

