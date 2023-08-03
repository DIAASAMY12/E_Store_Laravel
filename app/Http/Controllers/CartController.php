<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\Item;
use Illuminate\Http\Request;

class CartController extends Controller
{


    public function show()
    {
        $cartItems = session('cart', []);
        $inventoriesItem = InventoryItem::all();
        return view('items/showCart', compact('cartItems','inventoriesItem'));
    }

    public function clear(Request $request)
    {
        $request->session()->forget('cart');
        return redirect()->route('cart.show')->with('success', 'Cart cleared successfully.');
    }

}
