<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    public function author()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function lastPost()
    {
        return $this->belongsTo(Reply::class,'last_post_id');
    }

    public function likes()
    {
        return $this->morphMany(Like::class,'likeable');
    }

    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id',$user->id)->exists();
    }

    protected $fillable = [
    'category_id',
    'user_id',
    'content',
    'topic',
    'last_post_id', // optional, only if you're using it
    'locked'
];
}
