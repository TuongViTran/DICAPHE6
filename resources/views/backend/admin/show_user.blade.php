@extends('backend.admin.layout')

@section('content')
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Thông tin người dùng</h1>
        
        <div class="bg-gray-100 p-4 rounded-lg mb-4">
            <p class="text-lg text-gray-700"><strong>Tên:</strong> {{ $user->full_name }}</p>
            <p class="text-lg text-gray-700"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="text-lg text-gray-700"><strong>Điện thoại:</strong> {{ $user->phone }}</p>
            <p class="text-lg text-gray-700"><strong>Loại tài khoản:</strong> {{ $user->account_type }}</p>
        </div>

        <a href="{{ route('user.management') }}" class="inline-block bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition duration-200">
            Quay lại danh sách người dùng
        </a>
    </div>
@endsection