<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discussion;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Reply;


class DiscussionController extends Controller
{
    public function index()
    {
        $discussions=Discussion::with('author','category','replies.author','likes','lastPost')->latest()->get();
        return view('Discussions.index',['discussions'=>$discussions]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('Discussions.create', compact('categories'));
    }

    // Store the new discussion
    public function store(Request $request)
    {
        $request->validate([
            'category'=>'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $discussion=Discussion::create([
            'category_id'=>$request->category,
            'user_id'=>Auth::id(),
            'topic'=>$request->title,
            'content'=>$request->content
        ]);

        return to_route('discussions.index')->with('success','Discussion created successfully!');
    }

    public function show(Discussion $discussion)
    {
    // Load related replies and authors
    $discussion->load('author', 'category', 'replies.author');
    return view('Discussions.show', compact('discussion'));
    }

    public function storeReply(Request $request,$discussionId)
    {
        $request->validate([
            'content'=>'required|string',
        ]);

        $reply=Reply::create([
            'discussion_id'=>$discussionId,
            'user_id'=>Auth::id(),
            'content'=>$request->content,
        ]);

        $discussion = Discussion::findOrFail($discussionId);
        $discussion->last_post_id = $reply->id;
        $discussion->save();

        return to_route('discussions.show',$discussionId)->with('success', 'Reply posted successfully!');
    }

    public function toggleDiscussionLike($discussionId)
{
    $discussion = Discussion::findOrFail($discussionId);
    $user = Auth::user();

    $existingLike = $discussion->likes()->where('user_id', $user->id)->first();

    if ($existingLike) {
        $existingLike->delete();
        $liked = false;
    } else {
        $discussion->likes()->create(['user_id' => $user->id]);
        $liked = true;
    }

    return response()->json([
        'liked' => $liked,
        'likesCount' => $discussion->likes()->count(),
    ]);
}


    public function toggleReplyLike($replyId)
    {
        $reply = Reply::findOrFail($replyId);
        $user = Auth::user();

        $existingLike = $reply->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            $reply->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likesCount' => $reply->likes()->count(),
        ]);
    }
        }

