<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage; // Đã thêm câu lệnh import đúng
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
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();
            $ip = $request->ip();

            $client = new Client();
            try {
                $response = $client->get("https://ipinfo.io/{$ip}?token=2956ed85a25bba");
                $data = json_decode($response->getBody(), true);

                if (isset($data['loc'])) {
                    $location = explode(',', $data['loc']);
                    $latitude = $location[0];
                    $longitude = $location[1];
                    $user->latitude = $latitude;
                    $user->longitude = $longitude;
                    $user->save();
                }
            } catch (\Exception $e) {
                \Log::error("Error fetching location: " . $e->getMessage());
            }

            // Điều hướng
            switch ($user->role) {
                case 'admin':
                    $url = route('dashboard');
                    break;
                case 'owner':
                case 'user':
                    $url = route('trangchu', ['id' => $user->id]);
                    break;
                default:
                    Auth::logout();
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Tài khoản không hợp lệ.'
                    ], 422);
            }

            return response()->json([
                'status' => 'success',
                'redirect' => $url
            ]);
        }

        return response()->json([
            'status' => 'error',
            'errors' => [
                'email' => ['Thông tin đăng nhập không chính xác.']
            ]
        ], 422);
    }

    // Xử lý đăng ký
    public function register(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'full_name' => 'required|string|max:255|unique:users,full_name',
            'email' => ['required', 'max:255', 'unique:users,email', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'],
            'phone' => ['required', 'regex:/^[0-9]{10,11}$/', 'unique:users,phone'],
            'password' => 'required|string|min:6|confirmed',
            'gender' => 'required|in:male,female',
            'role' => 'required|in:user,owner',
            'avatar_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'full_name.required' => 'Vui lòng nhập tên tài khoản.',
            'full_name.unique' => 'Tên tài khoản đã tồn tại.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã được sử dụng.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'phone.unique' => 'Số điện thoại đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'gender.required' => 'Vui lòng chọn giới tính.',
            'role.required' => 'Vui lòng chọn loại tài khoản.',
            'avatar_url.image' => 'File tải lên phải là hình ảnh.',
        ]);
    
        // Handle avatar file upload
        $avatarPath = null;
        if ($request->hasFile('avatar_url')) {
            $file = $request->file('avatar_url');
            $fileName = 'avatar_' . time() . '.' . $file->getClientOriginalExtension(); // Unique file name
    
            // Store the file in the 'uploads/avatars' directory
            $avatarPath = $file->storeAs('uploads/avatars', $fileName, 'public'); // 'public' disk is used to store the file
        }
    
        // Create the user with gender and avatar
        $user = User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'gender' => $request->gender, // Save gender
            'avatar_url' => $avatarPath, // Save avatar URL
            'phone' => $request->phone,
        ]);
    
        // Không tự động đăng nhập ngay sau khi đăng ký, chỉ hiển thị thông báo yêu cầu người dùng đăng nhập
        return redirect()->route('login')
            ->with('success', 'Đăng ký thành công. Vui lòng đăng nhập.');
    }
    

    // Đăng xuất
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('trangchu');
    }
}
