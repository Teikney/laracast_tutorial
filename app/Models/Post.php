<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //attributes allowed in mass assignment
    protected $fillable = ['title', 'excerpt','body','category_id','slug'];

    //attributes not allowed in mass assignment
    protected $guarded = ['id'];

    //if a 'slug' is always the attribute used to find a Post uncomment this function
    //public function getRouteKeyName()
    //{
    //    return 'slug';   //TODO: Change the autogenerated stub
    //}

    public function category() {
        return $this->belongsTo(Category::class);
    }

}
