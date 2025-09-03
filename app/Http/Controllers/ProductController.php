<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
  public function show($catid = null)
{
    $query = Product::with('category');

    if ($catid) {
        $query->where('category_id', $catid);
    }

    // Get all products (filtered)
    $allProducts = $query->get();

    // Group by product name
    $products = $allProducts->groupBy('name')->map(function ($group) {
        $first = $group->first();

        // Price calculations
        $first->avg_price = round($group->avg('price'), 2);
        $first->price_count = $group->count();
        $first->stores = $group->pluck('store_name')->unique()->values();

        // Ratings
        $productName = $first->name;
        $first->avg_rating = round(Rating::where('product_name', $productName)->avg('rating'), 1); // ensure 1 decimal
        $first->rating_count = Rating::where('product_name', $productName)->count();

        return $first;
    })->values();

    $categoryName = $catid ? Category::find($catid)?->name : 'All Products';

    return view('Products.show', [
        'product' => $products,
        'category' => $categoryName,
    ]);
}





    public function create(){

        $categories=Category::all();
        $sub = Product::select(DB::raw('MIN(id) as min_id'))
             ->groupBy('name');

        $products = Product::whereIn('id', $sub
        ->pluck('min_id'))
        ->get();

        return view('Products.create',[
            'category'=>$categories,
            'products'=>$products,
            'searchResults' => collect(),   // Add this
            'searchQuery' => ''
        ]);
    }

   public function store(Request $request)
    {



        $validated = $request->validate([
            'product_select' => 'required|max:255|string',
            'name' => 'nullable|max:255|string|required_if:product_select,add_new',
            'purchase_date' => 'required|date|before_or_equal:today',
            'store_name' => 'required|max:255|string',
            'invoice' =>'required|file|mimes:png,jpg,jpeg',
            'image_path' => 'nullable|mimes:png,jpg,jpeg',
            'price' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        try {
            $productName = $request->product_select === 'add_new'
                ? $request->name
                : $request->product_select;

            // Move invoice from temp to final path
            // $tempPath = public_path($request->invoice_path);
            // $filename = 'invoice_' . uniqid() . '.' . pathinfo($tempPath, PATHINFO_EXTENSION);
            // $finalPath = 'assets/img/products/' . $filename;

            // if (file_exists($tempPath)) {
            //     rename($tempPath, public_path($finalPath));
            // } else {
            //     throw new \Exception("Invoice file not found.");
            // }

             $originalImagePath = null;
            if ($request->hasFile('invoice')) {
                // Save the original invoice image
                $file = $request->file('invoice');
                $filename = 'original_invoice_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = 'assets/img/products/';
                $file->move(public_path($path), $filename);
                $originalImagePath = $path . $filename;
}


            $imagePath = null;
            if ($request->hasFile('image_path')) {
                $file = $request->file('image_path');
                $filename1 = 'product_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path1 = 'assets/img/products/';
                $file->move(public_path($path1), $filename1);
                $imagePath = $path1 . $filename1;
            }

            $product = Product::create([
                'name' => $productName,
                'purchase_date' => $request->purchase_date,
                'store_name' => $request->store_name,
                'invoice' => $originalImagePath,
                'image_path' => $imagePath,
                'price' => $request->price,
                'category_id' => $request->category
            ]);

            $product->users()->attach(auth()->id());

        return redirect()->route('products.show')->with('success', 'Product created successfully!');

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error saving product.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


//     public function tempUpload(Request $request)
// {
//     $request->validate([
//         'invoice' => 'required|mimes:jpg,jpeg,png'
//     ]);

//     $file = $request->file('invoice');
//     $filename = 'temp_' . uniqid() . '.' . $file->getClientOriginalExtension();
//     $path = 'temp-invoices/' . $filename;

//     $file->move(public_path('temp-invoices'), $filename);

//     return response()->json([
//         'status' => 'success',
//         'path' => $path
//     ]);
// }


   public function showDetails($id){

    $product=Product::with('category')->findOrFail($id);//findOrFail($id) automatically throw a ModelNotFoundException. 404 page is shown

    $relatedProducts = Product::where('name',$product->name)->get();

    $ratings = Rating::where('product_name', $product->name)
    ->latest()
    ->get();



    $avgPriceRaw = $relatedProducts->avg('price');

    // Format average price to 3 decimal places
    $avgPrice = number_format($avgPriceRaw, 2, '.', '');
    $minPrice=$relatedProducts->min('price');
    $maxPrice=$relatedProducts->max('price');
    $priceCount=$relatedProducts->count();

    $stores = $relatedProducts->pluck('store_name')->unique()->values();

    $averageRating = round($ratings->avg('rating'), 1); // e.g., 4.3
$ratingsCount = $ratings->count();

    return view('Products.details',[
        'product'=>$product,
        'avgPrice'=>$avgPrice,
        'minPrice'=>$minPrice,
        'maxPrice'=>$maxPrice,
        'stores'=>$stores,
        'priceCount'=>$priceCount,
        'updatedAt'=>$relatedProducts->max('updated_at')?->diffForHumans(),
        'relatedProducts'=>$relatedProducts,
        'ratings'=>$ratings,
        'averageRating' => $averageRating,
        'ratingsCount' => $ratingsCount
    ]);

    }

 public function rate(Request $request, Product $product)
{
    $validated = $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:500',
    ]);

    Rating::create([
        'user_id' => Auth::check() ? Auth::id() : null, // user_id nullable if guest
        'product_name' => $product->name,
        'rating' => $validated['rating'],
        'comment' => $validated['comment'],
    ]);

    return back()->with('success', 'Thank you for your feedback!');
}

}

