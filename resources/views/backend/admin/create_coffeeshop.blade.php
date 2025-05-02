@extends('backend.admin.layout')

@section('title', 'Thêm mới quán cà phê')
@section('header', 'Thêm mới quán cà phê')

@section('content')
<form action="{{ route('coffeeshop.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block mb-1">Tên quán</label>
            <input type="text" name="shop_name" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block mb-1">Số điện thoại</label>
            <input type="text" name="phone" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block mb-1">Người quản lý</label>
            <select name="user_id" class="w-full border rounded px-3 py-2">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1">Phong cách</label>
            <select name="styles_id" class="w-full border rounded px-3 py-2" required>
                @foreach($styles as $style)
                    <option value="{{ $style->id }}">{{ $style->style_name }}</option>
                @endforeach
            </select>
        </div>

        <div>
    <label class="block mb-1">Trạng thái</label>
    <select name="status" class="w-full border rounded px-3 py-2" required>
        <option value="Đang mở cửa">Đang mở cửa</option>
        <option value="Đã đóng cửa">Đã đóng cửa</option>
    </select>
</div>


        <div>
            <label class="block mb-1">Giờ mở cửa</label>
            <input type="time" name="opening_time" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block mb-1">Giờ đóng cửa</label>
            <input type="time" name="closing_time" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block mb-1">Giá tối thiểu</label>
            <input type="number" name="min_price" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block mb-1">Giá tối đa</label>
            <input type="number" name="max_price" class="w-full border rounded px-3 py-2">
        </div>
    </div>

    <div class="mt-4">
        <label class="block mb-1">Mô tả</label>
        <textarea name="description" class="w-full border rounded px-3 py-2" rows="4"></textarea>
    </div>

   <div class="mt-4">
    <label class="block mb-1" for="street">Địa chỉ (Số nhà, Đường)</label>
    <input type="text" name="street" id="street" class="w-full border rounded px-3 py-2" placeholder="Nhập địa chỉ số nhà, đường" required>
</div>

<div class="mt-4">
    <label class="block mb-1" for="ward">Phường/Xã</label>
    <input type="text" name="ward" id="ward" class="w-full border rounded px-3 py-2" placeholder="Nhập phường/xã" required>
</div>

<div class="mt-4">
    <label class="block mb-1" for="district">Quận/Huyện</label>
    <input type="text" name="district" id="district" class="w-full border rounded px-3 py-2" placeholder="Nhập quận/huyện" required>
</div>

<div class="mt-4">
    <label class="block mb-1" for="city">Thành phố</label>
    <input type="text" name="city" id="city" class="w-full border rounded px-3 py-2" placeholder="Nhập thành phố" required>
</div>

    <!-- Thêm các trường bị thiếu -->
    
    <div class="mt-4">
        <label class="block mb-1">WiFi</label>
        <input type="text" name="wifi_password" class="w-full border rounded px-3 py-2">
    </div>

    <div class="mt-4">
        <label class="block mb-1">Hotline</label>
        <input type="text" name="hotline" class="w-full border rounded px-3 py-2">
    </div>

    <div class="mt-4">
        <label class="block mb-1">Bãi đỗ xe</label>
        <input type="text" name="parking" class="w-full border rounded px-3 py-2">
    </div>

    <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach(['cover_image', 'image_1', 'image_2', 'image_3'] as $img)
            <div>
                <label class="block mb-1">{{ strtoupper($img) }}</label>
                <input type="file" name="{{ $img }}" class="w-full border rounded px-3 py-2">
            </div>
        @endforeach
    </div>

    <!-- Hiển thị thông báo thành công hoặc lỗi -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 mt-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-2 mt-4 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-700 px-4 py-2 mt-4 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mt-6">
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Lưu</button>
    </div>
</form>
@endsection
