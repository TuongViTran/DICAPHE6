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
<script src="https://cdn.tailwindcss.com"></script>


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


<!-- Thanh tìm kiếm -------------------->
    <!-- <section class="search-section">
            <div class="search-box">
            <span class="icon"><img src="{{ asset('frontend/images/Search.svg') }}" alt="Trang chủ"></span><input type="text" placeholder="Hôm nay bạn muốn đi đâu?" />
                <button class="btn-location">Tìm kiếm </button>
            </div>
            <div class="filters">
            <div class="filter-container">
                    <button class="dropdown-btn">
                    <img src="{{ asset('frontend/images/icon_khoangcach.svg') }}" alt="icon" class="icon"> Khoảng cách ▾
                    </button>
                <div class="dropdown-content">
                    <div class="slider-container">
                        <span>0km</span>
                        <input type="range" min="0" max="15" class="slider" oninput="updateSliderValue(this)">
                        <span class="slider-value">0km</span>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="walkable">
                        <label for="walkable">Có thể đi bộ</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="distance2">
                        <label for="distance2">2 km</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="distance5">
                        <label for="distance5">&lt; 5km</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="distance7">
                        <label for="distance7">5-7km</label>
                    </div>
                </div>
            </div>
            <div class="filter-container">
                    <button class="dropdown-btn">
                    <img src="{{ asset('frontend/images/icon_stylequan.svg') }}" alt="icon" class="icon"> Style quán ▾
                    </button>
                <div class="dropdown-content">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="work">
                        <label for="work">Work Coffee</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="vintage">
                        <label for="vintage">Vintage Coffee</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="modern">
                        <label for="modern">Modern Coffee</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="traditional">
                        <label for="traditional">Traditional Coffee</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="concept">
                        <label for="concept">Concept Coffee</label>
                    </div>
                </div>
            </div>
            <div class="filter-container">
                    <button class="dropdown-btn">
                    <img src="{{ asset('frontend/images/icon_gia.svg') }}" alt="icon" class="icon"> Khoảng giá ▾
                    </button>
                <div class="dropdown-content">
                    <div class="slider-container">
                        <span>0k</span>
                        <input type="range" min="0" max="50" class="slider" oninput="updateSliderValue(this)">
                        <span class="slider-value">0k</span>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="price50">
                        <label for="price50">&lt; 50k</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="price50_70">
                        <label for="price50_70">50k - 70k</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="price70">
                        <label for="price70">&gt; 70k</label>
                    </div>
                </div>
            </div>
        </div>
        </div>
        
        <div class="hello">
        <h2>Xin chào! Chúng tôi hỗ trợ<br> tìm kiếm quán cà phê</h2> 
        </div> 
       
    </section> -->
    <main>
        @yield('content')
        @stack('scripts')
    </main>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
              <img src="{{ asset('frontend/images/Logo.svg') }}" alt="caphedidau" class="icon">
            </div>
            <div class="footer-links">
                <div class="footer-column">
                    <h3>Về website</h3>
                    <ul>
                        <li><a href="#">Cách đặt chỗ</a></li>
                        <li><a href="#">Hỗ trợ</a></li>
                        <li><a href="#">Liên hệ chúng tôi</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Dịch vụ khách hàng</h3>
                    <ul>
                        <li><a href="#">Câu hỏi thường gặp</a></li>
                        <li><a href="#">Chính sách chúng tôi</a></li>
                        <li><a href="#">Quyền lợi khách hàng</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Kênh kết nối</h3>
                    <ul>
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">YouTube</a></li>
                    </ul>
                </div>
                <div class="footer-column update-section">
                    <h3><strong>LUÔN CẬP NHẬT</strong></h3>
                    <p>Về các tin tức đồ uống, sản phẩm mới</p>
                    <div class="subscribe">
                        <input type="email" placeholder="Email">
                        <button>Đăng ký</button>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
<!-- Thêm CK EDITOR-->

<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>

<script>
    class MyUploadAdapter {
        constructor(loader) {
            this.loader = loader;
        }

        upload() {
            return this.loader.file.then(file => {
                return new Promise((resolve, reject) => {
                    const data = new FormData();
                    data.append('upload', file);
                    data.append('_token', '{{ csrf_token() }}');

                    fetch("{{ route('ckeditor.upload') }}", {
                        method: "POST",
                        body: data
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.url) {
                            resolve({ default: result.url });
                        } else {
                            reject(result.error.message);
                        }
                    })
                    .catch(error => {
                        reject('Upload failed');
                        console.error(error);
                    });
                });
            });
        }

        abort() {
            // Xử lý khi cần hủy upload (không bắt buộc)
        }
    }

    function MyCustomUploadAdapterPlugin(editor) {
        editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
            return new MyUploadAdapter(loader);
        };
    }

    document.querySelectorAll('.ckeditor').forEach(el => {
    ClassicEditor
        .create(el, {
            extraPlugins: [MyCustomUploadAdapterPlugin]
        })
        .catch(err => console.error(err));
});

</script>
<script src="{{ asset('frontend/js/seacher.js') }}"></script>
<script src="{{ asset('frontend/js/date_weather.js') }}"></script>
<script>
    // Tự động lấy vị trí khi người dùng mở trang
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(position => {
            // Hiển thị tọa độ lên giao diện
            document.querySelector('.latitude').textContent = "Vĩ độ: " + position.coords.latitude;
            document.querySelector('.longitude').textContent = "Kinh độ: " + position.coords.longitude;
        }, error => {
            // Xử lý khi không thể lấy vị trí hoặc người dùng từ chối quyền truy cập
            console.error("Không thể lấy vị trí: ", error);
            alert("Bạn cần bật định vị để sử dụng tính năng này!");
        });
    } else {
        alert("Trình duyệt của bạn không hỗ trợ định vị!");
    }
</script>
</html>
