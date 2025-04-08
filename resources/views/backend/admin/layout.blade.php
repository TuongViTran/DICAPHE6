<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .column-layout {
            display: flex;
            flex-direction: column; /* Xếp dọc */
            gap: 20px; /* Tạo khoảng cách giữa các khối */
            max-width: 400px; /* Điều chỉnh chiều rộng tối đa nếu cần */
        }
        img {
            display: block;
            margin: 0 auto; /* Căn giữa theo chiều ngang */
            max-width: 80%; /* Giữ kích thước hợp lý */
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-1/5 bg-white h-screen sticky top-0 shadow-lg p-6 overflow-y-auto">
        <div class="flex items-center mb-8">
    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <img src="{{ asset('backend/img/Icon (admin)/Logo.svg') }}" alt="Logo">
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
        @csrf
    </form>
</div>

            <nav>
                <ul>
                    <li class="mb-4">
                    <a href="{{ url('/dashboard') }}" class="flex items-center text-blue-500 bg-blue-100 p-3 rounded-lg hover:bg-blue-200 transition">
                            <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                        </a>
                    </li>
                    <li class="mb-4">
                    <a href="{{ route('user.management') }}" class="flex items-center text-gray-600 p-3 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-users mr-3"></i> Quản lý người dùng
                        </a>
                    </li>
                    <li class="mb-4">
                    <a href="{{ route('coffeeshops_management') }}" class="flex items-center text-gray-600 p-3 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-file-alt mr-3"></i> Quản lý bài viết
                        </a>
                    </li>
                    <li class="mb-4">
                    <a href="{{ route('promotions_management') }}" class="flex items-center text-gray-600 p-3 rounded-lg hover:bg-gray-200 transition">
    <i class="fas fa-tags mr-3"></i> Quản lý khuyến mãi
</a>
                    </li>
                    <li class="mb-4">
                    <a href="{{ route('cafes_management') }}" class="flex items-center text-gray-600 p-3 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-search mr-3"></i> Quản lý tìm kiếm
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="flex items-center text-gray-600 p-3 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-paint-brush mr-3"></i> Quản lý phong cách
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="flex items-center text-gray-600 p-3 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-rss mr-3"></i> Quản lý feed
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center text-gray-600 p-3 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-cog mr-3"></i> Cài đặt
                        </a>
                    </li>
                    <li class="mt-6">
                        <a href="{{ route('register') }}" class="flex items-center text-red-600 p-3 rounded-lg hover:bg-red-100 transition">
                            <i class="fas fa-sign-out-alt mr-3"></i> Đăng xuất
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- Main Content -->
        <div class="w-4/5 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">@yield('header', 'Dashboard')</h2>
                
                <div class="flex items-center bg-white p-3 rounded-full shadow-lg space-x-5">
                    <!-- Thanh tìm kiếm (được kéo dài) -->
                    <div class="flex items-center border border-gray-300 rounded-full px-4 py-2 w-96">
                        <input type="text" placeholder="Tìm kiếm" class="outline-none flex-1 bg-transparent text-gray-700 placeholder-gray-400">
                        <i class="fas fa-search text-gray-500 hover:text-blue-500 transition duration-300 cursor-pointer"></i>
                    </div>
            
                    <!-- Icon nhóm (thông báo, hỗ trợ, avatar) -->
                    <div class="flex items-center space-x-4">
                        <!-- Chuông thông báo -->
                        <div class="relative w-10 h-10 flex items-center justify-center bg-gray-200 rounded-full shadow-md cursor-pointer hover:bg-gray-300 transition duration-300">
                            <i class="fas fa-bell text-gray-600 text-lg"></i>
                            <span class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">10</span>
                        </div>
            
                        <!-- Hỗ trợ -->
                        <div class="w-10 h-10 flex items-center justify-center bg-gray-200 rounded-full shadow-md cursor-pointer hover:bg-gray-300 transition duration-300">
                            <i class="fas fa-question-circle text-gray-600 text-lg"></i>
                        </div>
            
                        <div class="flex items-center space-x-2">
    <!-- Avatar -->
    <div class="w-10 h-10 rounded-full border-2 border-yellow-400 shadow-md cursor-pointer overflow-hidden">
        <img src="{{ asset('backend/img/Icon (admin)/admin.jpg') }}" alt="Avatar" class="w-full h-full object-cover">
    </div>
    <span class="text-lg font-bold text-black-600 mt-1 ">Tường vi</span> 
</div>
                    </div>
                </div>
            </div>
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>