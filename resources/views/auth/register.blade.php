<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Registration Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        .dot {
            animation: bounce 1s infinite;
        }
        .dot:nth-child(1) {
            animation-delay: 0s;
        }
        .dot:nth-child(2) {
            animation-delay: 0.2s;
        }
        .dot:nth-child(3) {
            animation-delay: 0.4s;
        }
    </style>
</head>
<body class="bg-white flex items-center justify-center min-h-screen">
    <div class="flex flex-col md:flex-row bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-8 md:w-1/2 flex flex-col items-center justify-center bg-[#fefcbf]">
            <h1 class="text-2xl font-bold mb-4 text-center">
                Xin chào! Chúng tôi hỗ trợ tìm kiếm quán cà phê
            </h1>
            <img src="{{ asset('frontend/images/img_dn.png') }}"  class="w-64 h-64" height="300" src="" width="300">
        </div>
        <div class="p-8 md:w-1/2 flex flex-col justify-center">
            <div class="flex flex-col items-center mb-6">
                <div class="flex items-center mb-2">
                    <div class="w-4 h-4 bg-yellow-500 rounded-full mr-2 dot"></div>
                    <div class="w-4 h-4 bg-blue-500 rounded-full mr-2 dot"></div>
                    <div class="w-4 h-4 bg-red-500 rounded-full dot"></div>
                    <h2 class="text-2xl font-bold text-center ml-2">
                        Cà Phê Đi Đâu?
                    </h2>
                </div>
            </div>
            <h3 class="text-xl font-semibold mb-6 text-center">
                Đăng ký
            </h3>
            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data"> <!-- Thêm enctype để xử lý file upload -->
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2" for="full_name">
                        Tên tài khoản
                    </label>
                    <div class="relative">
                        <input class="w-full px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-500" id="full_name" name="full_name" placeholder="Nhập tên tài khoản" type="text" required/>
                        <i class="fas fa-user absolute top-3 right-4 text-gray-400"></i>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2" for="email">
                        Email
                    </label>
                    <div class="relative">
                        <input class="w-full px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-500" id="email" name="email" placeholder="email@gmail.com" type="email" required/>
                        <i class="fas fa-envelope absolute top-3 right-4 text-gray-400"></i>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2" for="phone">
                        Số điện thoại
                    </label>
                    <div class="relative">
                        <input class="w-full px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-500" id="phone" name="phone" placeholder="Nhập số điện thoại" type="text" required/>
                        <i class="fas fa-phone absolute top-3 right-4 text-gray-400"></i>
                    </div>
                    <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2" for="password">
                        Mật Khẩu
                    </label>
                    <div class="relative">
                        <input class="w-full px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-500" id="password" name="password" placeholder="Nhập mật khẩu" type="password" required/>
                        <i class="fas fa-lock absolute top-3 right-4 text-gray-400"></i>
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2" for="password_confirmation">
                         Xác nhận mật khẩu
                    </label>
                    <div class="relative">
                        <input class="w-full px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-500" id="password_confirmation" name="password_confirmation" placeholder="Xác nhận mật khẩu" type="password" required/>
                        <i class="fas fa-lock absolute top-3 right-4 text-gray-400"></i>
                    </div>
                </div>
                <div class="mb-4">
                    <label for="avatar_url" class="block text-gray-700 font-semibold mb-2">Ảnh đại diện</label>
                    <input id="avatar_url" type="file" name="avatar_url" accept="image/*" class="block w-full px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-500"/>
                </div>
                <div class="mt-4">
                    <label for="role" class="block text-gray-700 font-semibold mb-2">Loại tài khoản</label>
                    <select id="role" name="role" class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        <option value="user">Khách hàng</option>
                        <option value="owner">Chủ cửa hàng</option>
                        <!-- <option value="admin">Admin</option> -->
                    </select>
                    @error('role')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Giới tính</label>
                    <div class="flex">
                        <label class="mr-4">
                            <input type="radio" name="gender" value="male" required>
                            Nam
                        </label>
                        <label>
                            <input type="radio" name="gender" value="female" required>
                            Nữ
                        </label>
                    </div>
                    @error('gender')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <button class="w-full bg-yellow-500 text-white py-2 rounded-full font-semibold hover:bg-yellow-600 transition duration-200 mt-6" type="submit">
                    Đăng ký
                </button>
                @if ($errors->any())
                    <div class="alert alert-danger mt-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-red-500">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
            <div class="text-center mt-4">
                <span class="text-gray-600">
                    - hoặc -
                </span>
            </div>
            <div class="text-center mt-4">
                <span class="text-gray-600">
                    Bạn đã có tài khoản?
                    <a class="text-yellow-500 font-semibold" href="{{ route('login') }}">
                        Đăng nhập ngay!
                    </a>
                </span>
            </div>
        </div>
    </div>
</body>
</html>