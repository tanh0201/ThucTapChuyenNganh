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
    return $user->role === 'admin';
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
    return $user->role === $role;
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

    // Only admin has all permissions
    if ($user->role === 'admin') {
        return true;
    }

    return false;
}
