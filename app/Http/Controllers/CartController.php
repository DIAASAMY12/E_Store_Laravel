<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\Item;
use Illuminate\Http\Request;

class CartController extends Controller
{
//    public function add(Request $request, $item)
//    {
//        $quantity = $request->input('quantity', 1);
//
//        // Get the item from the database based on the given item ID
//        $item = Item::find($item);
//
//        if (!$item) {
//            return redirect()->back()->with('error', 'Item not found.');
//        }
//
//        // Create a cart item array with item details
//        $cartItem = [
//            'item_id' => $item->id,
//            'name' => $item->name,
//            'quantity' => $quantity,
//            'created_at' => now(),
//        ];
//
//        // Add the cart item to the cart session
//        $request->session()->push('cart', $cartItem);
//
//        return redirect()->back()->with('success', 'Item added to cart successfully.');
//    }

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
