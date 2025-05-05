@extends('backend.admin.layout')

@section('title', 'Quản lý quán cà phê')

@section('header', 'Quản lý quán cà phê')

@section('content')
    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4 shadow-md">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-500 text-white p-4 rounded mb-4 shadow-md">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white p-4 rounded shadow-md overflow-x-auto">
        <table class="min-w-full text-sm text-center">
            <thead class="bg-gray-200 text-gray-800">
                <tr>
                    <th class="py-3 px-4">ID</th>
                    <th class="py-3 px-4">Tên quán</th>
                    <th class="py-3 px-4">SĐT</th>
                    <th class="py-3 px-4">Người quản lý</th>
                    <th class="py-3 px-4">Phong cách</th>
                    <th class="py-3 px-4">Trạng thái</th>
                    <th class="py-3 px-4">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($coffeeShops as $shop)
                    <tr class="bg-white border-b">
                        <td class="py-2 px-4">{{ $shop->id }}</td>
                        <td class="py-2 px-4">{{ $shop->shop_name }}</td>
                        <td class="py-2 px-4">{{ $shop->phone ?? 'Chưa có' }}</td>
                        <td class="py-2 px-4">{{ $shop->user->full_name ?? 'Chưa có' }}</td>
                        <td class="py-2 px-4">{{ $shop->style->style_name ?? 'Không rõ' }}</td>
                        <td class="py-2 px-4">{{ ucfirst($shop->status) }}</td>
                        <td class="py-2 px-4">
                            <button onclick="toggleDetails({{ $shop->id }})"
                                class="text-blue-600 underline hover:text-blue-800">Xem thêm</button>
                        </td>
                    </tr>

                    <tr id="details-{{ $shop->id }}" class="hidden bg-gray-100">
                        <td colspan="7" class="p-4 text-left">
                            <div><strong>Địa chỉ:</strong> {{ $shop->address->street ?? 'Chưa có địa chỉ' }}</div>
                            <div><strong>Mô tả:</strong> {{ $shop->description ?? 'Không có mô tả' }}</div>
                            <div><strong>Giờ mở cửa:</strong> {{ $shop->opening_time ?? '-' }}</div>
                            <div><strong>Giờ đóng cửa:</strong> {{ $shop->closing_time ?? '-' }}</div>
                            <div><strong>Bãi đỗ xe:</strong> {{ $shop->parking ?? '-' }}</div>
                            <div><strong>WiFi:</strong> {{ $shop->wifi_password ?? '-' }}</div>
                            <div><strong>Hotline:</strong> {{ $shop->hotline ?? '-' }}</div>
                            <div><strong>Giá:</strong> {{ $shop->min_price }}đ - {{ $shop->max_price }}đ</div>
                            <div class="mt-2"><strong>Đánh giá trung bình:</strong>
                                <x-rating :score="$shop->reviews_avg_rating ?? 0" />
                            </div>
                            <div class="mt-2"><strong>Ảnh:</strong></div>
                            <div class="flex gap-2 mt-1">
                                @foreach (['cover_image', 'image_1', 'image_2', 'image_3'] as $img)
                                    @if($shop->$img)
                                        <img src="{{ asset('frontend/images/' . $shop->$img) }}" class="w-16 h-16 object-cover rounded" />
                                    @endif
                                @endforeach
                            </div>
                            <div class="mt-3">
                                <form action="{{ route('coffeeshop.destroy', $shop) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Xóa</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach

                @if($coffeeShops->isEmpty())
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">Không có quán cà phê nào.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <script>
        function toggleDetails(id) {
            const row = document.getElementById('details-' + id);
            row.classList.toggle('hidden');
        }
    </script>
@endsection
