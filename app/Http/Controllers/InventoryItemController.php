<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryItem;
use App\Models\Item;
use Illuminate\Http\Request;

class InventoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventoryItems = InventoryItem::all();
        return view('inventory_items.index', compact('inventoryItems'));    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::all();
        $inventories = Inventory::all();
        return view('inventory_items.create', compact('items', 'inventories'));
    }

    /**
     * Store a newly created resource in storage.
     */
//    public function store(Request $request)
//    {
//        $request->validate([
//            'item_id' => 'required|exists:items,id',
//            'inventory_id' => 'required|exists:inventories,id',
//            'quantity' => 'required|integer|min:0',
//        ]);
//
//        InventoryItem::create($request->all());
//
//        return redirect()->route('inventory_items.index')->with('success', 'Inventory item created successfully.');
//
//    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'inventory_id' => 'required|exists:inventories,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $existingInventoryItem = InventoryItem::where('item_id', $request->item_id)
            ->where('inventory_id', $request->inventory_id)
            ->first();

        if ($existingInventoryItem) {
            // If the record already exists, update the quantity
            $existingInventoryItem->quantity += $request->quantity;
            $existingInventoryItem->save();
        } else {
            // If the record does not exist, create a new one
            InventoryItem::create($request->all());
        }

        return redirect()->route('inventory_items.index')->with('success', 'Inventory item created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryItem $inventoryItem)
    {
        $items = Item::all();
        $inventories = Inventory::all();
        return view('inventory_items.edit', compact('inventoryItem', 'items', 'inventories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,InventoryItem $inventoryItem)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'inventory_id' => 'required|exists:inventories,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $inventoryItem->update($request->all());

        return redirect()->route('inventory_items.index')->with('success', 'Inventory item updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryItem $inventoryItem)
    {
        $inventoryItem->delete();

        return redirect()->route('inventory_items.index')->with('success', 'Inventory item deleted successfully.');
    }
}
