@extends('backend.admin.layout')

@section('title', 'Sửa Quán Cà Phê')

@section('header', 'Sửa Quán Cà Phê')

@section('content')
    <div class="bg-white p-4 rounded-lg shadow-md">
        <form action="{{ route('coffeeshop.update', $coffeeshop) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="shop_name" class="block text-gray-700">Tên quán</label>
                <input type="text" id="shop_name" name="shop_name" value="{{ old('shop_name', $coffeeshop->shop_name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-gray-700">Số điện thoại</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $coffeeshop->phone) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>

            <div class="mb-4">
                <label for="address" class="block text-gray-700">Địa chỉ</label>
                <input type="text" id="address" name="address" value="{{ old('address', $coffeeshop->address->street ?? '') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>

            <div class="mb-4">
                <label for="status" class="block text-gray-700">Trạng thái</label>
                <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                    <option value="open" {{ $coffeeshop->status == 'open' ? 'selected' : '' }}>Mở cửa</option>
                    <option value="closed" {{ $coffeeshop->status == 'closed' ? 'selected' : '' }}>Đóng cửa</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="cover_image" class="block text-gray-700">Ảnh bìa</label>
                <input type="file" id="cover_image" name="cover_image" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                @if($coffeeshop->cover_image)
                    <img src="{{ asset('frontend/images/' . $coffeeshop->cover_image) }}" alt="Ảnh bìa hiện tại" class="mt-2 w-32 h-32 object-cover rounded">
                @else
                    <span>Chưa có ảnh bìa</span>
                @endif
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-200">
                    Cập nhật
                </button>
            </div>

            @if ($errors->any())
                <div class="bg-red-500 text-white p-4 rounded-lg mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>
@endsection