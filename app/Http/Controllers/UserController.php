<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Owner;
use App\Models\Review;
use App\Models\Post;
use App\Models\CoffeeShop;



class UserController extends Controller
{
    
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $users = User::withCount('posts')
            ->when($search, function ($query, $search) {
                return $query->where('full_name', 'like', '%' . $search . '%');
            })
            ->orderByRaw("FIELD(role, 'admin') DESC") // Ưu tiên admin lên đầu
            ->orderBy('created_at', 'desc')           // Mới đăng ký ở dưới admin
            ->paginate(40); 
    
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
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra ảnh
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
        $user->gender = $request->gender;
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
    
        // Xử lý ảnh đại diện nếu có upload
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = uniqid('avatar_') . '.' . $avatar->getClientOriginalExtension();
            // Lưu ảnh vào thư mục uploads/avatars
            $path = $avatar->storeAs('uploads/avatars', $filename, 'public');
            // Lưu đường dẫn vào DB
            $user->avatar_url = $path;
        }
    
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
   public function latestUsers()
{
    $latestUsers = User::whereIn('role', ['user', 'owner'])
                       ->orderBy('created_at', 'desc')
                       ->take(4)
                       ->get();

    return view('backend.admin.latest_users', compact('latestUsers'));
}

public function update(Request $request, User $user)
{
    // Xác thực dữ liệu
    $request->validate([
        'full_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        'phone' => 'nullable|string|max:15',
        'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra ảnh nếu có
        'gender' => 'nullable|in:male,female,other',
        'role' => 'required|in:admin,owner,user',
    ]);

    // Cập nhật thông tin người dùng
    $user->full_name = $request->full_name;
    $user->email = $request->email;
    $user->phone = $request->phone;
    $user->gender = $request->gender;
    $user->role = $request->role;

    // Cập nhật avatar nếu có
    if ($request->hasFile('avatar')) {
        // Xóa ảnh cũ nếu có
        if ($user->avatar_url && Storage::disk('public')->exists($user->avatar_url)) {
            Storage::disk('public')->delete($user->avatar_url);
        }

        // Lưu ảnh mới
        $avatar = $request->file('avatar');
        $filename = uniqid('avatar_') . '.' . $avatar->getClientOriginalExtension();
        $path = $avatar->storeAs('uploads/avatars', $filename, 'public');
        $user->avatar_url = $path;
    }

    $user->save();

    return redirect()->route('user.management')->with('success', 'Người dùng đã được cập nhật thành công.');
}

public function destroy(User $user)
{
    // Tắt kiểm tra ràng buộc khóa ngoại tạm thời (nếu cần)
    \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    try {
        // Xóa các bản ghi liên quan trong bảng favoriteshop (nếu có)
        \DB::table('favoriteshop')->where('user_id', $user->id)->delete();

        // Xóa ảnh đại diện nếu có
        if ($user->avatar_url && Storage::disk('public')->exists($user->avatar_url)) {
            Storage::disk('public')->delete($user->avatar_url);
        }

        // Xóa người dùng
        $user->delete();

        // Thông báo thành công
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return redirect()->route('user.management')->with('success', 'Người dùng đã được xóa thành công.');

    } catch (\Exception $e) {
        // Nếu có lỗi, bật lại kiểm tra khóa ngoại và thông báo lỗi
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return redirect()->route('user.management')->with('error', 'Có lỗi xảy ra trong quá trình xóa người dùng. Vui lòng thử lại.');
    }
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
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra ảnh nếu có upload
            'gender' => 'nullable|in:male,female,other',
        ]);
    
        // Cập nhật thông tin cơ bản
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->gender = $request->gender;
    
        // Xử lý ảnh đại diện nếu có upload
        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu có
            if ($user->avatar_url && Storage::disk('public')->exists($user->avatar_url)) {
                Storage::disk('public')->delete($user->avatar_url);
            }
    
            // Lưu ảnh mới
            $avatar = $request->file('avatar');
            $filename = uniqid('avatar_') . '.' . $avatar->getClientOriginalExtension();
            $path = $avatar->storeAs('uploads/avatars', $filename, 'public');
            $user->avatar_url = $path;
        }
    
        $user->save();
    
        return redirect()->route('profile.edit')->with('success', 'Cập nhật hồ sơ thành công.');
    }
    
    
   // Hiển thị thông tin người dùng trên frontend
public function showProfile($id)
{
     // Lấy bài viết cho slider và bài viết thường
     $posts = Post::with('user')
     ->where('status', 'Published')
     ->orderBy('created_at', 'desc')
     ->get();

    // lấy thông tin người dùng
    $user = User::findOrFail($id);
    // Lấy danh sách đánh giá của user
    $reviews = Review::where('user_id', $id)
        ->with('user')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

     // Lấy top 4 quán café hot nhất dựa theo rating trung bình
    $hotCafes = CoffeeShop::with('address')
    ->orderByDesc('reviews_avg_rating')
    ->take(4)
    ->get();

    // Từ danh sách hotCafes, chọn ra các quán có ảnh cover để hiển thị slider
    $sliderPosts = $hotCafes->filter(function ($cafe) {
        return !empty($cafe->cover_image);
    })->values();

    // Lấy các quán đã lưu của user
    $savedShops = $user->favoriteShops()->with('address')->get();

    // Số quán đã lưu từ bảng favoriteshop
    $savedCount = DB::table('favoriteshop')
    ->where('user_id', $user->id)
    ->count();

    // Số đánh giá từ bảng review
    $reviewCount = Review::where('user_id', $user->id)->count();

        return view('frontend.user', compact('user', 'reviews','posts','sliderPosts', 'hotCafes', 'savedShops','savedCount', 'reviewCount'));
    }
}
