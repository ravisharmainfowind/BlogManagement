<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $guarded = [''];

    public function postCategories() {
        return $this->hasMany(Post_Category::class, 'post_id', 'id');
     }

     public function categories(){
        return $this->belongsToMany(Category::class, 'post_categories');
   }
}
