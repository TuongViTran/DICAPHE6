@extends('backend.admin.layout')

@section('title', 'Quản lý người dùng')

@section('header', 'Quản lý người dùng')

@section('content')
    <!-- Thông báo thành công -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert" id="success-message">
            <strong class="font-bold">Thành công! </strong>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <a href="{{ route('user.create') }}" class="bg-white border border-blue-500 text-blue-500 p-2 rounded ml-4">
                + THÊM MỚI
            </a>
            <form action="{{ route('user.management') }}" method="GET" class="ml-4">
                <input type="text" name="search" placeholder="Tìm kiếm theo tên..." class="border rounded p-2">
                <button type="submit" class="bg-blue-500 text-white p-2 rounded">Tìm</button>
            </form>
        </div>
    </div>

    <div class="bg-white p-4 rounded-lg shadow-md">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-gray-200 text-gray-800">
                    <th class="py-2 px-4 border-b text-center">STT</th>
                    <th class="py-2 px-4 border-b text-center">Ảnh đại diện</th>
                    <th class="py-2 px-4 border-b text-center">Họ và tên</th>
                    <th class="py-2 px-4 border-b text-center">Email</th>
                    <th class="py-2 px-4 border-b text-center">Số điện thoại</th>
                    <th class="py-2 px-4 border-b text-center">Giới tính</th>
                    <th class="py-2 px-4 border-b text-center">Vai trò</th>
                    <th class="py-2 px-4 border-b text-center">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($users as $k => $user)
                    <tr class="hover:bg-gray-50 transition duration-200 ease-in-out">
                        <td class="py-2 px-4 border-b text-center">{{ $k + 1 }}</td>
                        <td class="py-2 px-4 border-b text-center">
                            <div style="width: 50px; height: 50px; overflow: hidden; border-radius: 50%; margin: auto;">
                                <img 
                                    src="{{ asset('storage/uploads/avatars/' . basename($user->avatar_url)) }}"
                                    onerror="this.onerror=null; this.src='{{ asset('frontend/images/avt.png') }}';"
                                    alt="Avatar" 
                                    style="width: 100%; height: 100%; object-fit: cover;"
                                >
                            </div>
                        </td>
                        <td class="py-2 px-4 border-b text-center">{{ $user->full_name }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $user->email }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $user->phone }}</td>
                        <td class="py-2 px-4 border-b text-center">
                            {{ $user->gender == 'male' ? 'Nam' : ($user->gender == 'female' ? 'Nữ' : 'Khác') }}
                        </td>
                        <td class="py-2 px-4 border-b text-center">
                            @if ($user->role == 'admin')
                                <span class="bg-blue-200 text-blue-800 py-1 px-3 rounded-full text-xs">Admin</span>
                            @elseif ($user->role == 'owner')
                                <span class="bg-orange-200 text-orange-800 py-1 px-3 rounded-full text-xs">Chủ quán</span>
                            @else
                                <span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs">Khách hàng</span>
                            @endif
                        </td>
                        <td class="py-2 px-4 border-b text-center">
                            <div class="flex justify-center items-center space-x-2">
                                {{-- Nút Sửa --}}
                                <a href="{{ route('user.edit', $user) }}" class="text-yellow-500 flex items-center">
                                    <img src="{{ asset('backend/img/Icon (admin)/Sửa.svg') }}" alt="Edit" class="w-7 h-7">
                                </a>

                                {{-- Nút Xóa với xác nhận --}}
                                <form action="{{ route('user.destroy', $user) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 flex items-center">
                                        <img src="{{ asset('backend/img/Icon (admin)/Xóa.svg') }}" alt="Delete" class="w-7 h-7">
                                    </button>
                                </form>

                                {{-- Nút Xem chi tiết --}}
                                <a href="{{ route('user.show', $user) }}" class="text-blue-500 flex items-center">
                                    <img src="{{ asset('backend/img/Icon (admin)/Mở rộng.svg') }}" alt="View" class="w-7 h-7">
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-2 px-4 border-b text-center">Không có người dùng nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
      
        setTimeout(function() {
            const successMessage = document.getElementById('success-message');
            
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 5000); 
    </script>
@endsection
