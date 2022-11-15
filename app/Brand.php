<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
     protected $table = 'brand';
    // protected $fillable = ['title', 'slug', 'designation', 'dob', 'country', 'email'];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];
}
