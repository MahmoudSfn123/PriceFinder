<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
    $query = Rating::with(['user','product']);

    // Filtering
    if ($request->has('rating') && $request->rating !== '') {
        $query->where('rating', $request->rating);
    }

    // Search (by product name or user name)
    if ($request->has('search') && $request->search !== '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('product_name', 'like', "%$search%")
                ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%$search%"));
        });
    }

    // Sorting
    if ($request->sort === 'oldest') {
        $query->orderBy('created_at', 'asc');
    } else {
        $query->orderBy('created_at', 'desc');
    }

    $ratings = $query->paginate(10);

    // Stats
    $totalReviews = Rating::count();
    $avgRating = number_format(Rating::avg('rating'), 1);
    $thisMonth = Rating::whereMonth('created_at', now()->month)->count();

    return view('Admin.Reviews.index', compact('ratings', 'totalReviews', 'avgRating', 'thisMonth'));
    }

    public function destroy($id){
        $rating=Rating::find($id);
        $rating->delete();
        return to_route('admin.reviews.index')->with('success','Review deleted successfully');
    }

    public function show($id)
    {
        $rating = Rating::with(['user', 'product'])->findOrFail($id);

        return view('Admin.Reviews.show', [
            'rating' => $rating,
        ]);
    }
}


