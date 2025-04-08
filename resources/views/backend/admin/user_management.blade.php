@extends('backend.admin.layout')

@section('title', 'Quản lý người dùng')

@section('header', 'Quản lý người dùng')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <a href="{{ route('user.create') }}" class="bg-white border border-blue-500 text-blue-500 p-2 rounded ml-4">
                + THÊM MỚI
            </a>
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
                    <th class="py-2 px-4 border-b text-center">Vai trò</th>
                    <th class="py-2 px-4 border-b text-center">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($users as $k => $user)
                    <tr class="hover:bg-gray-50 transition duration-200 ease-in-out">
                        <td class="py-2 px-4 border-b text-center">{{ $k + 1 }}</td>
                        <td class="py-2 px-4 border-b text-center">
    <img src="{{ $user->avatar_url }}" alt="User  Avatar" class="mt-2 rounded-full w-10 h-10">
</td>
                        <td class="py-2 px-4 border-b text-center">{{ $user->full_name }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $user->email }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $user->phone }}</td>
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
                                <a href="{{ route('user.edit', $user) }}" class="text-yellow-500 flex items-center">
                                    <img src="{{ asset('backend/img/Icon (admin)/Sửa.svg') }}" alt="Edit" class="w-7 h-7">
                                </a>
                                <form action="{{ route('user.destroy', $user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 flex items-center">
                                        <img src="{{ asset('backend/img/Icon (admin)/Xóa.svg') }}" alt="Delete" class="w-7 h-7">
                                    </button>
                                </form>
                                <a href="{{ route('user.show', $user) }}" class="text-blue-500 flex items-center">
                                    <img src="{{ asset('backend/img/Icon (admin)/Mở rộng.svg') }}" alt="View" class="w-7 h-7">
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-2 px-4 border-b text-center">Không có người dùng nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection