<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index()
    {
        $users = User::with('role')->paginate(15);
        $roles = Role::all();
        return view('admin.users', ['users' => $users, 'roles' => $roles]);
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        User::create($validated);
        
        return redirect('/admin/users')->with('success', 'Người dùng được tạo thành công');
    }

    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        $user->load('orders');
        return view('admin.users.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the user
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', ['user' => $user]);
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'role_id' => 'required|exists:roles,id',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8']);
            $validated['password'] = bcrypt($request->password);
        }

        $user->update($validated);
        return redirect("/admin/users")->with('success', 'Người dùng được cập nhật thành công');
    }

    /**
     * Delete the specified user
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/admin/users')->with('success', 'Người dùng đã được xóa');
    }

    /**
     * Get user permissions (API endpoint for modal)
     */
    public function getPermissions(User $user)
    {
        $permissions = Permission::all();
        $userPermissions = $user->permissions()->pluck('id')->toArray();
        
        return response()->json([
            'permissions' => $permissions,
            'userPermissions' => $userPermissions,
        ]);
    }

    /**
     * Update user permissions (direct assignment)
     */
    public function updatePermissions(Request $request, User $user)
    {
        $validated = $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        // Sync permissions
        $permissions = $validated['permissions'] ?? [];
        $user->permissions()->sync($permissions);

        return redirect('/admin/users')->with('success', 'Quyền của người dùng được cập nhật thành công');
    }
}
