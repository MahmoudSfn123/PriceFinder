<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(){

       $products = Product::select('name', 'category_id')
       ->selectRaw('MIN(price) as min_price, MAX(price) as max_price, COUNT(*) as total')
       ->with('category') // assuming relationship exists
       ->groupBy('name', 'category_id')
       ->latest()
       ->paginate(5);

        return view('Admin.Products.index', [
            'title' => 'Products',
            'products' => $products,
        ]);

    }


public function show($name)
{
    // Get all products with the same name, paginated, with related users and category
    $products = Product::with(['users', 'category'])
        ->where('name', $name)
        ->orderByDesc('created_at')
        ->paginate(3); // Each store entry is a product record

    if ($products->isEmpty()) {
        abort(404, 'Product not found');
    }

    // Shared product metadata
    $category = $products->first()->category;
    $productName = $name;
    $lowestPrice = $products->min('price');
    $highestPrice = $products->max('price');
    $averagePrice = round($products->avg('price'), 2);
    $lastUpdated = $products->max('updated_at')?->diffForHumans() ?? 'N/A';

    // Ratings and Reviews
    $ratings = Rating::with('user')
        ->where('product_name', $productName)
        ->latest()
        ->get();

    $totalReviews = $ratings->count();
    $avgRating = $totalReviews > 0 ? round($ratings->avg('rating'), 1) : 0;

    // Count ratings per score and calculate % for visual bar widths
    $ratingCounts = [];
    $ratingBreakdown = [];

    for ($i = 5; $i >= 1; $i--) {
        $count = $ratings->where('rating', $i)->count();
        $ratingCounts[$i] = $count;
        $ratingBreakdown[$i] = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
    }

    $recentReviews = $ratings->take(5);

    return view('Admin.Products.show', compact(
        'products',
        'category',
        'lowestPrice',
        'highestPrice',
        'averagePrice',
        'lastUpdated',
        'productName',
        'avgRating',
        'totalReviews',
        'ratingCounts',
        'ratingBreakdown',
        'recentReviews'
    ));
}


    public function create()
    {
        $categories=Category::all();
        $sub = Product::select(DB::raw('MIN(id) as min_id'))
             ->groupBy('name');

        $products = Product::whereIn('id', $sub
        ->pluck('min_id'))
        ->get();
        return view('Admin.Products.create',[
            'categories'=>$categories,
            'products'=>$products
        ]);
    }

    public function store(Request $request){

        $request->validate([
            'productName' => 'required|max:255|string',
            'name' => 'nullable|max:255|string|required_if:productName,add_new',
            'purchase_date'=>'required|date|before_or_equal:today',
            'store_name'=>'required|max:255|string',
            'invoice'=>'required|mimes:png,jpg,jpeg',
            'image_path'=>'required|mimes:png,jpg,jpeg',
            'category' => 'required|exists:categories,id',
            'price'=>'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/'//regex.. allows only numbers with up to two decimal places
        ]);
        $productName=$request->productName === 'add_new' ?$request->name : $request->productName;


        $imagePath=null;
        $invoicePath=null;
        if($request->hasFile('invoice')){
            $file2=$request->file('invoice');
            $filename2='product_'.uniqid().'.'.$file2->getClientOriginalExtension();
            $path2='assets/img/products/';
            $file2->move(public_path($path2),$filename2);
            $invoicePath=$path2.$filename2;
        }

        if($request->hasFile('image_path')){
            $file1=$request->file('image_path');
            $filename1='product_'.uniqid().'.'.$file1->getClientOriginalExtension();
            $path1='assets/img/products/';
            $file1->move(public_path($path1),$filename1);
            $imagePath=$path1.$filename1;
        }

        $product=Product::create([
            'name'=>$productName,
            'purchase_date'=>$request->purchase_date,
            'store_name'=>$request->store_name,
            'invoice'=>$invoicePath,
            'image_path'=>$imagePath,
            'price'=>$request->price,
            'category_id'=>$request->category
        ]);

        $product->users()->attach(auth()->id());

        return redirect()->route('admin.products.index')->with('success','Product added successfully. ');

    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $products = Product::select('name')->distinct()->get();

        return view('Admin.Products.edit', compact('product', 'categories', 'products'));
    }



    public function update(Request $request, Product $product)
    {
        $request->validate([
            'purchase_date' => 'required|date|before_or_equal:today',
            'store_name' => 'required|max:255|string',
            'invoice' => 'nullable|mimes:png,jpg,jpeg',
            'image_path' => 'nullable|mimes:png,jpg,jpeg',
            'category' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        $product->purchase_date = $request->purchase_date;
        $product->store_name = $request->store_name;
        $product->price = $request->price;
        $product->category_id = $request->category;

        if ($request->hasFile('invoice')) {
            $file2 = $request->file('invoice');
            $filename2 = 'invoice_' . uniqid() . '.' . $file2->getClientOriginalExtension();
            $path2 = 'assets/img/products/';
            $file2->move(public_path($path2), $filename2);
            $product->invoice = $path2 . $filename2;
        }

        if ($request->hasFile('image_path')) {
            $file1 = $request->file('image_path');
            $filename1 = 'product_' . uniqid() . '.' . $file1->getClientOriginalExtension();
            $path1 = 'assets/img/products/';
            $file1->move(public_path($path1), $filename1);
            $product->image_path = $path1 . $filename1;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($product){
        $product=Product::find($product);
        $product->delete();

        return to_route('admin.products.index')->with('success','Product Deleted Successfully');
    }



}
