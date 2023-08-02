<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Vendor;
use App\Models\VendorItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendorItems = VendorItem::all();
        return view('vendor_items.index', compact('vendorItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vendors = Vendor::all();
        $items = Item::all();
        return view('vendor_items.create', compact('vendors', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:0',
        ]);
        $quantity = $request->quantity;

        // Find the existing VendorItem record
        $existingVendorItem = VendorItem::where('vendor_id', $request->vendor_id)
            ->where('item_id', $request->item_id)
            ->first();

        if ($existingVendorItem) {
            // Update the quantity if the record exists
            VendorItem::where('vendor_id', $request->vendor_id)
                ->where('item_id', $request->item_id)
                ->update(['quantity' => DB::raw('quantity + ' . $quantity)]);
        } else {
            // Create a new VendorItem record if it doesn't exist
            VendorItem::create($request->all());
        }

        return redirect()->route('vendor_items.index')->with('success', 'Vendor item created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VendorItem $vendorItem)
    {
        $vendors = Vendor::all();
        $items = Item::all();
        return view('vendor_items.edit', compact('vendorItem', 'vendors', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VendorItem $vendorItem)
    {
        $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:0',
        ]);

        $vendorItem->update($request->all());

        return redirect()->route('vendor_items.index')->with('success', 'Vendor item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VendorItem $vendorItem)
    {
        $vendorItem->delete();

        return redirect()->route('vendor_items.index')->with('success', 'Vendor item deleted successfully.');
    }
}
