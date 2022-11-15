<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSpecification extends Model
{
    protected $table = 'specification';

    protected $guarded = [];

    public function products(){
        return $this->belongsTo( Product::class, 'id');
    }
}
