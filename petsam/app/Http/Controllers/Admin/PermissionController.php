<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the permissions.
     */
    public function index()
    {
        $permissions = Permission::with('roles')
                                ->orderBy('created_at', 'desc')
                                ->paginate(10);
        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new permission.
     */
    public function create()
    {
        return view('admin.permissions.create');
    }

    /**
     * Store a newly created permission in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:permissions|alpha_dash|max:255',
            'display_name' => 'required|max:255',
            'description' => 'nullable|max:1000',
        ]);

        Permission::create($validated);

        return redirect()->route('admin.permissions.index')->with('success', 'Quyền hạn đã được tạo thành công!');
    }

    /**
     * Show the form for editing the specified permission.
     */
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified permission in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id . '|alpha_dash|max:255',
            'display_name' => 'required|max:255',
            'description' => 'nullable|max:1000',
        ]);

        $permission->update($validated);

        return redirect()->route('admin.permissions.index')->with('success', 'Quyền hạn đã được cập nhật thành công!');
    }

    /**
     * Remove the specified permission from storage.
     */
    public function destroy(Permission $permission)
    {
        if ($permission->roles()->exists()) {
            return redirect()->route('admin.permissions.index')->with('error', 'Không thể xóa quyền hạn này vì đã được gán cho các vai trò!');
        }

        $permission->delete();
        return redirect()->route('admin.permissions.index')->with('success', 'Quyền hạn đã được xóa thành công!');
    }

    /**
     * Search permissions by name
     */
    public function search()
    {
        $query = request('q');
        $permissions = Permission::where('display_name', 'like', "%{$query}%")
                                ->orWhere('name', 'like', "%{$query}%")
                                ->select('id', 'name', 'display_name', 'description')
                                ->limit(20)
                                ->get();
        
        return response()->json($permissions);
    }
}
