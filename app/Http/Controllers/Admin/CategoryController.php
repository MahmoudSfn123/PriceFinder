<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(){
       $categories = Category::withCount('products')->paginate(4);

        return view('Admin.Categories.index',['categories'=>$categories]);
    }

    public function create(){
        return view('Admin.Categories.create');
    }


        public function store(Request $request){

        $request->validate([
            'name' => 'required|max:255|string',
            'description'=>'required|max:255|string',
            'imagepath'=>'required|mimes:png,jpg,jpeg',
        ]);



        $imagePath=null;

        if($request->hasFile('imagepath')){
            $file1=$request->file('imagepath');
            $filename1='category_'.uniqid().'.'.$file1->getClientOriginalExtension();
            $path1='assets/img/';
            $file1->move(public_path($path1),$filename1);
            $imagePath=$path1.$filename1;
        }

        $category=Category::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'imagepath'=>$imagePath,
        ]);



        return redirect()->route('admin.categories.index')->with('success','Category added successfully. ');

    }

    public function show($id){
        $category = Category::findOrFail($id);

        $productCount = DB::table('products')
        ->where('category_id', $id)
        ->count();

        $products = DB::table('products')
    ->select(
        'name',
        DB::raw('MIN(image_path) as image_path'),
        DB::raw('MIN(price) as min_price'),
        DB::raw('MAX(price) as max_price')
    )
    ->where('category_id', $id)
    ->groupBy('name')
    ->get();

        return view('Admin.Categories.show',['category'=>$category,'products'=>$products,'productCount'=>$productCount]);
    }

    public function edit($id)
{
    $category = Category::findOrFail($id);
    return view('Admin.Categories.edit', compact('category'));
}

    public function update(Request $request){
        {
         $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'imagepath' => 'required|image|max:5120', // Max 5MB
    ]);

    $category = Category::findOrFail($request->id);
    $category->name = $request->name;
    $category->description = $request->description;

    // Handle image upload if a new one is provided
    if ($request->hasFile('imagepath')) {
    $image = $request->file('imagepath');
    $imageName ='assets/img/'. time() . '_' . $image->getClientOriginalName();
    $image->move(public_path('assets/img'), $imageName); // ✅ Save to public/img
    $category->imagepath = $imageName; // ✅ Just store filename
}


    $category->save();

    return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }
    }

     public function destroy($id)
{
    $category = Category::find($id);

    if (!$category) {
        return redirect()->route('admin.categories.index')->with('error', 'Category not found.');
    }

    $category->delete();

    return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
}



}
