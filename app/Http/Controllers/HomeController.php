<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Search;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        //QueryBuilder
            /* $result=DB::table('categories')->get();

                return view('home',['categories'=>$result]);*/

    //Eloquent

        //insert data
        /*$categories_data=[
            'name'=>'Beauty & Personal Care',
            'description'=>'A wide range of skincare, makeup, grooming, and wellness products to help you look and feel your best.',
            'imagepath'=>'/assets/img/beauty.jpg'
        ];
        $category=Categories::create($categories_data);*/

        //select data
     $categories=Category::all();

    $sub = Product::select(DB::raw('MIN(id) as min_id'))
        ->groupBy('name');


    $products = Product::with('users')
    ->whereIn('id', $sub->pluck('min_id'))
    ->get();

    if($request->has('search')){

        $searchTerm=$request->input('search');

        //  Search::create([
        // 'user_id' => auth()->check() ? auth()->id() : null,
        // 'term' => $searchTerm,
        // ]);

        $searchResult=Product::with('users')
        ->where('name','like','%'.$searchTerm.'%')
        ->orderBy('price','asc')
        ->get();
    }else{
        $searchResult=collect();
    }



    return view('home',[
        'category' => $categories,
        'products' => $products,
        'searchResults' => $searchResult,
        'searchQuery' => $request->search
        ]);
    }

    public function recentSearches()
    {
        $recentSearches = Search::latest()->take(6)->get();

        return view('components.recent-searches', compact('recentSearches'));
    }


}

