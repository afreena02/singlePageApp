<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $user = User::all();
        // return response()->json($user);
        return view('user-list');
    }

    public function getUsers()
    {
        $users = User::with('role')->select('id', 'first_name', 'last_name', 'email', 'image_url', 'position', 'role_id')
            ->orderBy('first_name')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->first_name . ' ' . $user->last_name, // Fix name
                    'email' => $user->email,
                    'photo_url' => $user->image_url ? config('app.base_url') . '/storage/' . $user->image_url : asset('images/default-avatar.jpg'),
                    'image_url' => $user->image_url,
                    'position' => $user->position,
                    'role' => $user->role ? $user->role->title : 'N/A' // Fix role
                ];
            });

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'position' => 'required|string|max:255',
            'role_id' => 'required|integer|exists:roles,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        $imagePath = null;
        if ($request->hasFile('photo')) {
            $imagePath = $request->file('photo')->store('user_images', 'public');
        }

        // Create user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'position' => $request->position,
            'role_id' => $request->role_id,
            'image_url' => $imagePath,
        ]);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json([
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::findOrFail($id);

        // Handle image update
        if ($request->hasFile('photo')) {
            if ($user->image_url) {
                Storage::disk('public')->delete($user->image_url);
            }
            $user->image_url = $request->file('photo')->store('user_images', 'public');
        }

        // Update user details
        $data = [
            'first_name' => $request->first_name ?? $user->first_name,
            'last_name' => $request->last_name ?? $user->last_name,
            'email' => $request->email ?? $user->email,
            'position' => $request->position ?? $user->position,
            'role_id' => $request->role_id ?? $user->role_id,
            'image_url' => $user->image_url,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->image_url) {
            Storage::disk('public')->delete($user->image_url);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
