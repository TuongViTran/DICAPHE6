@extends('frontend.layout')
@section('title','Owner')

@section('content')
<head>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>

@endif

<div class="container mt-4">
        <div class="p-4 rounded shadow-sm mb-4 d-flex align-items-center justify-content-around" style="background: linear-gradient(to bottom,rgb(241, 215, 180), #fbc2eb00);">
            <!-- Cột bên trái: Ảnh đại diện + Thông tin quán -->
            <div class="d-flex flex-column align-items-center">
            <img src="{{ asset('storage/uploads/avatars/' . basename($coffeeShop->user->avatar_url ?? 'avt.png')) }}"
     alt="User profile picture"
     class="rounded-circle mb-2"
     width="90"
     height="90"
     style="width: 90px; height: 90px; object-fit: cover; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                
                <div class="text-left">
                    <h4 class="text-center fw-bold mb-1">Chủ quán: {{ $coffeeShop->user->full_name }}</h4>
                    <p class="text-secondary mb-1"><i class="fa-solid fa-door-open"></i> Open daily: {{ \Carbon\Carbon::parse($coffeeShop->opening_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($coffeeShop->closing_time)->format('H:i') }}</p>
                    <p class="text-secondary mb-1"><i class="fa-solid fa-tags"></i> Price: {{ $coffeeShop->min_price }}k - {{ $coffeeShop->max_price }}k</p>
                    <p class="text-secondary mb-0"><i class="fa-solid fa-location-dot"></i> Address: {{ $coffeeShop->address->street ?? 'Chưa cập nhật' }}</p>
                </div>
            </div>

            <!-- Cột bên phải: Bài viết, Đã lưu, Đã tìm quán -->
            <div class="bg-white p-3 rounded shadow-sm text-center d-flex gap-4 justify-content-around" style="min-width: 500px;">
                <div>
                    <p class="fs-6 text-secondary mb-1">Bài viết</p>
                    <p class="fs-5 fw-bold mb-0">{{ $postCount }}</p>
                </div>
                <div>
                    <p class="fs-6 text-secondary mb-1">Người lưu</p>
                    <p class="fs-5 fw-bold mb-0">{{ $saveCount }}</p>
                </div>
                <div>
                    <p class="fs-6 text-secondary mb-1">Feedback</p>
                    <p class="fs-5 fw-bold mb-0">{{ $reviewCount }}</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                
                <div class="bg-white p-4 rounded shadow-sm mb-4">
                    <h2 class="fs-5 fw-bold mb-3">Quán của tôi</h2>
                    
                    
                        <div class="flex flex-col md:flex-row gap-8">
                            
                           <!-- Cột trái: Hình ảnh -->
                                <div class="md:w-1/2">
                                    <!-- Ảnh lớn -->
                                    <img 
                                        alt="Front view of {{ $coffeeShop->shop_name }}" 
                                        class="rounded-2xl mb-4 w-full object-cover" 
                                        style="max-height: 240px; object-fit: cover;" 
                                        src="{{ asset('frontend/images/' . $coffeeShop->cover_image) }}" 
                                    />

                                    <!-- Ảnh nhỏ -->
                                        <div class="grid grid-cols-3 gap-4">
                                            @foreach (['image_1', 'image_2', 'image_3'] as $img)
                                                <div class="rounded-xl overflow-hidden aspect-square">
                                                    <img 
                                                        src="{{ asset('frontend/images/' . $coffeeShop->$img) }}" 
                                                        alt="Ảnh phụ" 
                                                        class="w-full h-full object-cover"
                                                    />
                                                </div>
                                            @endforeach
                                        </div>

                                </div>

                            <!-- Cột phải: Thông tin -->
                            <div class="md:w-1/2">
                                <!-- Tên quán -->
                                <h1 class="text-2xl font-bold font-[Futura] mb-2">{{ $coffeeShop->shop_name }}</h1>

                                <!-- Đánh giá & style -->
                                <div class="flex items-center flex-wrap gap-2 mt-2">
                                    <!-- Sao đánh giá -->
                                    <div class="flex text-yellow-500 text-[20px]">
                                        <x-rating :score="$coffeeShop->reviews_avg_rating ?? 0" />
                                    </div>


                                    <!-- Badge phong cách -->
                                    @php
                                        $style = $coffeeShop->style;
                                        $badgeColors = [
                                            1 => ['#EBF6F4', '#0F4C3A'],
                                            2 => ['#F1E8F8', '#5F276D'],
                                            3 => ['#FBF5E6', '#6F4E28'],
                                            4 => ['#F7E7E7', '#76333C']
                                        ];
                                        [$bg, $text] = $badgeColors[$style->id] ?? ['#DFFEF2', '#00B140'];
                                    @endphp

                                    <span class="rounded-full px-4 py-1 text-xs font-semibold" style="background-color: {{ $bg }}; color: {{ $text }}">
                                        {{ $style->style_name }}
                                    </span>

                                    <!-- Badge trạng thái -->
                                    <span class="rounded-full px-4 py-1 text-xs font-semibold bg-green-100 text-green-700">
                                        {{ $coffeeShop->status }}
                                    </span>
                                </div>

                                <!-- Thời gian, giá, địa chỉ -->
                                <div class="mt-2  space-y-2 text-gray-600">
                                    <p><i class="bi bi-clock"></i> Open: {{ \Carbon\Carbon::parse($coffeeShop->opening_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($coffeeShop->closing_time)->format('H:i') }}</p>
                                    <p><i class="bi bi-cash"></i> Price: {{ $coffeeShop->min_price }} - {{ $coffeeShop->max_price }}</p>
                                    <p><i class="bi bi-geo-alt"></i> Address: {{ $coffeeShop->address->street }}, {{ $coffeeShop->address->district }}, {{ $coffeeShop->address->city }}</p>
                                </div>

                                <!-- Thông tin thêm -->
                                <div class="mt-2">
                                    <h2 class="text-2xl font-semibold mb-2">Thông tin</h2>
                                    <p class="text-gray-500 mb-2">IG: @Ngaybinhyen_Giaolộ8</p>
                                    <p class="text-gray-500 mb-2"><strong>Đậu xe:</strong> {{ $coffeeShop->parking }}</p>
                                    <p class="text-gray-500 mb-2"><strong>Mật khẩu WiFi:</strong> {{ $coffeeShop->wifi_password }}</p>
                                    <p class="text-gray-500 mb-2"><strong>Hotline:</strong> {{ $coffeeShop->phone }}</p>
                                </div>

                                    <!-- Button mở Modal menu -->
                                    <button type="button" class="btn btn-warning text-white mr-4" data-bs-toggle="modal" data-bs-target="#menuModal">
                                        Menu
                                    </button>

                                    <!-- Modal hiển thị danh sách menu -->
                                    <div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
                                        <div class="modal-dialog max-w-[600px]">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Menu {{ $coffeeShop->shop_name }}</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <!-- Modal body -->
                                                <div class="modal-body">
                                                    @if($coffeeShop->menu->count() > 0)
                                                        @foreach ($coffeeShop->menu as $menu)
                                                            <div class="mb-3">
                                                                <img src="{{ asset('frontend/images/' . $menu->image_url) }}" class="rounded img-fluid mb-2 menu-item " 
                                                                    data-menu-id="{{ $menu->id }}" alt="Menu Image">
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p class="text-muted">Chưa có menu nào được thêm.</p>
                                                    @endif
                                                </div>

                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-warning text-white" id="openEditMenuModal" data-bs-dismiss="modal">
                                                        Chỉnh sửa menu
                                                    </button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Chỉnh Sửa Menu -->
                                        <div class="modal fade" id="editMenuModal" tabindex="-1" aria-labelledby="editMenuModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Chỉnh sửa menu {{ $coffeeShop->shop_name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form id="editMenuForm" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <label class="form-label">Chọn ảnh mới:</label>
                                                            <input type="file" class="form-control" name="menu_image" accept="image/*" required>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            
                                        </div>



                                                        
                                                            <!-- JS để xử lý mở modal chỉnh sửa -->
                                    <script>
                                        document.getElementById("openEditMenuModal").addEventListener("click", function () {
                                            var firstMenuItem = document.querySelector(".menu-item"); // Lấy menu đầu tiên
                                            if (!firstMenuItem) return alert("Chưa có menu nào để chỉnh sửa!");

                                            var menuId = firstMenuItem.getAttribute("data-menu-id");

                                            // Ẩn modal danh sách menu
                                            var menuModal = bootstrap.Modal.getInstance(document.getElementById("menuModal"));
                                            if (menuModal) menuModal.hide();

                                            // Cập nhật action form
                                            var form = document.getElementById("editMenuForm");
                                            form.action = "/menu/update/" + menuId;

                                            // Hiển thị modal chỉnh sửa
                                            setTimeout(() => {
                                                var editMenuModal = new bootstrap.Modal(document.getElementById("editMenuModal"));
                                                editMenuModal.show();
                                            }, 300);
                                        });
                                    </script>

                                    <!-- Button mở Modal -->
                                    
                                    <button type="button" class="btn btn-secondary px-4" data-bs-toggle="modal" data-bs-target="#editModal">
                                        Chỉnh sửa
                                    </button>

                                    <!-- Modal Chỉnh Sửa -->
                                    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Chỉnh Sửa Thông Tin</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('owner.updateinfor', $coffeeShop->id) }}" enctype="multipart/form-data" method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <!-- Tên quán -->
                                                        <div class="mb-3">
                                                            <label for="shop_name" class="form-label">Tên Quán</label>
                                                            <input type="text" class="form-control" id="shop_name" name="shop_name" value="{{ $coffeeShop->shop_name }}">
                                                        </div>

                                                        <!-- Trạng thái -->
                                                        <div class="mb-3">
                                                            <label for="status" class="form-label">Trạng Thái</label>
                                                            <select class="form-select" id="status" name="status">
                                                                <option value="Đang mở cửa" {{ $coffeeShop->status == 'Đang mở cửa' ? 'selected' : '' }}>Mở cửa</option>
                                                                <option value="Đã đóng cửa" {{ $coffeeShop->status == 'Đã đóng cửa' ? 'selected' : '' }}>Đóng cửa</option>
                                                            </select>
                                                        </div>

                                                        <!-- Số điện thoại -->
                                                        <div class="mb-3">
                                                            <label for="phone" class="form-label">Số điện thoại</label>
                                                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $coffeeShop->phone }}" required>
                                                        </div>

                                                        <!-- Mô tả -->
                                                        <div class="mb-3">
                                                            <label for="description" class="form-label">Mô tả</label>
                                                            <textarea class="form-control" rows="5" id="description" name="description">{{ $coffeeShop->description }}</textarea>
                                                        </div>

                                                        <!-- Giờ mở cửa & đóng cửa -->
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label for="opening_time" class="form-label">Giờ mở cửa</label>
                                                                <input type="time" class="form-control" id="opening_time" name="opening_time" value="{{ substr($coffeeShop->opening_time, 0, 5) }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="closing_time" class="form-label">Giờ đóng cửa</label>
                                                                <input type="time" class="form-control" id="closing_time" name="closing_time" value="{{ substr($coffeeShop->closing_time, 0, 5) }}" required>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <!-- Giá tối thiểu -->
                                                            <div class="col-md-6">
                                                                <label for="min_price" class="form-label">Giá nhỏ nhất</label>
                                                                <input type="number" class="form-control" id="min_price" name="min_price" value="{{ $coffeeShop->min_price }}" required>
                                                            </div>

                                                            <!-- Giá tối đa -->
                                                            <div class="col-md-6">
                                                                <label for="max_price" class="form-label">Giá cao nhất</label>
                                                                <input type="number" class="form-control" id="max_price" name="max_price" value="{{ $coffeeShop->max_price }}" required>
                                                            </div>
                                                        </div>

                                                        <!-- Hình ảnh -->
                                                        @foreach(['cover_image', 'image_1', 'image_2', 'image_3'] as $img)
                                                        <div class="mb-3">
                                                            <label for="{{ $img }}" class="form-label">Hình ảnh {{ ucfirst(str_replace('_', ' ', $img)) }}</label>
                                                            <input type="file" class="form-control" id="{{ $img }}" name="{{ $img }}">
                                                            @if(!empty($coffeeShop->$img))
                                                                <img src="{{ asset('frontend/images/' . $coffeeShop->$img) }}" class="img-thumbnail mt-2" width="100">
                                                            @endif
                                                        </div>
                                                        @endforeach

                                                        <!-- Địa chỉ -->
                                                        <div class="mb-3">
                                                            <label for="address" class="form-label">Địa chỉ</label>
                                                            <input type="text" class="form-control" id="address" name="address"
                                                                value="{{ implode(', ', array_filter([ 
                                                                    optional($coffeeShop->address)->street,
                                                                    optional($coffeeShop->address)->ward,
                                                                    optional($coffeeShop->address)->district,
                                                                    optional($coffeeShop->address)->city,
                                                                    optional($coffeeShop->address)->country
                                                                ])) }}" required>
                                                        </div>

                                                        <!-- Thêm script để kích hoạt Google Places Autocomplete -->
                                                        <script>
                                                            function initAutocomplete() {
                                                                var input = document.getElementById('address');
                                                                var options = {
                                                                    types: ['geocode'],
                                                                    componentRestrictions: { country: 'vn' } // Giới hạn tìm kiếm trong Việt Nam
                                                                };
                                                                
                                                                var autocomplete = new google.maps.places.Autocomplete(input, options);
                                                                autocomplete.addListener('place_changed', function() {
                                                                    var place = autocomplete.getPlace();
                                                                    if (!place.geometry) {
                                                                        return;
                                                                    }
                                                                    // Lấy thông tin từ địa chỉ đã chọn
                                                                    var address = place.formatted_address;
                                                                    var lat = place.geometry.location.lat();
                                                                    var lng = place.geometry.location.lng();
                                                                    console.log('Selected Address:', address);
                                                                    console.log('Latitude:', lat);
                                                                    console.log('Longitude:', lng);
                                                                });
                                                            }
                                                        </script>
                                                                

                                                        <!-- Nút lưu -->
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                            <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              
                            </div>
                   

                        
                  
                
            
    </div>

    
    <div class="bg-white mb-4 p-4 rounded shadow-sm">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fs-5 fw-bold">Bài viết của tôi</h2>
            
            <!-- Nút mở modal -->
            <button type="button" class="btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#createPostModal">
                <i class="fa-solid fa-plus"></i> Tạo bài viết
            </button>

            <!-- Modal -->
            <div class="modal fade" id="createPostModal" tabindex="-1" aria-labelledby="createPostLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createPostLabel">Tạo bài viết mới</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('posts.store', ['id' => $coffeeShop->user_id]) }}" method="POST" enctype="multipart/form-data" id="createPostForm">
                                @csrf

                                {{-- Hiển thị lỗi validate tổng quát --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <strong>Đã xảy ra lỗi!</strong>
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                {{-- Ảnh đại diện --}}
                                <div class="mb-3">
                                    <label for="image" class="form-label">Ảnh đại diện của bài viết</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                        id="image" name="image" accept="image/*" required>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Tiêu đề --}}
                                <div class="mb-3">
                                    <label for="title" class="form-label">Tiêu đề</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                        id="title" name="title" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Mô tả --}}
                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea id="description" name="description" rows="3"
                                            class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Nội dung --}}
                                <div class="mb-3">
                                    <label for="content" class="form-label">Nội dung</label>
                                    <textarea id="content" name="content" class="form-control ckeditor @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Nút lưu --}}
                                <button type="submit" class="btn btn-primary">Lưu bài viết</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tự mở modal tạo nếu lỗi từ tạo --}}
            @if (session('create_modal'))
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    let createModal = new bootstrap.Modal(document.getElementById("createPostModal"));
                    createModal.show();
                });
            </script>
            @endif


        <!-- Danh sách bài viết -->


        @foreach($posts as $post)
        
            <div class="border p-3 rounded mb-3 ">
                <div class="d-flex gap-3">
                    <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark">
                    <div style="width: 240px; height: 160px; flex-shrink: 0;">
                        <img src="{{ asset('storage/uploads/posts/' . $post->image_url) }}"
                            alt="{{ $post->image_url }}"
                            class="rounded"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    </a>

                    <div class="flex-grow-1">
                    <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark">
                        <h3 class="fs-5 fw-bold">{{ $post->title }}</h3>
                        </a>
                        <span class="badge bg-success">{{ $post->status }}</span>
                        <p class="text-secondary mt-2">
                        {{ $post->description }}
                        </p>

                        <p class="text-muted small mb-2">
                            <i class="fa-regular fa-calendar"></i> {{ $post->created_at->format('d/m/Y') }} |
                            <i class="fa-regular fa-user"></i> Tác giả: {{ $post->user->full_name }}
                        </p>

                        <div class="d-flex gap-2">
                                <form action="{{ route('posts.destroy', [ 'postId' => $post->id]) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?');" class="d-inline-flex align-items-center">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm d-inline-flex align-items-center" style="height: 30px;">❌ Xóa</button>
                                </form>

                                <!-- Nút mở modal -->
                                <button type="button" class="btn btn-warning btn-sm text-white d-inline-flex align-items-center" style="height: 30px;" data-bs-toggle="modal" data-bs-target="#editPostModal{{ $post->id }}">
                                    ✏️ Chỉnh sửa
                                </button>

                            <!-- Modal chỉnh sửa -->
                            <div class="modal fade" id="editPostModal{{ $post->id }}" tabindex="-1" aria-labelledby="editPostLabel{{ $post->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" id="editPostForm{{ $post->id }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editPostLabel{{ $post->id }}">Chỉnh sửa bài viết</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">

                                                {{-- Hiển thị lỗi nếu có --}}
                                                @if(session('error'))
                                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                                @endif
                                             

                                                {{-- Ảnh đại diện --}}
                                                <div class="mb-3">
                                                    <label for="image" class="form-label">Ảnh đại diện</label>
                                                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*">
                                                    @error('image')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <img src="{{ asset('storage/uploads/posts/' . $post->image_url) }}" class="mt-2 rounded" style="height: 120px;">
                                                </div>

                                                {{-- Tiêu đề --}}
                                                <div class="mb-3">
                                                    <label class="form-label">Tiêu đề</label>
                                                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $post->title) }}" required>
                                                    @error('title')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                {{-- Mô tả --}}
                                                <div class="mb-3">
                                                    <label class="form-label">Mô tả</label>
                                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3" required>{{ old('description', $post->description) }}</textarea>
                                                    @error('description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                {{-- Nội dung --}}
                                                <div class="mb-3">
                                                    <label class="form-label">Nội dung</label>
                                                    <textarea class="form-control ckeditor @error('content') is-invalid @enderror" name="content" rows="5">{{ old('content', $post->content) }}</textarea>
                                                    @error('content')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
           
        @endforeach


    </div>
    </div>
    <div class="col-lg-4">
                
    <div class="bg-white p-4 rounded shadow-sm mb-4">
    <h2 class="fs-5 fw-bold mb-3">Quản lý đánh giá</h2>
    <ul class="list-unstyled">
    @if ($reviews->isEmpty())
        <p class="text-center text-muted mt-4" style="font-style: italic;">Chưa có đánh giá nào.</p>
    @else
        @foreach ($reviews as $review)
        @php
    $userLiked = auth()->check() && $review->likedUsers->contains(auth()->id());
@endphp  
        <div class="d-flex align-items-start gap-3 mb-4">
        <!-- Avatar -->
        <img 
    src="{{ asset('storage/uploads/avatars/' . basename($review->user->avatar_url ?? '')) }}"
    onerror="this.onerror=null; this.src='{{ asset('frontend/images/avt.png') }}';"
    alt="Avatar" 
    style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;"
/>



        <!-- Nội dung đánh giá -->
        <div class="flex-grow-1" style="line-height: 1.4; position: relative;">
            <p class="mb-1" style="font-size: 14px;">
                <strong>{{ $review->user->full_name ?? 'Người dùng ẩn danh' }}</strong>
                <span class="text-muted"> đang ở tại </span>
                <strong>
                    <a href="{{ route('frontend.shop', ['id' => $review->shop->id]) }}">
                        <strong>{{ $review->shop->shop_name }}</strong>
                    </a>
                </strong>
            </p>

            <p class="mb-1" style="font-size: 14px;">{{ $review->content }}</p>

            <div class="d-flex align-items-center" style="font-size: 13px; color: #555;">
                <span>{{ $review->created_at ? $review->created_at->format('d/m/Y') : 'Không có ngày' }}</span>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <span class="like-count">{{ $review->likes_count }} </span>  &ensp;lượt thích
                &nbsp;&nbsp;&nbsp;&nbsp;

                <!-- Rating sao -->
                <span class="text-warning">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star"></i>
                    @endfor
                </span>
            </div>

            <!-- Nút like cố định -->
            <button class="like-button" 
                                data-id="{{ $review->id }}" 
                                style="border: none; background: none; cursor: pointer; position: absolute; top: 35px; right: 15px;">
                                <i class="fa{{ $userLiked ? 's' : 'r' }} fa-heart text-{{ $userLiked ? 'danger' : 'dark' }}"></i>
                            </button>
        </div>
    </div>

        @endforeach
    @endif

    </ul>
</div>
    </div>
    <h4 class="mt-5 mb-3 fw-bold" style="font-size:x-large">📌 Các quán đã lưu</h4>

   
@if(empty($savedShops))
<p class="text-muted">Chưa có quán nào được lưu.</p>
@else
<div class="row">
    @foreach($savedShops as $shop)
        <div class="col-md-3 mb-4">
            <div class="card_nearme shadow-sm">
                <!-- Ảnh quán cafe -->
                <div class="position-relative">
                    <img src="{{ asset('frontend/images/' . $shop->cover_image) }}" class="card_nearme-img" alt="Coffee Shop">
                </div>
                <!-- Nội dung quán -->
                <div class="card_nearme-body p-2">
                    <!-- Đánh giá sao và nút Lưu -->
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div>
                            <x-rating :score="$shop->reviews_avg_rating ?? 0" />
                        </div>
                        <div class="d-flex align-items-center">
                           
                            <button class="save-btn {{ $savedShops->contains('id', $shop->id) ? 'liked' : '' }}" data-shop-id="{{ $shop->id }}">
                                <svg class="save-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     viewBox="0 0 16 16" style="width: 20px; height: 20px; margin-right: 5px;">
                                    <path fill-rule="evenodd" d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                                    <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                                </svg>
                                <span class="save-text">
                                    @if($savedShops->contains('id', $shop->id))
                                        Đã Lưu
                                    @else
                                        Lưu
                                    @endif
                                </span>
                            </button>
                        </div>
                    </div>
                    <!-- Tên quán -->
                    <h5 class="card_nearme-title fw-bold">
                        <a href="{{ url('/shop/' . $shop->id) }}" class="text-dark text-decoration-none">
                            {{ $shop->shop_name }}
                        </a>
                    </h5>
                    <!-- Thông tin chi tiết -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card_nearme-avatar text-center mt-2">
                                <img src="{{ $shop->avatar_url ?? asset('frontend/images/default_avatar.jpg') }}" class="avatar-img" alt="Avatar">
                            </div>
                        </div>
                        <div class="col-md-9">
                            <p class="card_nearme-text mb-1">
                                <span class="icon_nearme"><img src="{{ asset('frontend/images/mc.svg') }}" alt="Trang chủ"> Giờ: {{ date('H:i', strtotime($shop->opening_time)) }} am - {{ date('H:i', strtotime($shop->closing_time)) }} pm</span>
                            </p>
                            <p class="card_nearme-text mb-1">
                                <span class="icon_nearme"><img src="{{ asset('frontend/images/gia.svg') }}" alt="Trang chủ"> Giá: {{ number_format($shop->min_price, 2, ',', '.') }}k - {{ number_format($shop->max_price, 2, ',', '.') }}k</span>
                            </p>
                            <p class="card_nearme-text">
                                <span class="icon_nearme"><img src="{{ asset('frontend/images/đc.svg') }}" alt="Trang chủ"> Địa chỉ: {{ $shop->address->street ?? 'Đang cập nhật' }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endif

@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('frontend/js/save-favorite.js') }}"></script>  
<script>
document.addEventListener('DOMContentLoaded', function() {
    const likeButtons = document.querySelectorAll('.like-button');

    likeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const reviewId = button.getAttribute('data-id');

            fetch(`/review/${reviewId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const icon = button.querySelector('i');
                    const likeCount = button.parentElement.querySelector('.like-count');

                    if (data.liked) {
                        icon.classList.remove('far');
                        icon.classList.add('fas', 'text-danger');
                        icon.classList.remove('text-dark');
                    } else {
                        icon.classList.remove('fas', 'text-danger');
                        icon.classList.add('far', 'text-dark');
                    }

                    if (likeCount) {
                        likeCount.textContent = data.likes_count;
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
</script>  

<style>
/* Trạng thái mặc định (Lưu) */
.save-btn {
    background-color: white;
    color: black;
    border: 1px solid black;
    padding: 5px 8px;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
}

/* Trạng thái đã lưu */
.save-btn.liked {
    background-color: red;
    color: white;
    border: none;
}

/* Thêm một chút khoảng cách cho icon */
.save-icon {
    fill: black; /* Màu của SVG khi chưa lưu */
}

/* Thay đổi màu của icon khi nút đã được lưu */
.save-btn.liked .save-icon {
    fill: white; /* Màu của SVG khi đã lưu */
}

</style>