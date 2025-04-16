@extends('backend.admin.layout')

@section('title', 'Thêm Mới Quán Cà Phê')

@section('header', 'Thêm Mới Quán Cà Phê')

@section('content')
    <h1 class="text-xl font-semibold mb-4">Thêm Mới Quán Cà Phê</h1>

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

    <form action="{{ route('coffeeshop.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="shop_name" class="block text-sm font-medium text-gray-700">Tên quán:</label>
            <input type="text" name="shop_name" id="shop_name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500" value="{{ old('shop_name') }}">
            @error('shop_name')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Số điện thoại:</label>
            <input type="text" name="phone" id="phone" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500" value="{{ old('phone') }}">
            @error('phone')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="user_id" class="block text-sm font-medium text-gray-700">Người quản lý:</label>
            <select name="user_id" id="user_id" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
                <option value="">Chọn người quản lý</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->full_name }}</option>
                @endforeach
            </select>
            @error('user_id')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="styles_id" class="block text-sm font-medium text-gray-700">Phong cách:</label>
            <select name="styles_id" id="styles_id" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
                <option value="">Chọn phong cách</option>
                @foreach ($styles as $style)
                    <option value="{{ $style->id }}" {{ old('styles_id') == $style->id ? 'selected' : '' }}>{{ $style->name }}</option>
                @endforeach
            </select>
            @error('styles_id')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">Địa chỉ:</label>
    
    <input type="text" name="street" placeholder="Đường" class="mt-1 block w-full border rounded-md shadow-sm mb-2" value="{{ old('street') }}">
    @error('street')
        <div class="text-red-500 text-sm">{{ $message }}</div>
    @enderror

    <input type="text" name="ward" placeholder="Phường/Xã" class="mt-1 block w-full border rounded-md shadow-sm mb-2" value="{{ old('ward') }}">
    @error('ward')
        <div class="text-red-500 text-sm">{{ $message }}</div>
    @enderror

    <input type="text" name="district" placeholder="Quận/Huyện" class="mt-1 block w-full border rounded-md shadow-sm mb-2" value="{{ old('district') }}">
    @error('district')
        <div class="text-red-500 text-sm">{{ $message }}</div>
    @enderror

    <input type="text" name="city" placeholder="Thành phố/Tỉnh" class="mt-1 block w-full border rounded-md shadow-sm" value="{{ old('city') }}">
    @error('city')
        <div class="text-red-500 text-sm">{{ $message }}</div>
    @enderror
</div>


        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Trạng thái:</label>
            <select name="status" id="status" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500">
                <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Mở</option>
                <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Đóng</option>
            </select>
            @error('status')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="rating" class="block text-sm font-medium text-gray-700">Đánh giá:</label>
            <input type="number" name="rating" id="rating" min="0" max="5" step="0.1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-500" value="{{ old('rating') }}">
            @error('rating')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror
            <form action="{{ route('coffeeshop.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
   
    <div>
        <label for="cover_image">Ảnh bìa:</label>
        <input type="file" name="cover_image" accept="image/*" required>
    </div>
    <button type="submit">Thêm quán</button>
</form>


        <button type="submit" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600 transition duration-200">Thêm mới</button>
    </form>
@endsection