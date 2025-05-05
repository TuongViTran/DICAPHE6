@extends('backend.admin.layout')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Tổng quán cà phê -->
    <div class="bg-blue-500 text-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
        <div class="flex items-center space-x-4">
            <img src="{{ asset('backend/img/Icon (admin)/Icon_ tổng quán cf.svg') }}" class="w-12 h-12" alt="Home Icon">
            <div>
                <h3 class="text-lg font-bold tracking-wide mb-1">Tổng quán cà phê</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-4xl font-extrabold">{{ $totalCoffeeshops }}</span>
                    <span class="text-sm">quán</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tổng người dùng -->
    <div class="bg-yellow-500 text-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
        <div class="flex items-center space-x-4">
            <img src="{{ asset('backend/img/Icon (admin)/Icon_ người dùng.svg') }}" class="w-12 h-12" alt="User Icon">
            <div>
                <h3 class="text-lg font-bold tracking-wide mb-1">Tổng người dùng</h3>
                <div class="flex flex-col">
                    <span class="text-4xl font-extrabold">{{ $totalUsers }}</span>
                    <small>Khách hàng: {{ $customerCount }} | Chủ quán: {{ $ownerCount }}</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tổng bài viết -->
    <div class="bg-red-500 text-white p-6 rounded-2xl shadow-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300">
        <div class="flex items-center space-x-4">
            <img src="{{ asset('backend/img/Icon (admin)/Icon_ tổng bài viết.svg') }}" class="w-12 h-12" alt="Post Icon">
            <div>
                <h3 class="text-lg font-bold tracking-wide mb-1">Tổng bài viết</h3>
                <div class="flex flex-col">
                    <span class="text-4xl font-extrabold">{{ $totalPosts }}</span>
                    
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Biểu đồ -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="col-span-2 bg-white p-6 rounded-2xl shadow-lg">
        <h3 class="text-lg font-bold mb-4 text-gray-700">📈Biểu đồ tăng trưởng tài khoản</h3>
        <canvas id="userChart" height="110"></canvas>
    </div>

    <!-- Khách hàng mới -->
    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <div class="flex justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-700">🧑‍💼 Khách hàng mới</h3>
            <a href="#" class="text-blue-500 hover:underline text-sm">Xem thêm</a>
        </div>
        <ul class="space-y-5">
            @php
                $displayedUsers = $latestUsers->filter(fn($user) => in_array($user->role, ['user', 'owner']))->take(4);
            @endphp

            @forelse ($displayedUsers as $user)
            <li class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                <img 
                                    src="{{ asset('storage/uploads/avatars/' . basename($user->avatar_url)) }}"
                                    onerror="this.onerror=null; this.src='{{ asset('frontend/images/avt.png') }}';"
                                    alt="Avatar" 
                                    style="width: 10%; height: 10%; object-fit: cover;"
                                >
                    <div>
                        <p class="font-bold text-gray-800">{{ $user->full_name }}</p>
                        <p class="text-xs text-green-500 flex items-center gap-1">
                            <i class="fas fa-user-check"></i> Đã đăng kí
                        </p>
                        <p class="text-[10px] text-gray-400">{{ $user->created_at->format('d/m/Y - H:i') }}</p>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-semibold whitespace-nowrap
    {{ $user->role === 'user' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
    {{ $user->role === 'user' ? 'Khách hàng' : 'Chủ quán' }}
</span>

            </li>
            @empty
            <li class="text-center text-gray-500">Chưa có người dùng mới.</li>
            @endforelse
        </ul>
    </div>
</div>

<!-- Bảng đánh giá -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="md:col-span-2 grid grid-cols-1 gap-6">
        <!-- 5 sao -->
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h3 class="text-lg font-bold mb-3 text-black flex items-center gap-2">⭐⭐⭐⭐⭐ Quán đánh giá tốt</h3>
            <table class="w-full text-sm text-left table-fixed">
                <thead class="bg-green-100 text-green-800">
                    <tr>
                        <th class="py-2">STT</th>
                        <th class="py-2">Tên quán</th>
                        <th class="py-2">Chủ quán</th>
                        <th class="py-2">Lượt</th>
                        <th class="py-2">Sao</th>
                        <th class="py-2">Trạng thái</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($fiveStarShops as $shop)
                    <tr class="hover:bg-green-50">
                        <td class="py-2">{{ $loop->iteration }}</td>
                        <td class="py-2 font-semibold">{{ $shop->shop_name }}</td>
                        <td class="py-2">{{ $shop->owner->full_name }}</td>
                        <td class="py-2">{{ number_format($shop->total_reviews_count) }}</td>
                        <td class="py-2 px-2">
                                <x-rating :score="$shop->reviews_avg_rating" />
                                <br>
                                {{ $shop->reviews_avg_rating }}
                            </td>
                        <td class="py-2">
                            <span class="bg-green-200 text-green-800 px-2 py-1 rounded-full text-xs">Tốt</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- 1 sao -->
        <div class="bg-white p-6 rounded-2xl shadow-lg">
        <h3 class="text-lg font-bold mb-3 text-black flex items-center gap-2">⭐ Quán đánh giá thấp</h3>

            <table class="w-full text-sm text-left table-fixed">
                <thead class="bg-red-100 text-red-800">
                    <tr>
                        <th class="py-2">STT</th>
                        <th class="py-2">Tên quán</th>
                        <th class="py-2">Chủ quán</th>
                        <th class="py-2">Lượt</th>
                        <th class="py-2">Sao</th>
                        <th class="py-2">Trạng thái</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($worstShops as $shop)
                    <tr class="hover:bg-red-50">
                        <td class="py-2">{{ $loop->iteration }}</td>
                        <td class="py-2 font-semibold">{{ $shop->shop_name }}</td>
                        <td class="py-2">{{ isset($shop->owner) ? $shop->owner->full_name : 'Không xác định' }}</td>

                        <td class="py-2">{{ number_format($shop->total_reviews_count) }}</td>
                        <td class="py-2 px-2">
                                <x-rating :score="$shop->reviews_avg_rating" />
                                <br>
                                {{ $shop->reviews_avg_rating }}
                            </td>
                        <td class="py-2">
                            <span class="bg-red-200 text-red-800 px-2 py-1 rounded-full text-xs">Chú ý</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Từ khóa và Style -->
    <div class="flex flex-col gap-6">
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h3 class="text-lg font-bold mb-3">🔎 Từ khóa phổ biến</h3>
            <ul class="space-y-2 text-gray-700">
                <li>1. Quán cà phê "sống ảo"</li>
                <li>2. Phong cách Japandi</li>
                <li>3. Quán cà phê container</li>
            </ul>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <h3 class="text-lg font-bold mb-3">📊 Thống kê Style</h3>
            <div class="space-y-2">
                <div>
                    <div class="flex justify-between">
                        <span>Truyền thống</span><span>80%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                        <div class="bg-yellow-400 h-2 rounded-full" style="width: 80%;"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between">
                        <span>Hiện đại</span><span>50%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                        <div class="bg-yellow-400 h-2 rounded-full" style="width: 50%;"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between">
                        <span>Working</span><span>30%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                        <div class="bg-yellow-400 h-2 rounded-full" style="width: 30%;"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between">
                        <span>Nhà máy</span><span>60%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                        <div class="bg-yellow-400 h-2 rounded-full" style="width: 60%;"></div>
                    </div>
                </div>
                
            </div>
        </div>
        

        <div class="bg-white p-6 rounded-2xl shadow-lg">
    <h3 class="text-lg font-bold mb-4 text-black flex items-center gap-2">
        💬 Phản hồi nổi bật
    </h3>
    <ul class="space-y-5">
        @foreach($featuredFeedbacks as $feedback)
        <li class="flex items-start space-x-3">
        <img 
                                    src="{{ asset('storage/uploads/avatars/' . basename($user->avatar_url)) }}"
                                    onerror="this.onerror=null; this.src='{{ asset('frontend/images/avt.png') }}';"
                                    alt="Avatar" 
                                    style="width: 10%; height: 10%; object-fit: cover;"
                                >
    <div class="flex-1">
        <p class="font-semibold text-gray-800">{{ $feedback->user->full_name }}</p>
        
        <p class="text-sm text-gray-500">
    Quán: {{ $feedback->shop->shop_name ?? 'Không rõ' }}
</p>


        <p class="text-sm text-gray-600 italic truncate max-w-xs">
            "{{ $feedback->content ?: 'Không có nội dung' }}"
        </p>

        <div class="flex items-center gap-1 text-yellow-400 mt-1">
            @for($i = 0; $i < floor($feedback->rating); $i++)
                <i class="fas fa-star"></i>
            @endfor
        </div>
    </div>
</li>

        @endforeach

        @if($featuredFeedbacks->isEmpty())
            <li class="text-gray-500 text-center">Chưa có phản hồi nổi bật.</li>
        @endif
    </ul>
</div>

    </div>
</div>

<!-- Script Chart -->
<script>
const ctx = document.getElementById('userChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Biểu đồ',],
        datasets: [
            {
                label: 'Khách hàng',
                data: [{{ implode(',', $userCounts) }}], // Dữ liệu động cho số lượng khách hàng trong tháng
                backgroundColor: '#4ec7a7'
            },
            {
                label: 'Chủ quán',
                data: [{{ implode(',', $ownerCounts) }}], // Dữ liệu động cho số lượng chủ quán trong tháng
                backgroundColor: '#f5c41d'
            }
        ]
    },
    options: {
        animation: {
            duration: 2000,
            easing: 'easeInOutElastic'
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

</script>

@endsection
