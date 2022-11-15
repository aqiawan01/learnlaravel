<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    protected $fillable = ['name', 'slug','parent_id', 'category_img', 'description','status' ];

    // public function subcategory()
    // {
    //     return $this->hasMany(\App\Category::class, 'parent_id');
    // }

    // public function parent()
    // {
    //     return $this->belongsTo(\App\Category::class, 'parent_id');
    // }

    

    

     
}
