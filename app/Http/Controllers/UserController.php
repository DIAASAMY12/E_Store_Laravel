<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
//        $users = User::latest()->paginate(10);
//        return view('users.index', compact('users'))->with('i', (request()->input('page', 1) - 1) * 5);


//        $query = User::query();
//
//        // Check for username filter
//        if ($request->has('username')) {
//            $query->where('username', 'like', '%' . $request->input('username') . '%');
//        }
//
//        // Check for email filter
//        if ($request->has('email')) {
//            $query->where('email', 'like', '%' . $request->input('email') . '%');
//        }
//
//        // Check for name filter
//        if ($request->has('name')) {
//            $name = $request->input('name');
//            $query->where(function ($query) use ($name) {
//                $query->where('first_name', 'like', '%' . $name . '%')
//                    ->orWhere('last_name', 'like', '%' . $name . '%');
//            });
//        }
//
//        // Check for is_active filter
//        if ($request->has('is_active')) {
//            $query->where('is_active', (int)$request->input('is_active'));
//        }
//
//        // Check for is_admin filter
//        if ($request->has('is_admin')) {
//            $query->where('is_admin', (int)$request->input('is_admin'));
//        }
//
//        // Get the filtered users
//        $users = $query->paginate(10);

        $query = User::query();

        if ($request->has('username')) {
            $query->filterByUsername($request->input('username'));
        }

        if ($request->has('email')) {
            $query->filterByEmail($request->input('email'));
        }

        if ($request->has('name')) {
            $query->filterByName($request->input('name'));
        }

        if ($request->has('is_active')) {
            $query->filterByIsActive($request->input('is_active'));
        }

        if ($request->has('is_admin')) {
            $query->filterByIsAdmin($request->input('is_admin'));
        }


        $users = $query->paginate(10);


        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'username' => 'required|unique:users|min:5',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
            'first_name' => 'nullable|min:3|max:15',
            'is_admin' => 'in:0,1',
            'is_active' => 'in:0,1',
        ]);

//        dd($request->all());

        $input=$request->all();

        User::create($input);

        return redirect()->route('dashboard')->with('success', 'User created successfully.');
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
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => [
                'required',
                'min:5',
                Rule::unique('users')->ignore($id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id),
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
            ],
            'first_name' => 'nullable|min:3|max:15',
            'is_admin' => 'in:0,1',
            'is_active' => 'in:0,1',
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'is_admin' => $request->is_admin,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User soft deleted successfully.');
    }
}
