<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


class AdminPostController extends Controller
{
    public function index()
    {
        return view('admin.posts.index', [
            'posts' => Post::paginate(50),
        ]);
    }

    public function create() { return view('admin.posts.create'); }

    public function store()
    {
         $attributes = $this->validatePost(new Post());

        $attributes['slug'] = Str::slug($attributes['title']);
        $attributes['user_id'] = auth()->user()->id;
        $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');

        Post::create($attributes);

        return redirect('/');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', [
            'post' => $post
        ]);
    }

    public function update(Post $post)
    {
        $attributes = $this->validatePost($post);
        // $lower_case = mb_strtolower($attributes['title'], 'UTF-8');
        // ddd($lower_case, ucwords($lower_case), Str::slug($lower_case));
        $new_slug = [
            'slug' => Str::slug($attributes[
                'title'
            ])
        ];
        if($post->slug != $new_slug['slug']) {
            $attributes['slug'] = Post::latest()->filter($new_slug)->get()->count() == 0 ? Str::slug($attributes['title']) : $post->slug ;
        }

        if(isset($attributes['thumbnail']) ?? false) {
            $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
        }

        $post->update($attributes);
        return redirect('/admin/posts')->with('success','Post Updated!');
    }


    public function destroy(Post $post)
    {
        $post->delete();
        return back()->with('success','Post Deleted!');
    }

    protected function validatePost(?Post $post = null): array {
        $post ??= new Post();
        return request()->validate([
            'title'         => 'required',
            'thumbnail'     => $post->exists ? 'image' : 'required|image',
            'excerpt'       => 'required',
            'body'          => 'required',
            'category_id'   => ['required', Rule::exists('categories','id')]
        ]);
    }

}
