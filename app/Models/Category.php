<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    const UPDATED_AT = null;

    //fillable:all the fields i want to allow to insert
    protected $fillable=[
        'name',
        'description',
        'imagepath'
    ];

    //guarded: all the fields inserted except the field between [] 
    //protected $guarded=[];

    public function products():HasMany{
        return $this->hasMany(Product::class, 'category_id');
    }
}
