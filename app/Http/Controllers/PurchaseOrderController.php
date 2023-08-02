<?php

namespace App\Http\Controllers;

use App\Mail\LowQuantityEmail;
use App\Models\Inventory;
use App\Models\InventoryItem;
use App\Models\Item;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class PurchaseOrderController extends Controller
{

    public function index()
    {

        $cartItems = session('cart', []);

        $purchaseOrders = PurchaseOrder::all();


//        session()->forget('cart');

        return view('purchase_orders.index', compact('purchaseOrders', 'cartItems'));
    }

    public function create()
    {
        $items = Item::all();
        $inventories = Inventory::all();
        return view('purchase_orders.create', compact('items', 'inventories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id', // Add the validation for user_id
            'item_id' => 'required|exists:items,id',
            'inventory_id' => 'required|exists:inventories,id',
            'status' => 'in:1,2',
        ]);

//        $userId = Auth::id(); // Get the authenticated user's ID

        $data = $request->all();
//        $data['user_id'] = $userId;

        PurchaseOrder::create($data);

        return redirect()->route('purchase_orders.index')->with('success', 'Purchase order created successfully.');
    }

//    public function store(Request $request)
//    {
//        $request->validate([
//            'item_id' => 'required|exists:items,id',
//        ]);
//
//        $item = Item::find($request->item_id);
//
//        if (!$item) {
//            return redirect()->back()->with('error', 'Item not found.');
//        }
//
//        // Check if the item is marked as stop_purchasing
//        if ($item->stop_purchasing) {
//            return redirect()->back()->with('error', 'Item is not available for purchase.');
//        }
//
//        // Choose the inventory with the largest quantity of the item
//        $largestInventory = InventoryItem::where('item_id', $item->id)->orderBy('quantity', 'desc')->first();
//
//        // Check if the item quantity is less than 50 in all inventories
//        $allInventories = InventoryItem::where('item_id', $item->id)->get();
////        $isLowQuantity = $allInventories->every(function ($inventory) {
////            return $inventory->quantity < 50;
////        });
//
////        if ($isLowQuantity) {
////            // Send an email to the vendor
////            // Implement your email sending logic here, e.g., using Laravel Mail class
////            Mail::to($item->vendor->email)->send(new LowQuantityEmail($item));
////        }
//
//        // Create the purchase order with stop_purchasing set to false and user_id set to the authenticated user
//         PurchaseOrder::create([
//            'user_id' => Auth::id(),
//            'status' => 'in:1,2', // or 'delivered', depending on your logic
//            'item_id' => $item->id,
//            'inventory_id' => $largestInventory->inventory_id,
//            'stop_purchasing' => $item->stop_purchasing,
//        ]);
//
//        return redirect()->back()->with('success', 'Purchase order created successfully.');
//    }


    public function edit(PurchaseOrder $purchaseOrder)
    {
        // Retrieve related models if needed
        $item = $purchaseOrder->item;
        $inventory = $purchaseOrder->inventory;
        return view('purchase_orders.edit', compact('purchaseOrder', 'item', 'inventory'));
    }

    public function update(Request $request, PurchaseOrder $purchaseOrder)
    {
        // Validate the request data if needed

        // Update the purchase order
        $purchaseOrder->update([
            'status' => $request->status, // or any other fields to update
        ]);

        return redirect()->route('purchase_orders.index')->with('success', 'Purchase order updated successfully.');
    }

    public function destroy(PurchaseOrder $purchaseOrder)
    {
        // Delete the purchase order
        $purchaseOrder->delete();

        return redirect()->route('purchase_orders.index')->with('success', 'Purchase order deleted successfully.');
    }


    public function createPurchaseOrder(Request $request)
    {
        $cartItems = session('cart', []);
        if (empty($cartItems)) {
            return redirect()->route('cart.show')->with('error', 'Cart is empty. Please add items to the cart before making a purchase.');
        }

        // Check item quantities in the cart against the inventories
        foreach ($cartItems as $cartItem) {
            $item = Item::find($cartItem['item_id']);
            $quantity = $cartItem['quantity'];
            if (!$item) {
                return redirect()->route('cart.show')->with('error', 'Item not found in the cart.');
            }

            // Check if the item is marked as stop_purchasing
            if ($item->stop_purchasing) {
                return redirect()->route('cart.show')->with('error', 'Item "' . $item->name . '" is not available for purchase.');
            }

            // Choose the inventory with the largest quantity of the item
            $largestInventory = InventoryItem::where('item_id', $item->id)->orderBy('quantity', 'desc')->first();

            if (!$largestInventory) {
                return redirect()->route('cart.show')->with('error', 'Inventory for item "' . $item->name . '" not found.');
            }

            // Check if the item quantity is less than 50 in any inventory
            $hasLowQuantity = InventoryItem::where('item_id', $item->id)
                ->where('quantity', '<', 50)
                ->exists();

            if ($hasLowQuantity) {
                $vendor = $item->vendor()->first();
                if ($vendor) {
                    Mail::to($vendor->email)->send(new LowQuantityEmail($item, $vendor));
                } else {
                    return redirect(view('welcome'));
                }
            } else {
                $purchaseOrder = PurchaseOrder::where('user_id', auth()->user()->id)
                    ->where('item_id', $item->id)
                    ->where('inventory_id', $largestInventory->inventory_id)
                    ->first();

                if ($purchaseOrder) {
                    // Purchase order record already exists, update the quantity
                    return redirect()->route('purchase_orders.index', compact('quantity'))->with('success', 'Purchase order created successfully.');

                } else {

                    // Create the purchase order for each item in the cart
                    PurchaseOrder::create([
                        'user_id' => auth()->user()->id, // Assuming there's an authenticated user, adjust this as needed
                        'status' => '1', // or 'delivered', depending on your logic
                        'item_id' => $item->id,
                        'inventory_id' => $largestInventory->inventory_id,
                    ]);
                }
            }


        }
        // Clear the cart after the purchase is done
//        $request->session()->forget('cart');

        return redirect()->route('purchase_orders.index', compact('quantity'))->with('success', 'Purchase order created successfully.');
    }

//    public function createPurchaseOrder(Request $request)
//    {
//        $cartItems = session('cart', []);
//        if (empty($cartItems)) {
//            return redirect()->route('cart.show')->with('error', 'Cart is empty. Please add items to the cart before making a purchase.');
//        }
//
//        $vendors = collect();
//
//        foreach ($cartItems as $cartItem) {
//            $item = Item::find($cartItem['item_id']);
//            $quantity = $cartItem['quantity'];
//            if (!$item) {
//                return redirect()->route('cart.show')->with('error', 'Item not found in the cart.');
//            }
//
//            if ($item->stop_purchasing) {
//                return redirect()->route('cart.show')->with('error', 'Item "' . $item->name . '" is not available for purchase.');
//            }
//
//            // Find the inventory with the largest quantity of the item
//            $largestInventory = InventoryItem::where('item_id', $item->id)
//                ->orderBy('quantity', 'desc')
//                ->first();
//
//            if (!$largestInventory) {
//                return redirect()->route('cart.show')->with('error', 'Inventory for item "' . $item->name . '" not found.');
//            }
//
//            // Check if the item quantity is less than 50 in any inventory
//            $hasLowQuantity = InventoryItem::where('item_id', $item->id)
//                ->where('quantity', '<', 50)
//                ->exists();
//
//            if ($hasLowQuantity) {
//                // Add the vendors of items with low quantity to the collection
//                $vendors = $vendors->merge($item->vendors);
//            }
//
//            // Create the purchase order for each item in the cart
//            PurchaseOrder::create([
//                'user_id' => auth()->user()->id,
//                'status' => '1', // or 'delivered', depending on your logic
//                'item_id' => $item->id,
//                'inventory_id' => $largestInventory->inventory_id,
//                'quantity' => $quantity,
//            ]);
//        }
//
//        // Send email to vendors with low quantity items
//        if ($vendors->isNotEmpty()) {
//            Mail::to($vendors->pluck('email'))->send(new LowQuantityEmail($item, $vendors));
//        } else {
//            return Redirect::to('welcome');
//        }
//
//        // Clear the cart after the purchase is done
//        // $request->session()->forget('cart');
//
//        return redirect()->route('purchase_orders.index')->with('success', 'Purchase order created successfully.');
//    }
}
