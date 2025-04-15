@extends('backend.admin.layout')

@section('title', 'Sửa thông tin người dùng')

@section('header', 'Sửa thông tin người dùng')

@section('content')
    <form action="{{ route('user.update', $user) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="full_name" class="block text-sm font-bold mb-2">Họ và tên</label>
            <input type="text" name="full_name" id="full_name" value="{{ old('full_name', $user->full_name) }}" class="border border-gray-300 rounded p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-bold mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="border border-gray-300 rounded p-2 w-full" required>
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-sm font-bold mb-2">Số điện thoại</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="border border-gray-300 rounded p-2 w-full">
        </div>

        <div class="mb-4">
            <label for="gender" class="block text-sm font-bold mb-2">Giới tính</label>
            <select name="gender" id="gender" class="border border-gray-300 rounded p-2 w-full" required>
                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Nam</option>
                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Nữ</option>
                <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Khác</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="role" class="block text-sm font-bold mb-2">Vai trò</label>
            <select name="role" id="role" class="border border-gray-300 rounded p-2 w-full" required>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="owner" {{ old('role', $user->role) == 'owner' ? 'selected' : '' }}>Chủ quán</option>
                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Người dùng</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-bold mb-2">Ảnh đại diện hiện tại</label>
            @if ($user->avatar_url)
            <img src="{{ asset('frontend/images/' . basename($user->avatar_url)) }}" 
     onerror="this.onerror=null; this.src='{{ asset('frontend/images/avt.png') }}';"
     width="50" height="50" alt="Avatar">
</td>
            @else
                <p class="mt-2">Chưa có ảnh đại diện.</p>
            @endif
            <button type="button" id="edit-avatar" class="mt-2 bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-200">Sửa ảnh</button>
        </div>

        <div id="avatar-selection" class="hidden mb-4">
            <label class="block text-sm font-bold mb-2">Chọn ảnh đại diện mới</label>
            <div class="flex flex-wrap">
                @php
                    $images = ['c1.jpg', 'c2.jpg', 'c3.jpg', 'c4.jpg', 'c5.jpg', 'c6.jpg']; // Thay thế bằng danh sách ảnh thực tế trong thư mục
                @endphp
                @foreach ($images as $image)
                    <div class="relative mr-2 mb-2">
                        <img src="{{ asset('frontend/images/' . $image) }}" alt="Avatar" class="w-20 h-20 rounded-full cursor-pointer select-avatar" data-image="{{ $image }}">
                    </div>
                @endforeach
            </div>
            <input type="hidden" name="avatar" id="selected_avatar" value="{{ old('avatar', $user->avatar_url) }}">
        </div>

        <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-200">Cập nhật</button>
    </form>

    <script>
        // JavaScript để xử lý việc hiển thị và chọn ảnh đại diện
        document.getElementById('edit-avatar').addEventListener('click', function () {
            const avatarSelection = document.getElementById('avatar-selection');
            avatarSelection.classList.toggle('hidden'); // Hiện hoặc ẩn danh sách ảnh
        });

        document.querySelectorAll('.select-avatar').forEach(function (img) {
            img.addEventListener('click', function () {
                // Lấy đường dẫn ảnh từ thuộc tính data-image
                const selectedImage = this.getAttribute('data-image');
                // Cập nhật giá trị của input ẩn
                document.getElementById('selected_avatar').value = selectedImage;

                // Cập nhật ảnh đại diện hiển thị
                const currentAvatar = document.querySelector('.current-avatar');
                if (currentAvatar) {
                    currentAvatar.src = this.src; // Cập nhật ảnh đại diện hiển thị
                } else {
                    const newAvatar = document.createElement('img');
                    newAvatar.src = this.src;
                    newAvatar.alt = "User  Avatar";
                    newAvatar.className = "mt-2 rounded-full w-20 h-20 current-avatar";
                    document.querySelector('.mb-4').appendChild(newAvatar); // Thêm ảnh đại diện mới vào view
                }
            });
        });
    </script>
@endsection