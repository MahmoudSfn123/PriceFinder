<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class VerificationController extends Controller
{
    public function index(){

         $products = Product::with('users') ->paginate(5);

        return view('Admin.Verifications.index',['products'=>$products]);
    }

    public function verify(Request $request, $id)
{
    try{
    $product = Product::findOrFail($id);
    $product->verified = $request->input('verified');  // expects 1 or 0
    $product->save();

    return response()->json(['success' => true]);
}catch (\Exception $e) {
        \Log::error('Verification Error: ' . $e->getMessage());
        return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    }
}
}
