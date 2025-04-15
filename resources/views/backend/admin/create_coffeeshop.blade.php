@extends('backend.admin.layout')

@section('title', 'Thêm Mới Quán Cà Phê')

@section('header', 'Thêm Mới Quán Cà Phê')

@section('content')
    <div class="bg-white p-4 rounded-lg shadow-md">
        <form action="{{ route('coffeeshop.create') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="shop_name" class="block text-gray-700">Tên quán</label>
                <input type="text" id="shop_name" name="shop_name" value="{{ old('shop_name') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
            </div>

            <div class="mb-4">
                <label for="phone" class="block text-gray-700">Số điện thoại</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700">Mô tả</label>
                <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" rows="4">{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="address_id" class="block text-gray-700">Địa chỉ</label>
                <select id="address_id" name="address_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                   
                    @foreach($addresses as $address)
                        <option value="{{ $address->id }}">{{ $address->street }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-gray-700">Trạng thái</label>
                <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                    <option value="open">Mở cửa</option>
                    <option value="closed">Đóng cửa</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="opening_time" class="block text-gray-700">Giờ mở cửa</label>
                <input type="time" id="opening_time" name="opening_time" value="{{ old('opening_time') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>

            <div class="mb-4">
                <label for="closing_time" class="block text-gray-700">Giờ đóng cửa</label>
                <input type="time" id="closing_time" name="closing_time" value="{{ old('closing_time') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>

            <div class="mb-4">
                <label for="parking" class="block text-gray-700">Thông tin bãi đỗ xe</label>
                <input type="text" id="parking" name="parking" value="{{ old('parking') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>

            <div class="mb-4">
                <label for="wifi_password" class="block text-gray-700">Mật khẩu WiFi</label>
                <input type="text" id="wifi_password" name="wifi_password" value="{{ old('wifi_password') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                </div>

<div class="mb-4">
    <label for="hotline" class="block text-gray-700">Hotline</label>
    <input type="text" id="hotline" name="hotline" value="{{ old('hotline') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
</div>

<div class="mb-4">
    <label for="rating" class="block text-gray-700">Đánh giá</label>
    <input type="number" id="rating" name="rating" value="{{ old('rating', 0) }}" min="0" max="5" step="0.1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
</div>

<div class="mb-4">
    <label for="min_price" class="block text-gray-700">Giá tối thiểu</label>
    <input type="number" id="min_price" name="min_price" value="{{ old('min_price') }}" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
</div>

<div class="mb-4">
    <label for="max_price" class="block text-gray-700">Giá tối đa</label>
    <input type="number" id="max_price" name="max_price" value="{{ old('max_price') }}" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
</div>

<div class="mb-4">
    <label for="styles_id" class="block text-gray-700">Phong cách</label>
    <select id="styles_id" name="styles_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
        <!-- Giả sử bạn đã có một mảng phong cách -->
        @foreach($styles as $style)
            <option value="{{ $style->id }}">{{ $style->name }}</option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label for="social_network_id" class="block text-gray-700">Mạng xã hội</label>
    <select id="social_network_id" name="social_network_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
        <!-- Giả sử bạn đã có một mảng mạng xã hội -->
        @foreach($socialNetworks as $socialNetwork)
            <option value="{{ $socialNetwork->id }}">{{ $socialNetwork->name }}</option>
        @endforeach
    </select>
</div>

<div class="mb-4">
    <label for="cover_image" class="block text-gray-700">Ảnh bìa</label>
    <input type="file" id="cover_image" name="cover_image" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
</div>

<div class="mb-4">
    <label for="image_1" class="block text-gray-700">Ảnh chi tiết 1</label>
    <input type="file" id="image_1" name="image_1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
</div>

<div class="mb-4">
    <label for="image_2" class="block text-gray-700">Ảnh chi tiết 2</label>
    <input type="file" id="image_2" name="image_2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
</div>

<div class="mb-4">
    <label for="image_3" class="block text-gray-700">Ảnh chi tiết 3</label>
                <input type="file" id="image_3" name="image_3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-200">
                    Thêm Mới
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