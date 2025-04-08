@extends('backend.admin.layout')

@section('title', 'Thêm mới người dùng')

@section('header', 'Thêm mới người dùng')

@section('content')
    <div class="container mx-auto p-6">
        <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            @csrf
            <h2 class="text-xl font-bold mb-4 text-gray-800">Thông tin người dùng</h2>
            
            <div class="mb-4">
                <label for="full_name" class="block text-sm font-bold mb-2">Họ và tên</label>
                <input type="text" name="full_name" id="full_name" class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" id="email" class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-sm font-bold mb-2">Mật khẩu</label>
                <input type="password" name="password" id="password" class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-bold mb-2">Xác nhận mật khẩu</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-sm font-bold mb-2">Số điện thoại</label>
                <input type="text" name="phone" id="phone" class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="mb-4">
                <label for="avatar" class="block text-sm font-bold mb-2">Ảnh đại diện</label>
                <input type="file" name="avatar" id="avatar" class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" accept="image/*">
            </div>
            <div class="mb-4">
                <label for="account_type" class="block text-sm font-bold mb-2">Vai trò</label>
                <select name="account_type" id="account_type" class="border border-gray-300 rounded p-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="user">Khách hàng</option>
                    <option value="owner">Chủ quán</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-200">Thêm mới</button>
        </form>
    </div>
@endsection