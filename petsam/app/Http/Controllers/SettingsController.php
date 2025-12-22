<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show settings page
     */
    public function index()
    {
        $user = Auth::user();
        return view('home.settings.index', compact('user'));
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Vui lòng nhập tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã được sử dụng',
        ]);

        /** @var User $user */
        $user = Auth::user();
        if ($user) {
            $user->update($request->only(['name', 'email', 'phone', 'address']));
        }

        return back()->with('success', 'Cập nhật hồ sơ thành công');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'password.required' => 'Vui lòng nhập mật khẩu mới',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (!$user || !Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Đổi mật khẩu thành công');
    }

    /**
     * Delete account
     */
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'confirm' => 'required|in:yes',
        ], [
            'password.required' => 'Vui lòng nhập mật khẩu',
            'confirm.required' => 'Vui lòng xác nhận',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Mật khẩu không đúng']);
        }

        Auth::logout();
        $user->delete();

        return redirect('/')->with('success', 'Tài khoản đã được xóa');
    }
}
