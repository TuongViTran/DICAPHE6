@extends('frontend.layout')
@section('title','Owner')
@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show text-center" role="alert" id="successAlert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<script>
    // Tự động tắt thông báo sau 4 giây
    setTimeout(function() {
        var alert = document.getElementById('successAlert');
        if (alert) {
            alert.classList.remove('show');
        }
    }, 4000); // 4000ms = 4s
</script>
@endif

<div class="container mt-4">
        <div class="p-4 rounded shadow-sm mb-4 d-flex align-items-center justify-content-around" style="background: linear-gradient(to bottom,rgb(241, 215, 180), #fbc2eb00);">
            <!-- Cột bên trái: Ảnh đại diện + Thông tin quán -->
            <div class="d-flex flex-column align-items-center">
            <img src="{{ asset('frontend/images/' . basename($user->avatar_url ?? 'avt.png')) }}" alt="User profile picture" class="rounded-circle mb-2" width="90" height="90" style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                
                <div class="text-left">
                    <h4 class="text-center fw-bold mb-1">Chủ quán :{{ $coffeeShop->user->full_name }}</h4>
                    <p class="text-secondary mb-1"><i class="fa-solid fa-door-open"></i> Open daily: {{ \Carbon\Carbon::parse($coffeeShop->opening_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($coffeeShop->closing_time)->format('H:i') }}</p>
                    <p class="text-secondary mb-1"><i class="fa-solid fa-tags"></i> Price: {{ $coffeeShop->min_price }}k - {{ $coffeeShop->max_price }}k</p>
                    <p class="text-secondary mb-0"><i class="fa-solid fa-location-dot"></i> Address: {{ $coffeeShop->address->street ?? 'Chưa cập nhật' }}</p>
                </div>
            </div>

            <!-- Cột bên phải: Bài viết, Đã lưu, Đã tìm quán -->
            <div class="bg-white p-3 rounded shadow-sm text-center d-flex gap-4 justify-content-around" style="min-width: 500px;">
                <div>
                    <p class="fs-6 text-secondary mb-1">Bài viết</p>
                    <p class="fs-5 fw-bold mb-0">7</p>
                </div>
                <div>
                    <p class="fs-6 text-secondary mb-1">Đã lưu</p>
                    <p class="fs-5 fw-bold mb-0">607</p>
                </div>
                <div>
                    <p class="fs-6 text-secondary mb-1">Đã tìm quán</p>
                    <p class="fs-5 fw-bold mb-0">1.004k</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                
                <div class="bg-white p-4 rounded shadow-sm mb-4">
                    <h2 class="fs-5 fw-bold mb-3">Quán của tôi</h2>
                    <div class="border p-3 rounded shadow-sm bg-white">
                        <div class="d-flex gap-4">
                            <!-- Bên trái: Hình ảnh -->
                            <div class="flex-shrink-0">
                                <!-- Ảnh lớn (Hình chữ nhật) -->
                                <img src="{{asset('frontend/images/'. $coffeeShop->cover_image)}}" 
                                    alt="Ảnh lớn" 
                                    style="width: 100%; height: 300px; object-fit: cover; border-radius: 8px;">
                                <!-- Ảnh nhỏ (Hình vuông) -->
                                <div class="mt-3 d-flex justify-content-between" style="max-width: 380px;">
                                    <img src="{{asset('frontend/images/'. $coffeeShop->image_1)}}" 
                                        alt="Image 1" class="rounded" 
                                        style="width: 32%; height: 110px; object-fit: cover;">
                                    <img src="{{asset('frontend/images/' . $coffeeShop->image_2)}}" 
                                        alt="Image 2" class="rounded" 
                                        style="width: 32%; height: 110px; object-fit: cover;">
                                    <img src="{{asset('frontend/images/' . $coffeeShop->image_3)}}" 
                                        alt="Image 3" class="rounded" 
                                        style="width: 32%; height: 110px; object-fit: cover;">
                                </div>
                            </div>

                            <!-- Bên phải: Thông tin quán -->
                            <div class="flex-grow-1">
                                <h3 class="fs-4 fw-bold">{{ $coffeeShop->shop_name }}</h3>
                                <div class="d-flex align-items-center gap-2">
                                @for ($i = 1; $i <= 5; $i++)
                                        @if($i <= $coffeeShop->reviews_avg_rating)
                                        <i class="fa-solid fa-star" style="color: #FFD43B;"></i>
                                        @else
                                        <i class="fa-thin fa-star" style="color: #FFD43B;"></i>
                                        @endif
                                    @endfor
                                    <span class="text-secondary">{{ $coffeeShop->rating }}</span>
                                    <span class="badge bg-success">{{ $coffeeShop->status }}</span>
                                </div>

                                <p class="text-secondary mt-2"><i class="bi bi-clock"></i> Open daily: {{ \Carbon\Carbon::parse($coffeeShop->opening_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($coffeeShop->closing_time)->format('H:i') }}</p>
                                <p class="text-secondary"><i class="bi bi-cash"></i> Price: {{ $coffeeShop->min_price }} - {{ $coffeeShop->max_price }}</p>
                                <p class="text-secondary"><i class="bi bi-geo-alt"></i> Address: {{ $coffeeShop->address->street}}, {{ $coffeeShop->address->district}}, {{ $coffeeShop->address->city}} </p>

                                <h5 class="fw-bold mt-3">Thông tin</h5>
                                <p class="mb-1"><strong>Đậu xe:</strong> {{ $coffeeShop->parking }}</p>
                                <p class="mb-1"><strong>Mật khẩu WiFi:</strong> {{ $coffeeShop->wifi_password }}</p>
                                <p class="mb-1"><strong>Hotline:</strong> {{ $coffeeShop->phone }}</p>
                                <div class="mt-3 d-flex gap-3">
                                    
                                    <!-- Button mở Modal menu -->
                                    <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#menuModal">
                                        Menu
                                    </button>

                                    <!-- Modal hiển thị danh sách menu -->
                                    <div class="modal fade" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
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
                                                                <img src="{{ asset('frontend/images/' . $menu->image_url) }}" class="rounded img-fluid mb-2 menu-item" 
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
                                                                <option value="open" {{ $coffeeShop->status == 'open' ? 'selected' : '' }}>Mở cửa</option>
                                                                <option value="closed" {{ $coffeeShop->status == 'closed' ? 'selected' : '' }}>Đóng cửa</option>
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
                                <!-- Nút yêu thích -->
                            <div class="mt-2">
                                <p><i class="fa-solid fa-heart" style="color: #f44206;"></i> Đã thích (3,3K)</p>
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
                            <form action="{{ route('posts.store', ['id' => $coffeeShop->user_id]) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="image" class="form-label">Ảnh đại diện của bài biết</label>
                                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                                </div>
                                <div class="mb-3">
                                    <label for="title" class="form-label">Tiêu đề</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="form-label">Nội dung</label>
                                    <textarea id="content" name="content" class="form-control ckeditor"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Lưu bài viết</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                            <form action="{{ route('posts.destroy', [ 'postId' => $post->id]) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">❌ Xóa</button>
                            </form>
                            <button type="button" class="btn btn-warning btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editPostModal{{ $post->id }}">
                                ✏️ Chỉnh sửa
                            </button>
                                <!-- Modal sửa -->
                                <div class="modal fade" id="editPostModal{{ $post->id }}" tabindex="-1" aria-labelledby="editPostLabel{{ $post->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editPostLabel{{ $post->id }}">Chỉnh sửa bài viết</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="image" class="form-label">Ảnh đại diện</label>
                                                        <input type="file" class="form-control" name="image" accept="image/*">
                                                        <img src="{{ asset('storage/uploads/posts/' . $post->image_url) }}" class="mt-2 rounded" style="height: 120px;">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Tiêu đề</label>
                                                        <input type="text" class="form-control" name="title" value="{{ $post->title }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Mô tả</label>
                                                        <textarea class="form-control" name="description" rows="3" required>{{ $post->description }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Nội dung</label>
                                                        <textarea class="form-control ckeditor" name="content" id="content2" rows="5">{{ $post->content }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
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
            <li class="d-flex align-items-center gap-3 mb-3">
                <img src="{{ asset('frontend/images/c2.jpg') }}" alt="User avatar" class="rounded-circle" width="50" height="50">
                <div>
                    <h3 class="fs-6 fw-bold mb-1">𝐑𝐮𝐬𝐭𝐢𝐜 𝐓𝐞𝐚 & 𝐂𝐨𝐟𝐟𝐞𝐞</h3>
                    <p class="text-secondary mb-1">Không gian rất yên tĩnh, phù hợp để học bài.</p>
                    <p class="text-secondary mb-0">4.0 <span class="text-warning"><i class="fas fa-star"></i></span></p>
                </div>
            </li>
            <li class="d-flex align-items-center gap-3 mb-3">
                <img src="{{ asset('frontend/images/c3.jpg') }}" alt="User avatar" class="rounded-circle" width="50" height="50">
                <div>
                    <h3 class="fs-6 fw-bold mb-1">𝐑𝐮𝐬𝐭𝐢𝐜 𝐓𝐞𝐚 & 𝐂𝐨𝐟𝐟𝐞𝐞</h3>
                    <p class="text-secondary mb-1">Thức uống ngon, nhân viên phục vụ nhiệt tình.</p>
                    <p class="text-secondary mb-0">4.5 <span class="text-warning"><i class="fas fa-star"></i></span></p>
                </div>
            </li>
            <li class="d-flex align-items-center gap-3 mb-3">
                <img src="{{ asset('frontend/images/c4.jpg') }}" alt="User avatar" class="rounded-circle" width="50" height="50">
                <div>
                    <h3 class="fs-6 fw-bold mb-1">𝐑𝐮𝐬𝐭𝐢𝐜 𝐓𝐞𝐚 & 𝐂𝐨𝐟𝐟𝐞𝐞</h3>
                    <p class="text-secondary mb-1">Thiết kế quán rất xinh xắn, chụp ảnh đẹp.</p>
                    <p class="text-secondary mb-0">4.8 <span class="text-warning"><i class="fas fa-star"></i></span></p>
                </div>
            </li>
            <li class="d-flex align-items-center gap-3 mb-3">
                <img src="{{ asset('frontend/images/c5.jpg') }}" alt="User avatar" class="rounded-circle" width="50" height="50">
                <div>
                    <h3 class="fs-6 fw-bold mb-1">𝐑𝐮𝐬𝐭𝐢𝐜 𝐓𝐞𝐚 & 𝐂𝐨𝐟𝐟𝐞𝐞</h3>
                    <p class="text-secondary mb-1">Mở nhạc nhẹ dễ chịu, có cả ổ điện để làm việc.</p>
                    <p class="text-secondary mb-0">4.2 <span class="text-warning"><i class="fas fa-star"></i></span></p>
                </div>
            </li>
            <li class="d-flex align-items-center gap-3 mb-3">
                <img src="{{ asset('frontend/images/c6.jpg') }}" alt="User avatar" class="rounded-circle" width="50" height="50">
                <div>
                    <h3 class="fs-6 fw-bold mb-1">𝐑𝐮𝐬𝐭𝐢𝐜 𝐓𝐞𝐚 & 𝐂𝐨𝐟𝐟𝐞𝐞</h3>
                    <p class="text-secondary mb-1">Vị trí trung tâm, dễ tìm và rất thuận tiện.</p>
                    <p class="text-secondary mb-0">4.3 <span class="text-warning"><i class="fas fa-star"></i></span></p>
                </div>
            </li>
        </ul>
    </div>
</div>

@endsection
          
