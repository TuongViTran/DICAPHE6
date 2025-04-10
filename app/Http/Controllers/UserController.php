<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Owner;
use App\Models\Review;


class UserController extends Controller
{
    // Hiển thị danh sách người dùng
    public function index()
    {
        $users = User::withCount('posts')->get(); // Lấy tất cả người dùng cùng với số bài viết
        return view('backend.admin.user_management', compact('users'));
    }

    // Hiển thị form thêm mới người dùng
    public function create()
    {
        return view('backend.admin.create_user'); // Tạo view cho form thêm mới
    }

    // Lưu người dùng mới
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:15',
            'account_type' => 'required|in:user,owner,admin',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Thêm quy tắc cho ảnh
        ]);

        // Tạo người dùng mới
        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone' => $request->phone,
            'account_type' => $request->account_type,
        ]);

        // Xử lý ảnh đại diện nếu có
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public'); // Lưu ảnh vào thư mục public/avatars
            $user->avatar_url = $path; // Cập nhật đường dẫn ảnh vào model
            $user->save(); // Lưu thay đổi
        }

        return redirect()->route('user.management')->with('success', 'Người dùng đã được thêm thành công.');
    }

    // Hiển thị form chỉnh sửa người dùng
    public function edit(User $user)
    {
        return view('backend.admin.edit_user', compact('user')); // Tạo view cho form chỉnh sửa
    }

    // Cập nhật người dùng
    public function update(Request $request, User $user)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'account_type' => 'required|in:user,owner,admin',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Thêm quy tắc cho ảnh
        ]);

        // Cập nhật thông tin người dùng
        $user->update($request->only('full_name', 'email', 'phone', 'account_type'));

        // Xử lý ảnh đại diện nếu có
        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu có
            if ($user->avatar_url) {
                Storage::disk('public')->delete($user->avatar_url);
            }
            $path = $request->file('avatar')->store('avatars', 'public'); // Lưu ảnh vào thư mục public/avatars
            $user->avatar_url = $path; // Cập nhật đường dẫn ảnh vào model
            $user->save(); // Lưu thay đổi
        }

        return redirect()->route('user.management')->with('success', 'Người dùng đã được cập nhật thành công.');
    }

    // Xóa người dùng
    public function destroy(User $user)
    {
        // Xóa ảnh đại diện nếu có
        if ($user->avatar_url) {
            Storage::disk('public')->delete($user->avatar_url);
        }
        $user->delete();
        return redirect()->route('user.management')->with('success', 'Người dùng đã được xóa thành công.');
    }

    // Hiển thị thông tin người dùng
    public function show(User $user)
    {
        return view('backend.admin.show_user', compact('user')); // Tạo view cho thông tin người dùng
    }
    public function editProfile()
    {
        $user = Auth::user(); // Lấy thông tin người dùng đang đăng nhập
        return view('profile.edit', compact('user')); // Hiển thị trang chỉnh sửa hồ sơ
    }
    
    public function updateProfile(Request $request)
    {
        $user = Auth::user(); // Lấy thông tin người dùng hiện tại
    
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        dd($user);
        // Cập nhật thông tin người dùng
        $user->update( $request->only('full_name', 'email', 'phone'));
    
        // Xử lý ảnh đại diện nếu có
        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu có
            if ($user->avatar_url) {
                Storage::disk('public')->delete($user->avatar_url);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar_url = $path;
            $user->save();
        }
    
        return redirect()->route('profile.edit')->with('success', 'Cập nhật hồ sơ thành công.');
    }
    // User frontend function
        public function showProfile($id)
        {
            $user = \App\Models\User::findOrFail($id);
            $reviews = Review::with('user')->orderBy('created_at', 'desc')->paginate(10);

            return view('frontend.user', compact('user','reviews'));
        }
        
        
    
}