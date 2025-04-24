<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use GuzzleHttp\Client;

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLoginForm() {
        return view('auth.login');
    }

    // Hiển thị form đăng ký
    public function showRegisterForm() {
        return view('auth.register');
    }

    // Xử lý đăng nhập
    public function login(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Lấy thông tin người dùng đã đăng nhập
            $user = Auth::user();

            // Lấy địa chỉ IP của người dùng
            $ip = $request->ip();

            // Gọi API ipinfo.io để lấy tọa độ
            $client = new Client();
            try {
                $response = $client->get("https://ipinfo.io/{$ip}?token=2956ed85a25bba");
                $data = json_decode($response->getBody(), true);

                // Kiểm tra nếu key 'loc' tồn tại
                if (isset($data['loc'])) {
                    // Lấy tọa độ từ API trả về (vĩ độ và kinh độ)
                    $location = explode(',', $data['loc']);
                    $latitude = $location[0];
                    $longitude = $location[1];
                    // Ghi log giá trị latitude và longitude
                      Log::info('Latitude: ' . $latitude . ' Longitude: ' . $longitude);

                    // Cập nhật tọa độ vào bảng users
                    $user->latitude = $latitude;
                    $user->longitude = $longitude;
                    $user->save();
                }
            } catch (\Exception $e) {
                // Nếu có lỗi khi gọi API, bạn có thể log lỗi hoặc xử lý theo cách khác
                \Log::error("Error fetching location: " . $e->getMessage());
            }

            // Chuyển hướng người dùng theo vai trò
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('dashboard'); // bạn có thể thêm route riêng nếu có
                case 'owner':
                    return redirect()->route('trangchu', ['id' => $user->id]);
                default:
                    return redirect()->route('trangchu', ['id' => $user->id]);
            }
        }

        return back()->withErrors(['email' => 'Thông tin không chính xác.']);
    }

    // Xử lý đăng ký
    public function register(Request $request) {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:user,owner',
            'gender' => 'nullable|in:male,female,other', // Kiểm tra giới tính
            'avatar_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone' => 'nullable|string|max:15|unique:users',
        ]);

        $avatarPath = null;

        if ($request->hasFile('avatar_url')) {
            $file = $request->file('avatar_url');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Di chuyển file vào public/frontend/images
            $file->move(public_path('frontend/images'), $fileName);

            // Lưu đường dẫn tương đối
            $avatarPath = 'frontend/images/' . $fileName;
        }

        // Tạo người dùng với trường giới tính
        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'gender' => $request->gender, // Lưu giới tính
            'avatar_url' => $avatarPath,
            'phone' => $request->phone,
        ]);

        // Đăng nhập người dùng ngay sau khi đăng ký
        Auth::login($user);

        // Điều hướng người dùng đến trang riêng của mình
        return redirect()->route($user->role === 'owner' ? 'owner' : 'user', ['id' => $user->id]);
    }

    // Đăng xuất
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('trangchu');
    }
}
