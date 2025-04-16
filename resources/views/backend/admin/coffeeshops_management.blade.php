@extends('backend.admin.layout')

@section('title', 'Quản lý quán cà phê')

@section('header', 'Quản lý quán cà phê')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center">
            <a href="{{ route('coffeeshop.create') }}" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-200">
                + THÊM MỚI QUÁN CÀ PHÊ
            </a>
        </div>
    </div>
    @if (session('success'))
    <div class="bg-green-500 text-white p-4 rounded-lg mb-4">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="bg-red-500 text-white p-4 rounded-lg mb-4">
        {{ session('error') }}
    </div>
@endif
    <div class="bg-white p-4 rounded-lg shadow-md">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-gray-200 text-gray-800">
                    <th class="py-2 px-4 border-b text-center">ID</th>
                    <th class="py-2 px-4 border-b text-center">Tên quán</th>
                    <th class="py-2 px-4 border-b text-center">Số điện thoại</th>
                    <th class="py-2 px-4 border-b text-center">Người quản lý</th>
                    <th class="py-2 px-4 border-b text-center">Địa chỉ</th>
                    <th class="py-2 px-4 border-b text-center">Trạng thái</th>
                    <th class="py-2 px-4 border-b text-center">Đánh giá trung bình</th> 
                    <th class="py-2 px-4 border-b text-center">Ảnh bìa</th>
                    <th class="py-2 px-4 border-b text-center">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($coffeeShops as $coffeeshop)
                    <tr class="hover:bg-gray-50 transition duration-200 ease-in-out">
                        <td class="py-2 px-4 border-b text-center">{{ $coffeeshop->id }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $coffeeshop->shop_name }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $coffeeshop->phone ?? 'Chưa có số điện thoại' }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $coffeeshop->user->full_name ?? 'Chưa có người quản lý' }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $coffeeshop->address->street ?? 'Chưa có địa chỉ' }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ ucfirst($coffeeshop->status) }}</td>
                        <td class="py-2 px-4 border-b text-center">{{ $coffeeshop->reviews_avg_rating ?? 'Chưa có đánh giá' }}</td> 
                        <td class="py-2 px-4 border-b text-center">
                            @if($coffeeshop->cover_image)
                                <img src="{{ asset('frontend/images/' . $coffeeshop->cover_image) }}" alt="Ảnh bìa" class="w-16 h-16 object-cover rounded">
                            @else
                                Chưa có ảnh bìa
                            @endif
                        </td>
                        <td class="py-2 px-4 border-b text-center">
                            <div class="flex justify-center items-center space-x-2">
                                <a href="{{ route('coffeeshop.edit', $coffeeshop) }}" class="flex items-center" title="Sửa">
                                    <img src="{{ asset('backend/img/Icon (admin)/Sửa.svg') }}" alt="Edit" class="w-7 h-7">
                                </a>
                                <form action="{{ route('coffeeshop.destroy', $coffeeshop) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center" onclick="return confirm('Bạn có chắc chắn muốn xóa quán cà phê này?');" title="Xóa">
                                        <img src="{{ asset('backend/img/Icon (admin)/Xóa.svg') }}" alt="Delete" class="w-7 h-7">
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="py-2 px-4 border-b text-center">Không có quán cà phê nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection