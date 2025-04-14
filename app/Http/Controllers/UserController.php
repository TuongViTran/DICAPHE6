<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
<<<<<<< HEAD
=======
use App\Models\Owner;
use App\Models\Review;

>>>>>>> 3d75ae53fdadd370c08c1ad73d8d9c740002a634

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
    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:15',
            'avatar' => 'required|string', // Kiểm tra trường avatar
            'gender' => 'nullable|in:male,female,other',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);
    
        // Tạo người dùng mới
        $user = new User();
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); // Mã hóa mật khẩu
        $user->phone = $request->phone;
        $user->avatar_url = $request->avatar; // Lưu tên file ảnh vào cột avatar_url
        $user->gender = $request->gender;
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
    
        // Lưu người dùng vào cơ sở dữ liệu
        $user->save();
    
        return redirect()->route('user.management')->with('success', 'Người dùng đã được thêm thành công.');
    }

    // Hiển thị form chỉnh sửa người dùng
    public function edit(User $user)
    {
        return view('backend.admin.edit_user', compact('user')); // Tạo view cho form chỉnh sửa
    }

    // Cập nhật thông tin người dùng
   // Cập nhật thông tin người dùng
public function update(Request $request, User $user)
{
    // Xác thực dữ liệu
    $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'phone' => 'nullable|string|max:15',
        'avatar' => 'nullable|string', // Chỉ cần xác thực là chuỗi
        'gender' => 'nullable|in:male,female,other',
        'role' => 'required|in:admin,owner,user',
    ]);

    // Cập nhật thông tin người dùng
    $user->full_name = $request->full_name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->gender = $request->gender;
    $user->role = $request->role;

    // Xử lý ảnh đại diện nếu có
    if ($request->has('avatar') && $request->avatar) {
        // Xóa ảnh cũ nếu có
        if ($user->avatar_url) {
            Storage::disk('public')->delete($user->avatar_url);
        }
        // Cập nhật tên file ảnh đại diện mới
        $user->avatar_url = $request->avatar; // Lưu tên file ảnh mới
    }

    // Lưu thay đổi vào cơ sở dữ liệu
    $user->save();

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

    // Hiển thị form chỉnh sửa hồ sơ người dùng đang đăng nhập
    public function editProfile()
    {
        $user = Auth::user(); // Lấy thông tin người dùng đang đăng nhập
        return view('profile.edit', compact('user')); // Hiển thị trang chỉnh sửa hồ sơ
    }

    // Cập nhật hồ sơ người dùng đang đăng nhập
    public function updateProfile(Request $request)
    {
        $user = Auth::user(); // Lấy thông tin người dùng hiện tại

        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gender' => 'nullable|in:male,female,other', // Xác thực giới tính
        ]);

        // Cập nhật thông tin người dùng
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->gender = $request->gender; // Cập nhật giới tính

        // Xử lý ảnh đại diện nếu có
        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu có
            if ($user->avatar_url) {
                Storage::disk('public')->delete($user->avatar_url);
            }
            // Lưu tên file mà không có đường dẫn
            $user->avatar_url = $request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->storeAs('', $user->avatar_url, 'public'); // Lưu ảnh vào thư mục mà không có đường dẫn
        }

        // Lưu thay đổi vào cơ sở dữ liệu
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Cập nhật hồ sơ thành công.');
    }
<<<<<<< HEAD

    // Hiển thị thông tin người dùng trên frontend
    public function showProfile($id)
    {
        $user = User::findOrFail($id);
        return view('frontend.user', compact('user'));
    }
=======
    // User frontend function
        public function showProfile($id)
        {
            $user = \App\Models\User::findOrFail($id);
            $reviews = Review::where('user_id', $id)
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('frontend.user', compact('user','reviews'));
        }
        
        
    
>>>>>>> 3d75ae53fdadd370c08c1ad73d8d9c740002a634
}