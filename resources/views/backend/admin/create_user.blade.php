@extends('backend.admin.layout')

@section('title', 'Thêm mới người dùng')

@section('header', 'Thêm mới người dùng')

@section('content')
    <div class="container mx-auto p-6">
        <form action="{{ route('user.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            <h2 class="text-xl font-bold mb-4 text-gray-800">Thông tin người dùng</h2>

            @if ($errors->any())
                <div class="mb-4">
                    <ul class="text-red-500">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mb-4">
                <label for="full_name" class="block text-sm font-bold mb-2">Họ và tên</label>
                <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập họ và tên" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập email" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-bold mb-2">Mật khẩu</label>
                <input type="password" name="password" id="password" class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập mật khẩu" required>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-bold mb-2">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Xác nhận mật khẩu" required>
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-sm font-bold mb-2">Số điện thoại</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập số điện thoại">
            </div>

            <div class="mb-4 flex items-center">
                <label class="block text-sm font-bold mb-2 mr-4">Ảnh đại diện</label>
                <button type="button" id="edit-avatar" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-200">Chọn ảnh đại diện</button>
                <img id="selected-avatar" src="" alt="Selected Avatar" class="ml-4 w-20 h-20 rounded-full hidden" />
            </div>

            <div id="avatar-selection" class="hidden mb-4">
                <label class="block text-sm font-bold mb-2">Chọn ảnh đại diện mới</label>
                <div class="flex flex-wrap">
                    @php
                        $images = ['c1.jpg', 'c2.jpg', 'c3.jpg', 'c4.jpg', 'c5.jpg', 'c6.jpg']; // Thay thế bằng danh sách ảnh thực tế trong thư mục
                    @endphp
                    @foreach ($images as $image)
                        <div class="relative mr-2 mb-2">
                            <img src="{{ asset('frontend/images/' . $image) }}" alt="Avatar" class="w-20 h-20 rounded-full cursor-pointer select-avatar transition-transform duration-200 transform hover:scale-110" data-image="{{ $image }}">
                        </div>
                    @endforeach
                </div>
                <input type="hidden" name="avatar" id="selected_avatar" value="{{ old('avatar') }}">
            </div>
            <div class="mb-4">
                <label for="account_type" class="block text-sm font-bold mb-2">Vai trò</label>
                <select name="account_type" id="account_type" class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="user">Khách hàng</option>
                    <option value="owner">Chủ quán</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="gender" class="block text-sm font-bold mb-2">Giới tính</label>
                <select name="gender" id="gender" class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Chọn giới tính</option>
                    <option value="male">Nam</option>
                    <option value="female">Nữ</option>
                    <option value="other">Khác</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="latitude" class="block text-sm font-bold mb-2">Vĩ độ</label>
                <input type="text" name="latitude" id="latitude" value="{{ old('latitude') }}" class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập vĩ độ">
            </div>

            <div class="mb-4">
                <label for="longitude" class="block text-sm font-bold mb-2">Kinh độ</label>
                <input type="text" name="longitude" id="longitude" value="{{ old('longitude') }}" class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nhập kinh độ">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition duration-200">Thêm mới</button>
            </div>
        </form>
    </div>

    <script>
        // JavaScript để xử lý việc hiển thị và chọn ảnh đại diện
        document.getElementById('edit-avatar').addEventListener('click', function() {
            const avatarSelection = document.getElementById('avatar-selection');
            avatarSelection.classList.toggle('hidden'); // Hiện hoặc ẩn danh sách ảnh
        });

        document.querySelectorAll('.select-avatar').forEach(function(img) {
            img.addEventListener('click', function() {
                // Lấy đường dẫn ảnh từ thuộc tính data-image
                const selectedImage = this.getAttribute('data-image');
                // Cập nhật giá trị của input ẩn
                document.getElementById('selected_avatar').value = selectedImage;

                // Cập nhật ảnh đại diện hiển thị
                const avatarDisplay = document.getElementById('selected-avatar');
                avatarDisplay.src = this.src; // Cập nhật ảnh đại diện hiển thị
                avatarDisplay.classList.remove('hidden'); // Hiện ảnh đại diện đã chọn
            });
        });
    </script>
@endsection