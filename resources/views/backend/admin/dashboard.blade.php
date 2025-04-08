@extends('backend.admin.layout')


@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
    <div class="grid grid-cols-3 gap-4 mb-6">
        <!-- Tổng quán cà phê -->
        <div class="bg-blue-500 text-white p-4 rounded-xl flex items-center">
        <img src="{{ asset('backend/img/Icon (admin)/Icon_ tổng quán cf.svg') }}" alt="Home Icon" class="w-10 h-10">
            <div class="w-full ml-4">
                <h3 class="text-sm font-semibold">Tổng quán cà phê</h3>
                <div class="flex items-center">
                    <p class="text-3xl font-bold">150</p>
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
                    <p class="text-3xl font-bold">150</p>
                    <span class="text-lg mx-2 opacity-80">|</span>
                    <div class="text-xs opacity-80">
                        <p>Khách hàng: 120</p>
                        <p>Chủ quán: 30</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tổng bài viết -->
        <div class="bg-red-500 text-white p-4 rounded-xl flex items-center">
        <img src="{{ asset('backend/img/Icon (admin)/Icon_ người dùng.svg') }}" alt="Message Icon" class="w-10 h-10">
            <div class="w-full ml-4">
                <h3 class="text-sm font-semibold">Tổng bài viết</h3>
                <div class="flex items-center">
                    <p class="text-3xl font-bold">150</p>
                    <span class="text-lg mx-2 opacity-80">|</span>
                    <div class="text-xs opacity-80">
                        <p>Đã duyệt: 120</p>
                        <p>Chưa duyệt: 30</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="col-span-2 bg-white p-4 rounded-lg shadow">
            <h3 class="text-lg font-bold mb-4">Lượng người dùng :</h3>
            <div class="flex space-x-6 mb-4">
                <div class="flex items-center">
                    <span class="w-4 h-4 bg-green-500 rounded-full inline-block mr-2 shadow-md"></span> Khách hàng
                </div>
                <div class="flex items-center">
                    <span class="w-4 h-4 bg-yellow-500 rounded-full inline-block mr-2 shadow-md"></span> Chủ quán
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <canvas id="userChart" height="110"></canvas> <!-- Thay đổi chiều cao -->
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
                    data: [120, 150, 100, 130, 160, 140, 180], // Dữ liệu cho khách hàng
                    backgroundColor: 'rgba(144, 238, 144, 0.6)', // Màu xanh lá cây nhẹ
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Chủ quán',
                    data: [30, 40, 35, 50, 45, 60, 55], // Dữ liệu cho chủ quán
                    backgroundColor: 'rgba(255, 255, 224, 0.6)', // Màu vàng nhẹ
                    borderColor: 'rgba(255, 99, 132, 1)',
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
<div class="bg-white p-4 rounded-lg shadow relative">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-bold">Khách hàng đăng kí gần đây :</h3>
        <a href="#" class="text-blue-500 text-sm font-semibold hover:underline">Xem thêm</a>
    </div>
    <ul>
        @php
            $users = [
                ['name' => 'Hoàng Long', 'role' => 'Khách hàng', 'time' => '24/11/2025 - 08:56'],
                ['name' => 'Nguyễn Văn An', 'role' => 'Chủ quán', 'time' => '24/11/2025 - 09:00'],
                ['name' => 'Trần Thị Thúy ', 'role' => 'Khách hàng', 'time' => '24/11/2025 - 09:15'],
                ['name' => 'Lê Thảo ', 'role' => 'Chủ quán', 'time' => '24/11/2025 - 09:30'],
            ];
        @endphp
        @foreach ($users as $user)
            <li class="flex items-center justify-between mb-4">
                <div class="flex items-center flex-grow">
                    <div>
                        <img src="https://i.pravatar.cc/40?u={{ $loop->index }}" alt="Avatar" class="w-10 h-10 rounded-full mr-3 border border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <p class="font-bold">{{ $user['name'] }}</p>
                        <p class="text-sm text-gray-600">đã đăng kí thành công</p>
                        <p class="text-xs text-gray-500">{{ $user['time'] }}</p>
                    </div>
                </div>
                <span class="bg-{{ $user['role'] == 'Khách hàng' ? 'green-100' : 'orange-100' }} text-{{ $user['role'] == 'Khách hàng' ? 'green-700' : 'red-700' }} text-xs font-semibold px-3 py-1 rounded-2xl shadow-sm">
                    {{ $user['role'] }}
                </span>
            </li>
        @endforeach
    </ul>
</div>
</div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2 flex gap-2">
            <!-- Bảng 5 sao -->
            <div class="bg-white p-3 rounded-lg shadow-md flex flex-col w-full">
                <h3 class="text-md font-semibold mb-2 text-gray-800 flex items-center">
                    Top quán đánh giá 5 sao  ⭐⭐⭐⭐⭐
                </h3>
                <table class="w-full text-left border border-gray-200 rounded-lg overflow-hidden text-xs table-fixed">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="py-2 px-2">STT</th>
                            <th class="py-2 px-2">Tên quán</th>
                            <th class="py-2 px-2">Chủ</th>
                            <th class="py-2 px-2">Lượt</th>
                            <th class="py-2 px-2">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 align-top">
                        @for ($k = 1; $k <= 5; $k++)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-2">{{ $k }}</td>
                                <td class="py-2 px-2">Quán {{ $k }}</td>
                                <td class="py-2 px-2">Chủ quán {{ $k }}</td>
                                <td class="py-2 px-2">202k</td>
                                <td class="py-2 px-2">
                                    <span class="flex items-center gap-1 px-2 py-0.5 bg-green-100 text-green-700 text-[10px] rounded-full">
                                        ✅ Đạt
                                    </span>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            <!-- Bảng 1 sao -->
            <div class="bg-white p-3 rounded-lg shadow-md flex flex-col w-full">
                <h3 class="text-md font-semibold mb-2 text-gray-800 flex items-center">
                    Top quán đánh giá 1 sao  ⭐
                </h3>
                <table class="w-full text-left border border-gray-200 rounded-lg overflow-hidden text-xs table-fixed">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="py-2 px-2">STT</th>
                            <th class="py-2 px-2">Tên quán</th>
                            <th class="py-2 px-2">Chủ</th>
                            <th class="py-2 px-2">Lượt</th>
                            <th class="py-2 px-2">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 align-top">
                        @for ($l = 1; $l <= 5; $l++)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-2">{{ $l }}</td>
                                <td class="py-2 px-2">Quán Tĩnh Lặng</td>
                                <td class="py-2 px-2">Hoài An</td>
                                <td class="py-2 px-2">120k</td>
                                <td class="py-2 px-2">
                                    <span class="flex items-center gap-1 px-2 py-0.5 bg-red-100 text-red-700 text-xs rounded-full whitespace-nowrap">
                                        ⚠️Chú ý
                                    </span>
                                </td>
                            </tr>
                        @endfor
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
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-yellow-500 h-2 rounded-full" style="width: 60%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection