<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class StockController extends Controller{
    public function index(){
        $user = auth('admin')->user();
        $query = Product::with('product_image');
        if ($user->user_type != 1) {
            $query->where('user_id', $user->id);
        }
        $products = $query->get();
        return view('Backend.Pages.Product.Stock.index', compact('products'));
    }
    public function add_stock(Request $request){
        // StockMovement::create([
        //     'product_id' => $product_id,
        //     'quantity' => $quantity,
        //     'movement_type' => 'in',
        // ]);
        // $product = Product::find($product_id);
        // $product->qty += $quantity;
        // $product->save();
    }
    public function remove_stock(Request $request){
        // StockMovement::create([
        //     'product_id' => $product_id,
        //     'quantity' => $quantity,
        //     'movement_type' => 'out',
        // ]);

        // $product = Product::find($product_id);
        // $product->qty -= $quantity;
        // $product->save();
    }
}
