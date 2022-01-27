<?php
namespace App\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;

class Post {

    public $title;
    public $excerpt;
    public $date;
    public $slug;
    public $body;

    public function __construct($title, $excerpt, $date, $slug, $body) {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->slug = $slug;
        $this->body = $body;
    }

    public static function find($slug) {
        return static::all()->firstWhere('slug',$slug);
    }

    public static function findOrFail($slug) {
        $post = static::find($slug);

        if(! $post) {
            throw new ModelNotFoundException();
        }

        return $post;
    }

    public static function all() {
        $files = File::files(resource_path("posts"));
        //          1st way of getting the contents and metadata of all Posts
        /*$posts = [];
        foreach ($files as $file) {
            $document = YamlFrontMatter::parseFile($file);

            $posts[] = new Post (
                $document->title,
                $document->excerpt,
                $document->date,
                $document->slug,
                $document->body()
            );
        }*/


        //          2nd way of getting the contents and metadata of all Posts
        /*return array_map(function ($file) {
            $document = YamlFrontMatter::parseFile($file);

            return new Post (
                $document->title,
                $document->excerpt,
                $document->date,
                $document->slug,
                $document->body()
            );
        },$files);*/


        //            3rd way of getting the contents and metadata of all Posts
        return cache()->rememberForever('posts.all', function () use ($files) {
            return collect($files)
                ->map(function ($file) {
                    return YamlFrontMatter::parseFile($file);
                })
                ->map( function ($document) {

                    return new Post (
                        $document->title,
                        $document->excerpt,
                        $document->date,
                        $document->slug,
                        $document->body()
                    );
                })->sortByDesc('date');
        });
    }
}


