@extends('backend.admin.layout')

@section('title', 'Chỉnh sửa người dùng')

@section('header', 'Chỉnh sửa người dùng')

@section('content')
    <form action="{{ route('user.update', $user) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="avatar" class="block text-sm font-bold mb-2">Ảnh đại diện</label>
            <input type="file" name="avatar" id="avatar" class="border border-gray-300 rounded p-2 w-full" accept="image/*">
            @if ($user->avatar_url)
            <img src="{{ $user->avatar_url }}" alt="User  Avatar" class="mt-2 rounded-full w-10 h-10">
            @endif
        </div>
        <div class="mb-4">
            <label for="full_name" class="block text-sm font-bold mb-2">Họ và tên</label>
            <input type="text" name="full_name" id="full_name" value="{{ $user->full_name }}" class="border border-gray-300 rounded p-2 w-full" required>
        </div>
        
        <div class="mb-4">
            <label for="email" class="block text-sm font-bold mb-2">Email</label>
            <input type="email" name="email" id="email" value="{{ $user->email }}" class="border border-gray-300 rounded p-2 w-full" required>
        </div>
        
        <div class="mb-4">
            <label for="phone" class="block text-sm font-bold mb-2">Số điện thoại</label>
            <input type="text" name="phone" id="phone" value="{{ $user->phone }}" class="border border-gray-300 rounded p-2 w-full">
        </div>
        
       
        
        <div class="mb-4">
            <label for="account_type" class="block text-sm font-bold mb-2">Vai trò</label>
            <select name="account_type" id="account_type" class="border border-gray-300 rounded p-2 w-full" required>
                <option value="user" {{ $user->account_type == 'user' ? 'selected' : '' }}>Khách hàng</option>
                <option value="owner" {{ $user->account_type == 'owner' ? 'selected' : '' }}>Chủ quán</option>
                <option value="admin" {{ $user->account_type == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        
        <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-200">Cập nhật</button>
    </form>
@endsection