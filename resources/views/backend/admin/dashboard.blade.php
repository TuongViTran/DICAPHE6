@extends('backend.admin.layout')

@section('title', 'Dashboard')

@section('header', 'Dashboard')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

@section('content')

<div class="grid grid-cols-3 gap-4 mb-6">
    <!-- Tổng quán cà phê -->
    <div class="bg-blue-500 text-white p-4 rounded-xl flex items-center">
        <img src="{{ asset('backend/img/Icon (admin)/Icon_ tổng quán cf.svg') }}" alt="Home Icon" class="w-10 h-10">
        <div class="w-full ml-4">
            <h3 class="text-sm font-semibold">Tổng quán cà phê</h3>
            <div class="flex items-center">
                <p class="text-3xl font-bold">{{ $totalCoffeeshops }}</p>
                <span class="text-lg mx-2 opacity-80">|</span>
                <p class="text-sm opacity-80">quán</p>
            </div>
        </div>
    </div>

    <!-- Tổng người dùng -->
    <div class="bg-yellow-500 text-white p-4 rounded-xl flex items-center">
        <img src="{{ asset('backend/img/Icon (admin)/Icon_ người dùng.svg') }}" alt="User  Icon" class="w-10 h-10">
        <div class="w-full ml-4">
            <h3 class="text-sm font-semibold">Tổng người dùng</h3>
            <div class="flex items-center">
                <p class="text-3xl font-bold">{{ $totalUsers }}</p>
                <span class="text-lg mx-2 opacity-80">|</span>
                <div class="text-xs opacity-80">
                    <p>Khách hàng: {{ $customerCount }}</p>
                    <p>Chủ quán: {{ $ownerCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tổng bài viết -->
    <div class="bg-red-500 text-white p-4 rounded-xl flex items-center">
        <img src="{{ asset('backend/img/Icon (admin)/Icon_ tổng bài viết.svg') }}" alt="Post Icon" class="w-10 h-10">
        <div class="w-full ml-4">
            <h3 class="text-sm font-semibold">Tổng bài viết</h3>
            <div class="flex items-center">
                <p class="text-3xl font-bold">{{ $totalPosts }}</p>
                <span class="text-lg mx-2 opacity-80">|</span>
                <div class="text-xs opacity-80">
                    <p>Đã duyệt: {{ $approvedPostsCount }}</p>
                    <p>Chưa duyệt: {{ $unapprovedPostsCount }}</p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="col-span-2 bg-white p-4 rounded-lg shadow">
        <h3 class="text-lg font-bold mb-4">Lượng người dùng :</h3>
        <div class="flex space-x-6 mb-4">
            <div class="flex items-center space-x-6">
                <!-- Khách hàng -->
                <div class="flex items-center space-x-2">
                    <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <div class="w-10 h-5 bg-[#4ec7a7] rounded-full shadow-inner"></div>
                        <div class="dot absolute left-[2px] top-[2px] bg-white w-4 h-4 rounded-full shadow transition transform translate-x-5"></div>
                    </div>
                    <span class="text-gray-800 font-medium">Khách hàng</span>
                </div>

                <!-- Chủ quán -->
                <div class="flex items-center space-x-2">
                    <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                        <div class="w-10 h-5 bg-[#f5c41d] rounded-full shadow-inner"></div>
                        <div class="dot absolute left-[2px] top-[2px] bg-white w-4 h-4 rounded-full shadow transition transform translate-x-5"></div>
                    </div>
                    <span class="text-gray-800 font-medium">
                    Chủ quán</span>
                </div>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <canvas id="userChart" height="110"></canvas> <!-- Thay đổi chiều cao -->
        </div>
    </div>

    <div class="col-span-1 bg-white p-6 rounded-2xl shadow-md">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Khách hàng đăng kí gần đây :</h3>
            <a href="#" class="text-blue-500 text-sm font-semibold hover:underline">Xem thêm</a>
        </div>

        <ul class="space-y-5">
           @php
    $displayedUsers = $latestUsers->filter(function($user) {
        return in_array($user->role, ['user', 'owner']);
    })->take(4);
@endphp

<ul class="space-y-5">
    @forelse ($displayedUsers as $user)
        <li class="flex justify-between items-center">
            <div class="flex items-center gap-3 min-w-0">
                <img 
                    src="{{ $user->avatar_url ? asset('frontend/images/' . basename($user->avatar_url)) : asset('frontend/images/avt.png') }}"
                    onerror="this.onerror=null; this.src='{{ asset('frontend/images/avt.png') }}';"
                    alt="{{ $user->full_name }}"
                    class="w-12 h-12 rounded-full border border-gray-300 shadow-sm flex-shrink-0 object-cover"
                >
                <div class="min-w-0">
                    <p class="font-bold text-gray-800 truncate">{{ $user->full_name }}</p>
                    <p class="text-xs text-gray-500 leading-4">đã đăng kí thành công</p>
                    <p class="text-[10px] text-gray-400 leading-3">{{ $user->created_at->format('d/m/Y - H:i') }}</p>
                </div>
            </div>
            <span class="px-4 py-1 rounded-full text-xs font-semibold shadow-sm whitespace-nowrap
                @if ($user->role === 'user')
                    bg-green-100 text-green-700
                @elseif ($user->role === 'owner')
                    bg-orange-100 text-orange-700
                @endif
            ">
                {{ $user->role === 'user' ? 'Khách hàng' : 'Chủ quán' }}
            </span>
        </li>
    @empty
        <li class="text-center text-gray-500 text-sm">Chưa có người dùng mới.</li>
    @endforelse
</ul>

        </ul>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="md:col-span-2 flex gap-2">
        <!-- Bảng 5 sao -->
        <div class="bg-white p-3 rounded-lg shadow-md flex flex-col w-full">
            <h3 class="text-md font-semibold mb-2 text-gray-800 flex items-center">
                Các quán có đánh giá tốt nhất  ⭐⭐⭐⭐⭐
            </h3>
            <table class="w-full text-left border border-gray-200 rounded-lg overflow-hidden text-xs table-fixed">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="py-2 px-2">STT</th>
                        <th class="py-2 px-2">Tên quán</th>
                        <th class="py-2 px-2">Chủ</th>
                        <th class="py-2 px-2">Lượt</th>
                        <th class="py-2 px-2">Sao</th>
                        <th class="py-2 px-2">Trạng thái</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 align-top">
                    @foreach($fiveStarShops as $shop)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-2">{{ $loop->iteration }}</td>
                            <td class="py-2 px-2"><strong>{{ $shop->shop_name }}</strong></td>
                            <td class="py-2 px-2">{{ $shop->owner->full_name }}</td>
                            <td class="py-2 px-2">{{ number_format($shop->total_reviews_count) }}</td>
                            <td class="py-2 px-2">
                                <x-rating :score="$shop->reviews_avg_rating" />
                                <br>
                                {{ $shop->reviews_avg_rating }}
                            </td>
                            <td class="py-2 px-2">
                                <span title="Tổng {{ $shop->five_star_reviews_count ?? 0 }} lượt đánh giá 5 sao"
                                      class="flex items-center gap-1 px-2 py-0.5 bg-green-100 text-green-700 text-[10                                    px] rounded-full">
                                    ✅ Tốt
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Bảng đánh giá thấp -->
        <div class="bg-white p-3 rounded-lg shadow-md flex flex-col w-full">
            <h3 class="text-md font-semibold mb-2 text-gray-800 flex items-center">
                Các quán có đánh giá thấp ⭐
            </h3>
            <table class="w-full text-left border border-gray-200 rounded-lg overflow-hidden text-xs table-fixed">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="py-2 px-2">STT</th>
                        <th class="py-2 px-2">Tên quán</th>
                        <th class="py-2 px-2">Chủ</th>
                        <th class="py-2 px-2">Lượt</th>
                        <th class="py-2 px-2">Sao</th>
                        <th class="py-2 px-2">Trạng thái</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 align-top">
                    @foreach($worstShops as $shop)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-2">{{ $loop->iteration }}</td>
                            <td class="py-2 px-2"><strong>{{ $shop->shop_name }}</strong></td>
                            <td class="py-2 px-2">{{ $shop->owner->full_name }}</td>
                            <td class="py-2 px-2">{{ number_format($shop->total_reviews_count) }}</td>
                            <td class="py-2 px-2">
                                <x-rating :score="$shop->reviews_avg_rating" />
                                <br>
                                {{ $shop->reviews_avg_rating }}
                            </td>
                            <td class="py-2 px-2">
                                <span class="flex items-center gap-1 px-2 py-0.5 bg-red-100 text-red-700 text-xs rounded-full whitespace-nowrap">
                                    ⚠️Chú ý
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Cột bên phải (Từ khóa & Thống kê style) -->
    <div class="md:col-span-1 flex flex-col gap-4">
        <!-- Box từ khóa -->
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-3">🔍 Từ khóa được tìm kiếm nhiều nhất</h3>
            <ul class="text-gray-700 space-y-2 text-sm">
                <li>1. Quán cà phê <span class="italic">"sống ảo"</span></li>
                <li>2. Phong cách Japandi</li>
                <li>3. Quán cà phê container</li>
            </ul>
        </div>

        <!-- Box thống kê style -->
        <div class="bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-3">📊 Thống kê style</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span>Truyền thống</span>
                    <span class="font-bold">80%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-yellow-500 h-2 rounded-full" style="width: 80%;"></div>
                </div>

                <div class="flex justify-between">
                    <span>Hiện đại</span>
                    <span class="font-bold">50%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-yellow-500 h-2 rounded-full" style="width: 50%;"></div>
                </div>

                <div class="flex justify-between">
                    <span>Working</span>
                    <span class="font-bold">30%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-yellow-500 h-2 rounded-full" style="width: 30%;"></div>
                </div>

                <div class="flex justify-between">
                    <span>Nhà máy</span>
                    <span class="font-bold">60%</span>
                </div>
                <div class="w-full bg-gray-200                 rounded-full h-2">
                    <div class="bg-yellow-500 h-2 rounded-full" style="width: 60%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('userChart').getContext('2d');
    const userChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7'],
            datasets: [
                {
                    label: 'Khách hàng',
                    data: [{{ implode(',', $userCounts) }}], // Dữ liệu cho khách hàng
                    backgroundColor: '#4ec7a7', // Màu xanh lá cây nhẹ
                    borderWidth: 1
                },
                {
                    label: 'Chủ quán',
                    data: [30, 40, 35, 50, 45, 60, 55], // Dữ liệu cho chủ quán (có thể thay đổi theo dữ liệu thực tế)
                    backgroundColor: '#f5c41d', // Màu vàng nhẹ
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection