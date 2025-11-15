<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Display a listing of roles
     */
    public function index()
    {
        $roles = Role::with('permissions')
            ->latest('created_at')
            ->paginate(15);
        $permissions = Permission::all();
        return view('admin.roles', ['roles' => $roles, 'permissions' => $permissions]);
    }

    /**
     * Store a newly created role
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:roles|max:255',
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'slug' => Str::slug($validated['name']),
        ]);

        if (!empty($request->permissions)) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect('/admin/roles')->with('success', 'Vai trò được tạo thành công');
    }

    /**
     * Update the specified role
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            'description' => 'nullable|string',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'slug' => Str::slug($validated['name']),
        ]);

        if (!empty($request->permissions)) {
            $role->permissions()->sync($request->permissions);
        } else {
            $role->permissions()->detach();
        }

        return redirect('/admin/roles')->with('success', 'Vai trò được cập nhật thành công');
    }

    /**
     * Delete the specified role
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect('/admin/roles')->with('success', 'Vai trò đã được xóa');
    }

    /**
     * Manage permissions
     */
    public function managePermissions()
    {
        $permissions = Permission::latest('created_at')->paginate(15);
        return view('admin.permissions', ['permissions' => $permissions]);
    }

    /**
     * Store a new permission
     */
    public function storePermission(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:permissions|max:255',
            'description' => 'nullable|string',
        ]);

        Permission::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'slug' => Str::slug($validated['name']),
        ]);

        return redirect('/admin/permissions')->with('success', 'Quyền được tạo thành công');
    }

    /**
     * Delete a permission
     */
    public function destroyPermission(Permission $permission)
    {
        $permission->delete();
        return redirect('/admin/permissions')->with('success', 'Quyền đã được xóa');
    }
}
