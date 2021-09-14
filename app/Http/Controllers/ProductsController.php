<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    //
    public function index()
    {

        $products = Product::all();
        return view('products', compact('products'));    }
    public function cart()
    {
        return view('cart');
    }
    public function addToCart($id)
    {

        $product = Product::findOrFail($id);
        $cart = session()->get('cart');
        // if cart is empty then this the first product
        if(!$cart) {
            $cart = [
                $id=> [
                    'name'=>$product->name,
                    'quantity'=>1,
                    'price'=>$product->price,
                    'photo'=>$product->photo,

                ]
                ];
                session()->put('cart',$cart);
                return redirect()->back()->with('success', 'Product added to cart successfully!');
        }//end if

                // if cart not empty then check if this product exist then increment quantity
                if(isset($cart[$id])) {
                    $cart[$id]['quantity']++;
                    session()->put('cart',$cart);
                    return redirect()->back()->with('success', 'Product added to cart successfully!');
                 }//end if
                 // if item not exist in cart then add to cart with quantity = 1
                 $cart[$id] = [
                     'name'=>$product->name,
                     'quantity'=>1,
                     'price'=>$product->price,
                     'photo'=>$product->photo,
                 ];
                 session()->put('cart',$cart);
                 return redirect()->back()->with('success', 'Product added to cart successfully!');
    }//end function add to cart
}
