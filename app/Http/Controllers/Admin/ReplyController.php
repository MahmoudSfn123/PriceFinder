<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reply;

class ReplyController extends Controller
{
    public function destroy($id)
    {
        try {
            $reply = Reply::findOrFail($id);
            $reply->delete();

            return response()->json([
                'success' => true,
                'message' => 'Reply deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete reply: ' . $e->getMessage()
            ], 500);
        }
    }
}
