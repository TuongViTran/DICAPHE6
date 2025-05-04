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
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .dot { animation: bounce 1s infinite; }
        .dot:nth-child(1) { animation-delay: 0s; }
        .dot:nth-child(2) { animation-delay: 0.2s; }
        .dot:nth-child(3) { animation-delay: 0.4s; }
    </style>
</head>
<body class="bg-white flex items-center justify-center min-h-screen">
    <div class="flex flex-col md:flex-row bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Left Panel -->
        <div class="p-8 md:w-1/2 flex flex-col items-center justify-center bg-[#fefcbf]">
            <h1 class="text-2xl font-bold mb-4 text-center">
                Xin chào! Chúng tôi hỗ trợ tìm kiếm quán cà phê
            </h1>
            <img src="{{ asset('frontend/images/img_dn.png') }}"  class="w-64 h-64" alt="Hình ảnh đăng nhập">
        </div>

        <!-- Right Panel - Registration Form -->
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

            <form id="registerForm" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Tên tài khoản -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2" for="full_name">Tên tài khoản</label>
                    <div class="relative">
                        <input 
                            id="full_name" 
                            name="full_name" 
                            type="text" 
                            placeholder="Nhập tên tài khoản" 
                            value="{{ old('full_name') }}"
                            class="w-full px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('full_name') border-red-500 @enderror"
                            required>
                        <i class="fas fa-user absolute top-3 right-4 text-gray-400"></i>
                    </div>
                    @error('full_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2" for="email">Email</label>
                    <div class="relative">
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            placeholder="email@gmail.com" 
                            value="{{ old('email') }}"
                            class="w-full px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('email') border-red-500 @enderror"
                            required>
                        <i class="fas fa-envelope absolute top-3 right-4 text-gray-400"></i>
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Số điện thoại -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2" for="phone">Số điện thoại</label>
                    <div class="relative">
                        <input 
                            id="phone" 
                            name="phone" 
                            type="text" 
                            placeholder="Nhập số điện thoại" 
                            value="{{ old('phone') }}"
                            class="w-full px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('phone') border-red-500 @enderror"
                            required>
                        <i class="fas fa-phone absolute top-3 right-4 text-gray-400"></i>
                    </div>
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mật khẩu -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2" for="password">Mật khẩu</label>
                    <div class="relative">
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            placeholder="Nhập mật khẩu" 
                            class="w-full px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('password') border-red-500 @enderror"
                            required>
                        <i class="fas fa-lock absolute top-3 right-4 text-gray-400"></i>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Xác nhận mật khẩu -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2" for="password_confirmation">Xác nhận mật khẩu</label>
                    <div class="relative">
                        <input 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            type="password" 
                            placeholder="Xác nhận mật khẩu" 
                            class="w-full px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-500"
                            required>
                        <i class="fas fa-lock absolute top-3 right-4 text-gray-400"></i>
                    </div>
                </div>

                <!-- Ảnh đại diện -->
                <!-- <div class="mb-4">
                    <label for="avatar_url" class="block text-gray-700 font-semibold mb-2">Ảnh đại diện</label>
                    <input 
                        id="avatar_url" 
                        type="file" 
                        name="avatar_url" 
                        accept="image/*" 
                        class="block w-full px-4 py-2 border rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('avatar_url') border-red-500 @enderror">
                    @error('avatar_url')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div> -->

                <!-- Loại tài khoản -->
                <div class="mb-4">
                    <label for="role" class="block text-gray-700 font-semibold mb-2">Loại tài khoản</label>
                    <select 
                        id="role" 
                        name="role" 
                        class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('role') border-red-500 @enderror">
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Khách hàng</option>
                        <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Chủ cửa hàng</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Giới tính -->
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold mb-2">Giới tính</label>
                    <div class="flex">
                        <label class="mr-4">
                            <input type="radio" name="gender" value="male" {{ old('gender') == 'male' ? 'checked' : '' }} required> Nam
                        </label>
                        <label>
                            <input type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }} required> Nữ
                        </label>
                    </div>
                    @error('gender')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button class="w-full bg-yellow-500 text-white py-2 rounded-full font-semibold hover:bg-yellow-600 transition duration-200 mt-6" type="submit">
                    Đăng ký
                </button>

                <!-- Nếu có lỗi chung -->
                @if ($errors->any())
                    <div class="mt-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-red-500 text-sm">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>

            <div class="text-center mt-4">
                <span class="text-gray-600">- hoặc -</span>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('registerForm');

        form.addEventListener('submit', async function (e) {
            e.preventDefault(); // Ngăn reload trang

            // Xóa hết lỗi cũ
            document.querySelectorAll('.text-red-500.text-sm.mt-1').forEach(el => el.remove());
            document.querySelectorAll('input, select').forEach(el => el.classList.remove('border-red-500'));

            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                if (!response.ok) {
                    if (response.status === 422) { // Validation lỗi
                        const data = await response.json();
                        const errors = data.errors;

                        for (const field in errors) {
                            const input = document.querySelector(`[name="${field}"]`);
                            if (input) {
                                input.classList.add('border-red-500');
                                const errorEl = document.createElement('p');
                                errorEl.className = 'text-red-500 text-sm mt-1';
                                errorEl.innerText = errors[field][0];
                                input.parentNode.appendChild(errorEl);
                            }
                        }
                    } else {
                        alert('Có lỗi xảy ra, vui lòng thử lại sau!');
                    }
                } else {
                    // Thành công: bạn có thể redirect hoặc thông báo ở đây
                    alert('Đăng ký thành công!');
                    window.location.href = "{{ route('login') }}"; // Redirect về trang đăng nhập
                }
            } catch (error) {
                console.error('Lỗi kết nối:', error);
                alert('Không thể kết nối tới server!');
            }
        });
    });
</script>

</html>
