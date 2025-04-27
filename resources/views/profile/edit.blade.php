<!-- resources/views/frontend/layout.blade.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Trang chủ')</title>
<link rel="stylesheet" href="{{ asset('frontend/css/layout.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/footer.css') }}">
<!-- Bootstrap CSS -->
<!-- Bootstrap 5.1.3 JS (Bundle includes Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>

<!-- Bootstrap JS -->
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/24875ac8f5.js" crossorigin="anonymous"></script>
<!-- Thêm Google Places API -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDfOjgSqISKR-JKrx5BeJim8bKFFMt9yIU=places&callback=initAutocomplete" async defer></script>

</head>
<body>
<header>
    <!-- Logo -------------------->
    <div class="logo">
        <img src="{{ asset('frontend/images/Logo.svg') }}" alt="Cà Phê Đi Đâu?">
    </div>

    <!-- Navigation -------------------->
    <nav class="navbar">
        <ul class="nav-list">
            <li class="{{ request()->routeIs('trangchu') ? 'active' : '' }}">
                <a href="{{ route('trangchu') }}">
                    <span class="icon"><img src="{{ asset('frontend/images/icon_trangchu.svg') }}" alt="Trang chủ"></span>
                    <span>Trang chủ</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('feed') ? 'active' : '' }}">
                <a href="{{ route('feed') }}">
                    <span class="icon"><img src="{{ asset('frontend/images/icon_feed.svg') }}" alt="Feed"></span>
                    <span>Feed</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('tintuc') ? 'active' : '' }}">
                <a href="{{ route('tintuc') }}">
                    <span class="icon"><img src="{{ asset('frontend/images/icon_tintuc.svg') }}" alt="Tin tức"></span>
                    <span>Blog</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('thongbao') ? 'active' : '' }}">
                <a href="{{ route('thongbao') }}" class="d-flex align-items-center position-relative">
                    <span class="icon position-relative">
                        <img src="{{ asset('frontend/images/icon_thongbao.svg') }}" alt="Thông báo">

                        @if (isset($unreadCount) && $unreadCount > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                                style="font-size: 0.65rem; padding: 4px 6px;">
                                {{ $unreadCount }}
                                <span class="visually-hidden">thông báo chưa đọc</span>
                            </span>
                        @endif
                    </span>
                    <span class="ms-2">Thông báo</span>
                </a>
            </li>

        </ul>
</nav>
    
    <!-- <div class="right-section">
        <div class="location-info">
        <span class="location-title">Tọa độ:</span>
        <span class="latitude">Đang tải vĩ độ...</span>
        <span class="longitude">Đang tải kinh độ...</span>
    </div> -->
    <!-- Thời tiết -------------------->
        <div class="weather">
            <span class="weather-icon">☀️</span>
            <span class="weather-info">Đang tải...</span>
            <span class="weather-info">|</span>
            <div class="date-info">Đang tải ngày...</div>
        </div>

       <!-- Kiểm tra trạng thái đăng nhập -->
        
    <div class="auth-buttons">
      @auth
      
        <div class="user-menu" id="user-menu">
            <span class="user-role {{ Auth::user()->role === 'owner' ? 'owner-role' : 'customer-role' }}">
                {{ Auth::user()->role === 'owner' ? 'Chủ Quán' : 'Khách Hàng' }}
            </span>

            @php
                $avatarFile = Auth::user()->avatar_url;
                $defaultAvatar = Auth::user()->gender === 'male' 
                    ? asset('frontend/images/default_avatar.jpg') 
                    : asset('frontend/images/default_avatar1.jpg');

                $avatarPath = $avatarFile 
                    ? asset('frontend/images/' . basename($avatarFile)) 
                    : $defaultAvatar;
            @endphp

            <img src="{{ $avatarPath }}" alt="Avatar" class="user-avatar" id="avatar">
            <span class="user-name">{{ Auth::user()->full_name }}</span>
            <ul class="dropdown-menu" id="dropdown-menu">
                @if(Auth::check())
                    @if(Auth::user()->role === 'owner')
                         <li><a href="{{ route('owner', ['id' => Auth::user()->id]) }}">Trang chủ quán</a></li>
                    @else
                          <li><a href="{{ route('user', ['id' => Auth::user()->id]) }}">Trang cá nhân</a></li>

                    @endif

                    <li><a href="{{ route('profile') }}">chỉnh sửa thông tin</a></li>

                    <li>
                        <a href="{{ route('logout') }}" 
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Đăng xuất
                        </a>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Đăng nhập</a></li>
                @endif
            </ul>
        </div>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @else
        <!-- Nếu chưa đăng nhập -->
        <a href="{{ route('login') }}" class="btn btn-primary">Đăng nhập</a>
        <a href="{{ route('register') }}" class="btn btn-outline">Đăng ký</a>
    @endauth
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const avatar = document.getElementById("avatar");
        const dropdownMenu = document.getElementById("dropdown-menu");

        avatar.addEventListener("click", function (event) {
            dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
            event.stopPropagation(); // Ngăn chặn sự kiện click lan ra ngoài
        });

        // Ẩn dropdown khi click ra ngoài
        document.addEventListener("click", function () {
            dropdownMenu.style.display = "none";
        });

        // Giữ dropdown mở nếu click vào nó
        dropdownMenu.addEventListener("click", function (event) {
            event.stopPropagation();
        });
    });

</script>

</header>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div> -->
        </div>
    </div>
    <script src="{{ asset('frontend/js/seacher.js') }}"></script>
    <script src="{{ asset('frontend/js/date_weather.js') }}"></script>

    