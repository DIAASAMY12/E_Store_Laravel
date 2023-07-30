<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class InventoryItem extends Model
{
    use HasFactory;
//    public function addToCart(Request $request, $id)
//    {
//        $item = Item::find($id);
//
//        if (!$item) {
//            return redirect()->route('items.index')->with('error', 'Ite   m not found.');
//        }
//
//        $validator = Validator::make($request->all(), [
//            'quantity' => 'required|integer|min:1',
//        ]);
//
//        if ($validator->fails()) {
//            return redirect()->route('items.index')->withErrors($validator)->withInput();
//        }
//
//        $quantity = $request->input('quantity');
//
//        // Get the quantity from the InventoryItems table based on the item's ID
//        $inventoryItem = InventoryItem::where('item_id', $item->id)->first();
//
//        if (!$inventoryItem) {
//            return redirect()->route('items.index')->with('error', 'Inventory item not found.');
//        }
//
//        // Use the retrieved quantity from the InventoryItems table
//        $quantity = min($quantity, $inventoryItem->quantity);
//
//        $cart = $request->session()->get('cart', []);
//        $cart[] = [
//            'item_id' => $item->id,
//            'name' => $item->name,
//            'quantity' => $quantity,
//            'created_at' => now(),
//        ];
//        $request->session()->put('cart', $cart);
//
//        return redirect()->route('items.index')->with('success', 'Item added to cart successfully.');
//    }

    protected $fillable = ['item_id','inventory_id', 'quantity'];

    protected $guarded = [];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }


}
