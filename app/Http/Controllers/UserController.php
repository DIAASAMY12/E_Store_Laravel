<?php

namespace App\Http\Controllers;

use App\Jobs\SendUserEmail;
use App\Models\User;
use App\Repositories\AddressRepository;
use App\Repositories\UserRepository;
use App\Support\CounterService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

//    protected $userRepository;
//    protected $addressRepository;
//
//    public function __construct(UserRepository $userRepository, AddressRepository $addressRepository)
//    {
//        $this->userRepository = $userRepository;
//        $this->addressRepository = $addressRepository;
//    }


    public function useCounter(CounterService $counter)
    {
//        sing
        $value1 = app('test1')->increment();
        $value2 = app('test1')->increment();
        $value3 = app('test1')->increment();
//         bind
        $value4 = app('test2')->increment();
        $value5 = app('test2')->increment();
        $value6 = app('test2')->increment();

        return view('users.counter', [
            'values' => [
                'value1' => $value1,
                'value2' => $value2,
                'value3' => $value3,
                'value4' => $value4,
                'value5' => $value5,
                'value6' => $value6,
            ]
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
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

        $input = $request->all();

        User::create($input);

        return redirect()->route('dashboard')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($userId)
    {
//        // Retrieve the user using the UserRepository
//        $user = $this->userRepository->find($userId);
//
//        // Retrieve the user's address using the AddressRepository
//        $address = $this->addressRepository->findByUserId($userId);
//
//        return view('users.show', compact('user', 'address'));
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


    public function sendEmail(User $user)
    {
        // Dispatch the SendUserEmail job to send the email
        SendUserEmail::dispatch($user);
        return redirect()->back()->with('success', 'Email sent successfully.');
    }

}
