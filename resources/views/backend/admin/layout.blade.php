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
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg flex flex-col justify-between h-screen sticky top-0 p-6">
        <div>
            <div class="mb-10 text-center">
                <a>
                    <img src="{{ asset('backend/img/Icon (admin)/Logo.svg') }}" alt="Logo" class="mx-auto w-32">
                </a>              
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
                            <i class="fas fa-file-alt mr-3"></i> Quản lý quán 
                        </a>
                    </li>
                    <li class="mb-4">
                    <a href="{{ route('promotions_management') }}" class="flex items-center text-gray-600 p-3 rounded-lg hover:bg-gray-200 transition">
    <i class="fas fa-tags mr-3"></i> Quản lý khuyến mãi
</a>
                    </li>
                    <li class="mb-4">
                    <a href="{{ route('search_management') }}" class="flex items-center text-gray-600 p-3 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-search mr-3"></i> Quản lý tìm kiếm
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="#" class="flex items-center text-gray-600 p-3 rounded-lg hover:bg-gray-200 transition">
                            <i class="fas fa-paint-brush mr-3"></i> Quản lý phong cách
                        </a>
                    </li>
                    <li class="mb-4">
                        <a href="{{ route('feed.index') }}" class="flex items-center text-gray-600 p-3 rounded-lg hover:bg-gray-200 transition">
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

        <div class="mt-10">
            <a href="{{ route('register') }}" class="flex items-center justify-center p-3 rounded-lg text-red-600 hover:bg-red-100">
                <i class="fas fa-sign-out-alt mr-3"></i> Đăng xuất
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col p-6 overflow-y-auto">

        <!-- Header -->
        <header class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">@yield('header', 'Dashboard')</h1>

            <div class="flex items-center space-x-6">
                <!-- Search -->
                <div class="flex items-center bg-white border rounded-full shadow px-4 py-2 w-80">
                    <input type="text" placeholder="Tìm kiếm..." class="bg-transparent outline-none flex-1 text-gray-700">
                    <i class="fas fa-search text-gray-400"></i>
                </div>

                <!-- Notification & Support & Avatar -->
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div class="w-10 h-10 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300 cursor-pointer">
                            <i class="fas fa-bell text-gray-600"></i>
                        </div>
                        <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5">10</span>
                    </div>
                    <div class="w-10 h-10 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300 cursor-pointer">
                        <i class="fas fa-question-circle text-gray-600"></i>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-yellow-400">
                            <img src="{{ $adminAvatar ? asset('frontend/images/' . basename($adminAvatar)) : asset('frontend/images/avt.png') }}" alt="Admin Avatar" class="object-cover w-full h-full">
                        </div>
                        <span class="font-semibold text-gray-700">{{ $adminName ?? 'Admin' }}</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Section -->
        <main class="bg-white rounded-lg p-6 shadow-md">
            @yield('content')
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
