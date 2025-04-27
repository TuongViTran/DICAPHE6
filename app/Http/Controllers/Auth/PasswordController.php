<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    // Hàm để cập nhật mật khẩu
    public function update(Request $request)
    {
        // Validate input
        $request->validate([
            'current_password' => 'required', // Mật khẩu hiện tại phải có
            'password' => 'required|confirmed|min:8', // Mật khẩu mới phải có và xác nhận mật khẩu
        ]);

        // Lấy người dùng hiện tại
        $user = Auth::user();

        // Kiểm tra mật khẩu hiện tại có đúng không
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
        }

        // Cập nhật mật khẩu mới
        $user->password = Hash::make($request->password);
        $user->save();

        // Trả về thông báo thành công
        return back()->with('status', 'Mật khẩu đã được cập nhật thành công.');
    }
}

