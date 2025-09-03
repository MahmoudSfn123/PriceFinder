<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index(){

        $users=User::all();
        $products=Product::all();
        $categories = Category::withCount('products')
         ->orderBy('products_count', 'desc')
         ->get();

         $distinctProducts = Product::select('name', DB::raw('AVG(price) as avg_price'))
         ->groupBy('name')
         ->take(5)
         ->get()
         ->map(function ($item) {
             $latestProduct = Product::where('name', $item->name)->latest()->first();
             $item->category_name = $latestProduct->category->name ?? 'N/A';
             return $item;
    });



        return view('Admin.index',[
            'users'=>$users,
            'products'=>$products,
            'categories'=>$categories,
            'distinctProducts'=>$distinctProducts
        ]);
    }
}
