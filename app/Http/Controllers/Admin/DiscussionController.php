<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discussion;

class DiscussionController extends Controller
{
    public function index(){
        $discussions = Discussion::with(['author', 'category', 'replies', 'lastPost'])->paginate(3);
        return view('Admin.Discussions.index',['discussions'=>$discussions]);
    }
    public function lock($id)
    {
        try {
            $discussion = Discussion::findOrFail($id);
            $discussion->locked = true;
            $discussion->save();

            return response()->json([
                'success' => true,
                'message' => 'Discussion locked successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error locking discussion: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Unlock a discussion
     */
    public function unlock($id)
    {
        try {
            $discussion = Discussion::findOrFail($id);
            $discussion->locked = false;
            $discussion->save();

            return response()->json([
                'success' => true,
                'message' => 'Discussion unlocked successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error unlocking discussion: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $discussion = Discussion::with(['author', 'category', 'replies.author'])->findOrFail($id);
        return view('Admin.Discussions.show', compact('discussion'));
    }



      public function destroy($id)
    {
        try {
            $discussion = Discussion::findOrFail($id);
            $discussion->replies()->delete(); // Optional: clean up replies
            $discussion->delete();

            return response()->json([
                'success' => true,
                'message' => 'Discussion deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting discussion: ' . $e->getMessage()
            ], 500);
        }
    }





}
