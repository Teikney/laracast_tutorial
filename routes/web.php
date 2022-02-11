<?php

use App\Http\Controllers\PostCommentsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\NewsletterController;
use App\Services\Newsletter;
use App\Http\Controllers\AdminPostController;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
// use App\Models\Post;
// use App\Models\Category;
// use App\Models\User;
// use Illuminate\Support\Facades\DB;

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

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('posts/{post:slug}', [PostController::class, 'show']);       //->where('post','[A-z_\-]+');         //whereAlpha, whereNumber

Route::post('posts/{post:slug}/comments', [PostCommentsController::class, 'store']);

Route::post('newsletter', NewsletterController::class);

// Route::get('categories/{category:slug}', function (Category $category) {
    //     return view('posts', [
        //         'posts' => $category->posts,
        //         'currentCategory' => $category,
        //         'categories' => Category::all()
        //     ]);
        // })->name('category');

// Route::get('authors/{author:username}', function (User $author) {
//     //ddd($author);
//     return view('posts.index', [
//         'posts' => $author->posts
//     ]);
// });

Route::get('register', [RegisterController::class, 'create'])->middleware('guest');
Route::post('register', [RegisterController::class, 'store'])->middleware('guest');

Route::get('login', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('login', [SessionsController::class, 'store'])->middleware('guest');

Route::post('logout', [SessionsController::class, 'destroy'])->middleware('auth');

Route::middleware('can:admin')->group(function () {
    Route::get('admin/posts', [AdminPostController::class, 'index']);
    Route::get('admin/posts/{post:slug}/edit', [AdminPostController::class, 'edit']);
    Route::get('admin/posts/create', [AdminPostController::class, 'create']);
    Route::post('admin/posts', [AdminPostController::class, 'store']);
    Route::patch('admin/posts/{post:slug}',[AdminPostController::class, 'update']);
    Route::delete('admin/posts/{post:slug}', [AdminPostController::class, 'destroy']);
});
