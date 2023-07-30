<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventories = Inventory::all();
        return view('inventories.index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $cities = City::all();
        return view('inventories.create', compact('cities'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'phone' => 'required|string',
            'is_active' => 'in:0,1',
        ]);

        Inventory::create($validatedData);

        return redirect()->route('inventories.index')->with('success', 'Inventory created successfully.');


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
    public function edit(Inventory $inventory)
    {
        $cities = City::all();
        return view('inventories.edit', compact('inventory', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'phone' => 'required|string',
            'is_active' => 'in:0,1',
        ]);

        $inventory->update($validatedData);

        return redirect()->route('inventories.index')->with('success', 'Inventory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('inventories.index')->with('success', 'Inventory deleted successfully.');

    }
}
