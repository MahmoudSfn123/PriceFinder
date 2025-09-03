<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   protected $fillable=[
        'name','store_name', 'image_path', 'invoice', 'price', 'category_id', 'purchase_date', 'verified'
    ];

    public function users(){ return $this->belongsToMany(User::class);}

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function getRouteKeyName()
{
    return 'id';
}
protected $casts = [
    'purchase_date' => 'datetime',
];
}








