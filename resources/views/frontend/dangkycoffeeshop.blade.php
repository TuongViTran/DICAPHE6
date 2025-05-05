@extends('frontend.layout')
@section('title', 'Đăng ký quán cà phê')
@section('content')
<!-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif -->
@if(session('warning'))
    <script>
        alert("{{ session('warning') }}");
    </script>
@endif
<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">Đăng ký quán cà phê</h2>

    <form id="registerForm" method="POST" action="{{ route('register.shop') }}" enctype="multipart/form-data">
        @csrf

        {{-- Grid 2 cột --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="shop_name" class="block font-medium">Tên quán</label>
                <input type="text" name="shop_name" id="shop_name" value="{{ old('shop_name') }}"  class="w-full border rounded px-3 py-2">
                @error('shop_name')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone" class="block font-medium">Số điện thoại</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="w-full border rounded px-3 py-2" >
                @error('phone')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="styles_id" class="block font-medium">Phong cách</label>
                <select name="styles_id" id="styles_id" value="{{ old('styles_id') }}" class="w-full border rounded px-3 py-2">
                    @foreach ($styles as $style)
                        <option value="{{ $style->id }}">{{ $style->style_name }}</option>
                    @endforeach
                </select>
                @error('styles_id')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="hotline" class="block font-medium">Hotline</label>
                <input type="text" name="hotline" id="hotline" value="{{ old('hotline') }}" class="w-full border rounded px-3 py-2" >
                @error('hotline')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="opening_time" class="block font-medium">Giờ mở cửa</label>
                <input type="time" name="opening_time" id="opening_time" value="{{ old('opening_time') }}" class="w-full border rounded px-3 py-2" >
                @error('opening_time')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="closing_time" class="block font-medium">Giờ đóng cửa</label>
                <input type="time" name="closing_time" id="closing_time" value="{{ old('closing_time') }}" class="w-full border rounded px-3 py-2" >
                @error('closing_time')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="parking" class="block font-medium">Chỗ đậu xe</label>
                <input type="text" name="parking" id="parking" value="{{ old('parking') }}" class="w-full border rounded px-3 py-2" >
                @error('parking')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="wifi_password" class="block font-medium">Mật khẩu Wifi</label>
                <input type="text" name="wifi_password" id="wifi_password" value="{{ old('wifi_password') }}" class="w-full border rounded px-3 py-2" >
                @error('wifi_password')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="min_price" class="block font-medium">Giá tối thiểu (VNĐ)</label>
                <input type="number" step="0.01" name="min_price" id="min_price" value="{{ old('min_price') }}" class="w-full border rounded px-3 py-2" >
                @error('min_price')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="max_price" class="block font-medium">Giá tối đa (VNĐ)</label>
                <input type="number" step="0.01" name="max_price" id="max_price" value="{{ old('max_price') }}" class="w-full border rounded px-3 py-2" >
                @error('max_price')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Mô tả --}}
        <div class="mt-6">
            <label for="description" class="block font-medium">Mô tả</label>
            <textarea name="description" id="description" rows="4" 
                      class="w-full border rounded px-3 py-2"  >{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Ảnh --}}
        <div class="mt-6">
            <label for="images" class="block font-medium">Ảnh quán (chọn 4 ảnh)</label>
            <input type="file" name="images[]" id="images" multiple accept="image/*"  class="w-full border rounded px-3 py-2">
            @error('images')
            <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
            @error('images.*')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

            
        {{-- Ảnh menu --}}
        <div class="mt-6">
            <label for="menu_image" class="block font-medium">Ảnh thực đơn (menu):</label>
            <input type="file" name="menu_image" id="menu_image" class="w-full border rounded px-3 py-2" accept="image/*">
            <p class="text-red-500 text-sm" id="error-menu_image"></p>
        </div>
        @error('menu_image')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        {{-- Địa chỉ --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div>
                <input name="street" placeholder="Số nhà, tên đường" value="{{ old('street') }}" class="w-full border rounded px-3 py-2" >
                @error('street')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <input name="ward" placeholder="Phường/xã" value="{{ old('ward') }}" class="w-full border rounded px-3 py-2" >
                @error('ward')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <input name="district" placeholder="Quận/huyện" value="{{ old('district') }}" class="w-full border rounded px-3 py-2" >
                @error('district')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <input name="city" placeholder="Tỉnh/thành phố" value="{{ old('city') }}" class="w-full border rounded px-3 py-2" >
                @error('city')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <input name="country" placeholder="Quốc gia" value="Vietnam" class="w-full border rounded px-3 py-2" >
                @error('count')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <input name="postal_code" placeholder="Mã bưu điện" value="{{ old('postal_code') }}" class=" w-full border px-3 py-2 rounded" >
                @error('postal_code')
                <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Tọa độ (ẩn) --}}
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">

        {{-- Nút submit --}}
        <div class="mt-8">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded">
                Đăng ký quán
            </button>
        </div>
    </form>
</div>

<script>
const form = document.getElementById('registerForm');
form.addEventListener('submit', function (e) {
    e.preventDefault(); // Tránh form gửi đi ngay, để có thời gian gọi API lấy tọa độ.

    const street = document.querySelector('input[name="street"]').value; 
    const ward = document.querySelector('input[name="ward"]').value;
    const district = document.querySelector('input[name="district"]').value;
    const city = document.querySelector('input[name="city"]').value;
    const country = document.querySelector('input[name="country"]').value;
    const fullAddress = `${street}, ${ward}, ${district}, ${city}, ${country}`;  // Ghép các trường địa chỉ lại thành chuỗi đầy đủ.
    const encoded = encodeURIComponent(fullAddress); // Mã hóa địa chỉ để sử dụng trong URL.

    fetch(`https://nominatim.openstreetmap.org/search?q=${encoded}&format=json`, { //Gửi request đến OpenStreetMap API
            headers: {
                'Accept': 'application/json',
                'User-Agent': 'YourAppName/1.0 (tungocminh18@gmail.com)',
                'Referer': window.location.origin
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                const location = data[0];
                document.getElementById('latitude').value = location.lat;
                document.getElementById('longitude').value = location.lon;

                // submit form lại sau khi có tọa độ
                form.submit();
            } else {
                alert("Không tìm được tọa độ từ địa chỉ.");
            }
        })
        .catch(error => {
            console.error(error);
            alert("Lỗi khi gọi OpenStreetMap API.");
        });
});

</script>


@endsection