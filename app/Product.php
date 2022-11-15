<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     protected $table = 'product';
    // protected $fillable = ['title', 'slug', 'designation', 'dob', 'country', 'email'];
    protected $guarded = [ 'id', 'created_at', 'updated_at' ];
   
   public function specification()
    {
    	return $this->hasMany(ProductSpecification::class, 'product_id', 'id');
    }
}
