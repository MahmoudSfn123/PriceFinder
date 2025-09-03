<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function likes()
    {
        return $this->morphMany(Like::class,'likeable');
    }

    public function isLikedBy(User $user)
    {
        return $this->likes()->where('user_id',$user_id)->exists();
    }

    protected $fillable = [
    'discussion_id',
    'user_id',
    'content',
];
}
