@extends('backend.admin.layout')

@section('title', 'Thêm mới người dùng')

@section('header', 'Thêm mới người dùng')

@section('content')
    <div class="container mx-auto p-6">
    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">

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
    <label class="block text-sm font-medium mb-1">Ảnh đại diện</label>
    <input type="file" name="avatar" class="block w-full text-sm text-gray-700 border border-gray-300 rounded p-2" accept="image/*">
    @error('avatar')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>


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

         
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition duration-200">Thêm mới</button>
            </div>
        </form>
    </div>

    <script>
        // JavaScript để xử lý việc hiển thị và chọn ảnh đại diện
        document.getElementById('avatar').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('avatar-preview');
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
        }
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