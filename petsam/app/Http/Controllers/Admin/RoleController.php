<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the roles.
     */
    public function index()
    {
        $roles = Role::with(['permissions', 'users'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles|alpha_dash|max:255',
            'display_name' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create($validated);
        
        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Vai trò đã được tạo thành công!');
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('display_name')->get();
        $role->load('permissions');
        $rolePermissionIds = $role->permissions()->pluck('id')->toArray();
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissionIds'));
    }

    /**
     * Update the specified role in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id . '|alpha_dash|max:255',
            'display_name' => 'required|max:255',
            'description' => 'nullable|max:1000',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update($validated);
        
        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        } else {
            $role->permissions()->detach();
        }

        // Clear cache after update
        cache()->forget('role_permissions_' . $role->id);

        return redirect()->route('admin.roles.index')->with('success', 'Vai trò đã được cập nhật thành công!');
    }

    /**
     * Remove the specified role from storage.
     */
    public function destroy(Role $role)
    {
        if ($role->users()->exists()) {
            return redirect()->route('admin.roles.index')->with('error', 'Không thể xóa vai trò này vì có người dùng đang sử dụng!');
        }

        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Vai trò đã được xóa thành công!');
    }
}
