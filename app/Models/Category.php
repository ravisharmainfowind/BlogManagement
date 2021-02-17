<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $guarded = [''];

    public function children()
  {
    return $this->hasMany('App\Models\Category', 'parent_id');
  }
}
