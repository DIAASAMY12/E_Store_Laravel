<?php

namespace UserModule\app\Http\Controllers;


use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserModule\app\Http\Resources\UserResource;
use UserModule\app\Models\Address;
use UserModule\app\Models\User;

class UserControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->diaaJson(UserResource::collection($users));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userData = $request->only(['username', 'email', 'first_name', 'last_name', 'is_admin', 'is_active', 'password']);

        $user = User::create($userData);

        $addressData = $request->only(['city_id', 'district', 'street', 'phone']);
        $address = new Address($addressData);
        $user->addresses()->save($address);

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $userData = $request->only(['username', 'email', 'first_name', 'last_name', 'is_admin', 'is_active', 'password']);
        $user->update($userData);

        $addressData = $request->only(['city_id', 'district', 'street', 'phone']);

        if ($user->address) {
            $user->address->update($addressData);
        } else {
            $address = new Address($addressData);
            $user->addresses()->save($address);
        }

        return response()->json([
            'user' => new UserResource($user),
            'message' => 'User and address updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($userId)
    {
        try {
            $user = User::findOrFail($userId);

            if ($user->address) {
                $user->addresses()->delete();
            }

            $user->delete();
            return response()->json(['message' => 'delete done'], 201);
        } catch (\Exception $e) {
            throw new CustomException();
        }
    }
}
