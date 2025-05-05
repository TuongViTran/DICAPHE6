@extends('backend.admin.layout')

@section('title', 'Sửa thông tin người dùng')

@section('header', 'Sửa thông tin người dùng')

@section('content')
<form action="{{ route('user.update', $user) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
    @csrf
    @method('PUT')

    <div class="mb-4">
    <label class="block text-sm font-bold mb-2">Ảnh đại diện hiện tại</label>
    @if ($user->avatar_url)
        <img src="{{ asset('storage/uploads/avatars/' . basename($user->avatar_url)) }}"
             onerror="this.onerror=null; this.src='{{ asset('frontend/images/avt.png') }}';"
             alt="Avatar"
             class="current-avatar w-20 h-20 rounded-full object-cover border border-gray-300 shadow-sm">
    @else
        <p class="mt-2">Chưa có ảnh đại diện.</p>
    @endif

    <button type="button" id="edit-avatar" class="mt-2 bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-200">Sửa ảnh</button>
</div>


<div id="avatar-selection" class="hidden mb-4">
    <label class="block text-sm font-bold mb-2">Chọn ảnh đại diện mới</label>
    <input type="file" name="avatar" id="avatar" accept="image/*" class="border border-gray-300 rounded p-2 w-full">
    <p class="text-sm text-gray-500 mt-2">Chọn file ảnh từ máy tính của bạn.</p>
</div>

 
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


    <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-200">Cập nhật</button>
</form>

<script>
   document.getElementById('edit-avatar').addEventListener('click', function () {
    const avatarSelection = document.getElementById('avatar-selection');
    avatarSelection.classList.toggle('hidden');
});

document.getElementById('avatar').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (event) {
            // Cập nhật ảnh hiển thị
            let currentAvatar = document.querySelector('.current-avatar');
            if (currentAvatar) {
                currentAvatar.src = event.target.result;
            } else {
                currentAvatar = document.createElement('img');
                currentAvatar.src = event.target.result;
                currentAvatar.alt = "User Avatar";
                currentAvatar.className = "mt-2 rounded-full w-20 h-20 current-avatar";
                document.querySelector('#avatar-selection').insertAdjacentElement('beforebegin', currentAvatar);
            }
        };
        reader.readAsDataURL(file); // Đọc file ảnh và chuyển đổi sang base64
    }
});

</script>
@endsection
