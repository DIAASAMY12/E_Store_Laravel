<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return view('brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('brands.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:brands|max:255',
            'notes' => 'nullable|string',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $input = $request->all();

        if ($icon = $request->file('icon')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $icon->getClientOriginalExtension();
            $icon->move($destinationPath, $profileImage);
            $input['icon'] = "$profileImage";
        }

        Brand::create($input);

        return redirect()->route('brands.index')->with('success', 'Brand created successfully.');

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
    public function edit(Brand $brand)
    {
        return view('brands.edit', compact('brand'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|unique:brands,name,' . $brand->id . '|max:255',
            'notes' => 'nullable|string',
            'icon' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $input = $request->all();

        if ($icon = $request->file('icon')) {
            $destinationPath = 'images/';
            $profileImage = date('YmdHis') . "." . $icon->getClientOriginalExtension();
            $icon->move($destinationPath, $profileImage);
            $input['icon'] = "$profileImage";
        } else {
            unset($input['icon']);
        }

        $brand->update($input);

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully.');
    }
}
