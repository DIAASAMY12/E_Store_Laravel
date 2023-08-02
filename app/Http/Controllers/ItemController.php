<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Inventory;
use App\Models\InventoryItem;
use App\Models\Item;
use App\Models\Vendor;
use App\Models\VendorItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $brands = Brand::all();
        $vendors = Vendor::all();
        $inventories = Inventory::all();
//        $inventoriesItem = InventoryItem::all();


        $query = Item::query();

        if ($request->has('brand')) {
            $query->byBrand($request->input('brand'));
        }

        if ($request->has('vendor')) {
            $vendorId = $request->input('vendor');
            $query->byVendor($vendorId);
        }

        if ($request->has('inventory')) {
            $inventoryId = $request->input('inventory');
            $query->byInventoryItem($inventoryId);
        }


//        $query->byTotalQuantity(50);


        $items = $query->get();
//        dd($query->toSql(), $query->getBindings());
        return view('items.index', compact('items', 'brands', 'vendors', 'inventories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::all();
        return view('items.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        $request->validate([
//            'name' => [
//                'required',
//                'string',
//                'max:255',
//                'unique:items,name,id,brand_id,' . request()->input('brand_id'),
//            ],
//            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
//            'brand_id' => 'required|exists:brands,id',
//            'is_active' => 'required|boolean',
//        ]);
//
//        $input = $request->all();
//
//        if ($image = $request->file('image')) {
//            $destinationPath = 'imagesItems/';
//            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
//            $image->move($destinationPath, $profileImage);
//            $input['image'] = "$profileImage";
//        }
//
//        Item::create($input);
//
//        return redirect()->route('items.index')->with('success', 'Item created successfully.');

//        $validatedData = $request->validate($this->validationRules());


//        if ($image = $request->file('image')) {
//            $destinationPath = 'imagesItems/';
//            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
//            $image->move($destinationPath, $profileImage);
//            $input['image'] = "$profileImage";
//        }


//        Item::create([
//            'name' => $validatedData['name'],
//            'brand_id' => $validatedData['brand_id'],
//            'image' => $request->file('image') ? $request->file('image')->store('public/imagesItems/') : null,
//            'is_active' => $request->input('is_active', true),
//        ]);
//
//
//
//
//
//        // If you want to create related records in ItemInventory and ItemVendor
////        $item->inventories()->create(['quantity' => 0]);
////        $item->vendors()->create(['quantity' => 0]);
//
//        return redirect()->route('items.index')->with('success', 'Item created successfully.');


        $validator = Validator::make($request->all(), $this->validationRules());

        if ($validator->fails()) {
            return redirect()->route('items.create')
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('item_images', 'public');
            info('Image path before saving: ' . $filePath);
        }

        $itemData = $validator->validated();

        $itemData['image'] = $request->file('image') ? $request->file('image')->store('item_images') : null;

        $item = Item::create($itemData);

        // If you want to create related records in ItemInventory and ItemVendor
//        $item->inventories()->create(['quantity' => 0]);
//        $item->vendors()->create(['quantity' => 0]);

        return redirect()->route('items.index')->with('success', 'Item created successfully.');

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
    public function edit(Item $item)
    {
        $brands = Brand::all();
        return view('items.edit', compact('item', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
//        $validatedData = $request->validate($this->validationRules($item->id));
//
//        $item->update([
//            'name' => $validatedData['name'],
//            'brand_id' => $validatedData['brand_id'],
//            'image' => $request->file('image') ? $request->file('image')->store('imagesItems') : $item->image,
//            'is_active' => $request->input('is_active', false),
//        ]);
//
////        $input = $request->all();
////
////        if ($image = $request->file('image')) {
////            $destinationPath = 'imagesItems/';
////            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
////            $image->move($destinationPath, $profileImage);
////            $input['image'] = "$profileImage";
////        } else {
////            unset($input['image']);
////        }
//
////        $item->update($input);
//        return redirect()->route('items.index')->with('success', 'Item updated successfully.');

        $validator = Validator::make($request->all(), $this->validationRules($item->id));

        if ($validator->fails()) {
            return redirect()->route('items.edit', $item)
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('item_images', 'public');
            info('Image path before saving: ' . $filePath);
        }

        $itemData = $validator->validated();

        if ($request->hasFile('image')) {
            // Delete the old image file
            if ($item->image) {
                Storage::delete($item->image);
            }

            $itemData['image'] = $request->file('image')->store('item_images');
        }

        $item->update($itemData);

        return redirect()->route('items.index')->with('success', 'Item updated successfully.');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }

    private function validationRules($id = null)
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:items,name,' . ($id ? $id . ',id' : 'NULL,id') . ',brand_id,' . request()->input('brand_id'),
            ],
            'image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'brand_id' => 'required|exists:brands,id',
            'is_active' => 'required|boolean',
        ];
    }

    public function addToCart(Request $request, $id)
    {
        $item = Item::find($id);
        $inventoryItem = InventoryItem::where('item_id', $item->id)->first();
        if (!$item) {
            return redirect()->route('items.index')->with('error', 'Item not found.');
        }

        $quantity = $request->input('quantity');

        if ($quantity < $inventoryItem->quantity) {
            $cart = $request->session()->get('cart', []);

            // Check if the item with the same ID already exists in the cart
            $itemIndex = null;
            foreach ($cart as $index => $cartItem) {
                if ($cartItem['item_id'] === $item->id) {
                    $itemIndex = $index;
                    break;
                }
            }

            if ($itemIndex !== null) {
                // Item with the same ID already exists in the cart, update the quantity
                $cart[$itemIndex]['quantity'] += $quantity;
            } else {
                // Item does not exist in the cart, add it as a new entry
                $cart[] = [
                    'item_id' => $item->id,
                    'name' => $item->name,
                    'quantity' => $quantity,
                    'created_at' => now(),
                ];
            }

            $item->total_purchases += $quantity;
            $item->save();


            $inventoryItem->quantity -= $quantity;
            $inventoryItem->save();

            $request->session()->put('cart', $cart);

            return redirect()->route('items.index')->with('success', 'Item added to cart successfully.');

        } else {
            return redirect()->route('items.index')->with('error', 'Not enough quantity in inventory.');

        }

    }


}
