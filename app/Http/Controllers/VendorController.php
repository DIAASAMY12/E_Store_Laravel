<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
//        $vendors = Vendor::query();
//
//        if ($request->has('name')) {
//            $vendors->filterByName($request->input('name'));
//        }
//
//        if ($request->has('email')) {
//            $vendors->filterByEmail($request->input('email'));
//        }
//
//        $vendors = $vendors->paginate(10);
//
//        return view('vendors.index', compact('vendors'));


        $vendors = Vendor::all();
        return view('vendors.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vendors.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'is_active' => 'in:0,1',
            'phone' => 'required',
        ]);
//        dd($request->all());
        $input=$request->all();

        Vendor::create($input);

        // You can also add the address for the vendor here if needed
        // For example: $vendor->addresses()->create([...]);

        return redirect()->route('vendors.index')->with('success', 'Vendor created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vendor $vendor)
    {
        return view('vendors.edit', compact('vendor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vendor $vendor)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'is_active' => 'in:0,1',
            'phone' => 'required',
        ]);

        $vendor->update($validatedData);

        return redirect()->route('vendors.index')->with('success', 'Vendor updated successfully.');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return redirect()->route('vendors.index')->with('success', 'Vendor deleted successfully.');
    }
}
