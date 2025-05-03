@extends('backend.admin.layout')

@section('title', 'Sửa quán cà phê')
@section('header', 'Sửa quán cà phê')

@section('content')
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <strong>Lỗi!</strong> Vui lòng kiểm tra lại các thông tin sau:
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('coffeeshop.update', $coffeeshop) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block mb-1 font-semibold">Tên quán</label>
            <input type="text" name="shop_name" value="{{ old('shop_name', $coffeeshop->shop_name) }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">SĐT</label>
            <input type="text" name="phone" value="{{ old('phone', $coffeeshop->phone) }}" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block mb-1 font-semibold">Người quản lý</label>
            <select name="user_id" class="w-full border rounded px-3 py-2">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $user->id == $coffeeshop->user_id ? 'selected' : '' }}>
                        {{ $user->full_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
    <label class="block mb-1">Phong cách</label>
    <select name="styles_id" class="w-full border rounded px-3 py-2" required>
        @foreach($styles as $style)
            <option value="{{ $style->id }}" {{ $coffeeshop->style_id == $style->id ? 'selected' : '' }}>
                {{ $style->style_name }}
            </option>
        @endforeach
    </select>
</div>

        <div>
            <label class="block mb-1 font-semibold">Trạng thái</label>
            <select name="status" class="form-control">
    <option value="Đang mở cửa">Đang mở cửa</option>
    <option value="Đã đóng cửa">Đã đóng cửa</option>
</select>


        </div>

        <div>
            <label class="block mb-1 font-semibold">Giờ mở cửa</label>
            <input type="time" name="opening_time" value="{{ old('opening_time', $coffeeshop->opening_time) }}" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block mb-1 font-semibold">Giờ đóng cửa</label>
            <input type="time" name="closing_time" value="{{ old('closing_time', $coffeeshop->closing_time) }}" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block mb-1 font-semibold">Giá tối thiểu</label>
            <input type="number" name="min_price" value="{{ old('min_price', $coffeeshop->min_price) }}" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block mb-1 font-semibold">Giá tối đa</label>
            <input type="number" name="max_price" value="{{ old('max_price', $coffeeshop->max_price) }}" class="w-full border rounded px-3 py-2">
        </div>
    </div>

    <div class="mt-4">
        <label class="block mb-1 font-semibold">Mô tả</label>
        <textarea name="description" class="w-full border rounded px-3 py-2" rows="4">{{ old('description', $coffeeshop->description) }}</textarea>
    </div>

    <div class="mt-4">
        <label class="block mb-1 font-semibold">Địa chỉ</label>
        <input type="text" name="street" value="{{ old('street', $coffeeshop->address->street ?? '') }}" class="w-full border rounded px-3 py-2">
    </div>
    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
    <div>
        <label class="block mb-1 font-semibold">Phường / Xã</label>
        <input type="text" name="ward" value="{{ old('ward', $coffeeshop->address->ward ?? '') }}" class="w-full border rounded px-3 py-2">
    </div>
    <div>
        <label class="block mb-1 font-semibold">Quận / Huyện</label>
        <input type="text" name="district" value="{{ old('district', $coffeeshop->address->district ?? '') }}" class="w-full border rounded px-3 py-2">
    </div>
    <div>
        <label class="block mb-1 font-semibold">Tỉnh / Thành phố</label>
        <input type="text" name="city" value="{{ old('city', $coffeeshop->address->city ?? '') }}" class="w-full border rounded px-3 py-2">
    </div>
</div>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block mb-1 font-semibold">WiFi</label>
            <input type="text" name="wifi_password" value="{{ old('wifi_password', $coffeeshop->wifi_password) }}" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block mb-1 font-semibold">Hotline</label>
            <input type="text" name="hotline" value="{{ old('hotline', $coffeeshop->hotline) }}" class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <label class="block mb-1 font-semibold">Bãi đỗ xe</label>
            <input type="text" name="parking" value="{{ old('parking', $coffeeshop->parking) }}" class="w-full border rounded px-3 py-2">
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        @foreach(['cover_image', 'image_1', 'image_2', 'image_3'] as $img)
            <div>
                <label class="block mb-1 font-semibold">{{ strtoupper(str_replace('_', ' ', $img)) }}</label>
                <input type="file" name="{{ $img }}" class="w-full border rounded px-3 py-2">
                @if ($coffeeshop->$img)
                    <img src="{{ asset('frontend/images/' . $coffeeshop->$img) }}" alt="{{ $img }}" class="mt-2 rounded shadow w-full max-w-[120px] h-auto">
                @endif
            </div>
        @endforeach
    </div>

    <div class="mt-6">
        <button type="submit" class="bg-blue-600 text-white font-bold px-6 py-2 rounded hover:bg-blue-700 transition duration-200">
            Cập nhật
        </button>
    </div>
</form>
@endsection
