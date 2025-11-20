<?php

use Illuminate\Support\Facades\Auth;

/**
 * Check if current user is admin
 *
 * @return bool
 */
function is_admin()
{
    if (!Auth::check()) {
        return false;
    }

    $user = Auth::user();
    return $user->role && in_array($user->role->name, ['Admin', 'Editor']);
}

/**
 * Check if current user has a specific role
 *
 * @param  string  $role
 * @return bool
 */
function user_has_role($role)
{
    if (!Auth::check()) {
        return false;
    }

    $user = Auth::user();
    return $user->role && $user->role->name === $role;
}

/**
 * Check if current user has a specific permission
 *
 * @param  string  $permission
 * @return bool
 */
function user_has_permission($permission)
{
    if (!Auth::check()) {
        return false;
    }

    $user = Auth::user();

    // Check role permissions
    if ($user->role && $user->role->permissions()->where('name', $permission)->exists()) {
        return true;
    }

    return false;
}
