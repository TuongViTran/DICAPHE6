@extends('frontend.layout')
@section('title', 'User')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF Token -->
   
</head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>
    body {
      font-family: Arial, sans-serif;
      background: #f7f7f7;
      margin: 0;
      padding: 20px;
    }
    .section-title {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 20px;
    }
    /* ===== Container tổng ===== */
.hot-cafes-container {
  display: flex;
  align-items: stretch;
  flex-wrap: wrap;
  background: #fff;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  gap: 20px;
}

/* ===== Bên trái: Slider ===== */
.slider-wrapper {
  flex: 1;
  position: relative;
  border-radius: 12px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.slide {
  min-width: 100%;
  height: 100%;
  display: block;
  position: relative;
}

.slide img {
  width: 100%;
  height: 100%;
  border-radius: 12px;
  object-fit: cover;
}

.slider-indicators {
  position: absolute;
  bottom: 15px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  justify-content: center;
  gap: 8px;
  z-index: 10;
}

.dot {
  width: 10px;
  height: 10px;
  background-color: rgba(255, 255, 255, 0.6);
  border-radius: 50%;
  transition: background-color 0.3s ease;
}

.dot.active {
  background-color: #facc15;
}

/* ===== Bên phải: Danh sách quán ===== */
.hot-cafes-right {
  flex: 1;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 15px;
  padding-left: 20px;
}

.cafe-card {
  background-color: white;
  border-radius: 8px;
  padding: 12px 15px;
  transition: background-color 0.3s ease;
}

.cafe-card:nth-child(odd) {
  border-right: 1px solid #ccc;
}

.cafe-card.active {
  background-color: #fdfdbc;
}

.cafe-card h4,
.cafe-card p {
  font-size: 16px;
  font-weight: bold;
  margin-bottom: 8px;
}

.cafe-info {
  font-size: 14px;
  margin-bottom: 7px;
  display: flex;
  align-items: center;
  gap: 5px;
}

.stars {
  color: #fbbf24;
  font-size: 14px;
}

/* ===== Carousel đánh giá (nếu dùng) ===== */
.review-carousel {
  display: flex;
  overflow-x: auto;
  scroll-snap-type: x mandatory;
  gap: 20px;
  padding-bottom: 10px;
}

.review-carousel .card {
  flex: 0 0 auto;
  scroll-snap-align: start;
  min-width: 350px;
}

.review-carousel::-webkit-scrollbar {
  height: 8px;
}

.review-carousel::-webkit-scrollbar-thumb {
  background: #ccc;
  border-radius: 10px;
}

.review-content {
  margin-left: 50px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 400px;
  margin-bottom: 10px;
}

/* ===== Nút chức năng (nếu có) ===== */
    .chucnang {
        margin-left:195px
    }
    .chucnang button{
        margin-left: 10px;
        color:white
    }
    .chucnang button svg {
    margin-top: 0;
    margin-left: 0;
}




  
  </style>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

@section('content')
<div class="container mt-4">
    <div class="p-4 rounded shadow-sm mb-4 d-flex align-items-center justify-content-around" style="background: linear-gradient(to bottom, rgb(180, 241, 200), #c2ebfb00);">
        <!-- Cột bên trái: Ảnh đại diện + Thông tin quán -->
        <div class="d-flex flex-column align-items-center">
            <div style="width: 90px; height: 90px; overflow: hidden; border-radius: 50%; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom:5px;">
                <img 
                    src="{{ asset('storage/uploads/avatars/' . basename($user->avatar_url)) }}" 
                    alt="Ảnh hồ sơ người dùng" 
                    style="width: 100%; height: 100%; object-fit: cover;" 
                    onerror="this.onerror=null; this.src='{{ asset('storage/uploads/avatars/default-avatar.png') }}';">
            </div>


    <div class="text-left">
        <h4 class="text-center fw-bold mb-1">{{ $user->full_name ?? 'Khách hàng' }}</h4>
    </div>
</div>

            
            <div class="bg-white p-3 rounded shadow-sm text-center d-flex gap-4 justify-content-around" style="min-width: 500px;">
                <div style="font-size:small">
                    <img style="width:70px; height:70px; margin-top:-7px" src="https://img.tripi.vn/cdn-cgi/image/width=700,height=700/https://gcs.tripi.vn/public-tripi/tripi-feed/img/474074cAu/mau-logo-quan-cafe-don-gian_095347539.jpg" alt="">
                </div>
                <div>
                    <p class="fs-6 text-secondary mb-1">Đã lưu</p>
                    <p class="fs-5 fw-bold mb-0">{{ $savedCount }}</p>
                </div>
                <div>
                    <p class="fs-6 text-secondary mb-1">Đánh giá</p>
                    <p class="fs-5 fw-bold mb-0">{{ number_format($reviewCount) }}</p>
                </div>
            </div>
        </div>


        <body>
  <div class="section-title"><p style="font-weight:700;font-size: 22px; display: flex;"><svg style=" margin: 9px 10px 0 0" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-list-task" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M2 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V3a.5.5 0 0 0-.5-.5zM3 3H2v1h1z"/>
  <path d="M5 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M5.5 7a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 4a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1z"/>
  <path fill-rule="evenodd" d="M1.5 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5zM2 7h1v1H2zm0 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm1 .5H2v1h1z"/>
</svg> Danh sách quán café đang hot:</p></div>
<div class="hot-cafes-container">
    <div class="slider-wrapper ">
        <div class="slider" id="auto-slider">
            @foreach($sliderPosts as $index => $slide)
                <div class="slide">
                <img src="{{ asset('frontend/images/' . $slide->cover_image) }}" alt="{{ $slide->title }}">
                </div>
            @endforeach
        </div>
        <div class="slider-indicators">
            @foreach($sliderPosts as $index => $slide)
                <span class="dot" data-slide="{{ $index }}"></span>
            @endforeach
        </div>
    </div>

    <div class="hot-cafes-right" id="cafe-list">
        @foreach($hotCafes as $index => $cafe)
            <div class="cafe-card" data-index="{{ $index }}">
            <p style="font-size: 22px; font-weight:bold">
                {{ sprintf('%02d', $index + 1) }} :
                @if ($cafe)
                    <a href="{{ route('frontend.shop', ['id' => $cafe->id]) }}" style="text-decoration: none; color: inherit;">
                        {{ $cafe->shop_name }}
                    </a>
                @endif
            </p>
                <div class="cafe-info"> <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-door-open-fill" viewBox="0 0 16 16">
                            <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15zM11 2h.5a.5.5 0 0 1 .5.5V15h-1zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
                            </svg> Giờ mở cửa: {{ $cafe->opening_time }} - {{ $cafe->closing_time }}</div>
                <div class="cafe-info"><svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-tags-fill" viewBox="0 0 16 16">
                            <path d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                            <path d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043z"/>
                            </svg> Price: {{ $cafe->min_price }} - {{ $cafe->max_price }}</div>
                <div class="cafe-info">   <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                            </svg> Address: {{ $cafe->address->street}}, {{ $cafe->address->district}}, {{ $cafe->address->city}}</div>
                <div class="cafe-info"> 
                     <x-rating :score="$cafe->reviews_avg_rating ?? 0" />
                </div>
            </div>
        @endforeach
    </div>
</div>
  <br>
<!-- <hr style="margin:30px"> -->

  <div class="row">
  <h5 style="font-weight:700;font-size: 22px;display: flex;"><svg style=" margin: 9px 10px 0 0" xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
</svg> Feedback của bạn</h5>

<div style="display:flex; width:; ">
@if ($reviews->count() > 2)
    <div class="review-carousel">
@else
    <div style="display:flex; flex-wrap: wrap; ">
@endif
@foreach ($reviews->items() as $review)
@php
    $userLiked = auth()->check() && $review->likedUsers->contains(auth()->id());
@endphp  
<div class="card mb-1 p-3" style="border: none; position: relative; border-top-right-radius: 0; border-bottom-right-radius: 0;">
    <!-- Border phải giả, chiều cao giới hạn -->
    <div style="position: absolute; top: 15px; right: 0; height: 100%; max-height: 310px; width: 1px; background-color: #ccc;"></div>


                <div class="d-flex align-items-center">
                    <!-- Avatar người dùng -->
                     
                    <img src="{{ asset('storage/uploads/avatars/' . basename($review->user->avatar_url ?? 'avt.png')) }}"
     onerror="this.onerror=null; this.src='{{ asset('frontend/images/avt.png') }}';"
     width="60" height="60" alt="Avatar"
     style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; box-shadow: 0 2px 8px rgba(0,0,0,0.15); margin-right: 15px;">


                    <div class="ft" style="margin-top:15px">
                        <div style="max-width: 95%; word-break: break-word;">
                            <strong>{{ $review->user->full_name ?? 'Người dùng ẩn danh' }}</strong> 
                            đang ở tại 
                            <strong>
                                <a href="{{ route('frontend.shop', ['id' => $review->shop->id]) }}">
                                    <strong>{{ $review->shop->shop_name }}</strong>
                                </a>
                            </strong>
                        </div>
    
                        <div style="display:flex">
                        <p class="text-muted small">{{ $review->created_at ? $review->created_at->format('d/m/Y') : 'Không có ngày' }}</p>&ensp;
                            <span style="margin-right:5px;margin-left:0px;" class="like-count ">{{ $review->likes_count }} </span>  lượt thích   <!-- Hiển thị số sao -->
                            <p class="text-warning" style="margin-left:25px;">    
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star"></i>
                                    @endfor
                            </p>
    
                            <button class="like-button" 
                                data-id="{{ $review->id }}" 
                                style="border: none; background: none; cursor: pointer; position: absolute; top: 35px; right: 15px;">
                                <i class="fa{{ $userLiked ? 's' : 'r' }} fa-heart text-{{ $userLiked ? 'danger' : 'dark' }}"></i>
                            </button>

                            
                        </div>
                    </div>           
                </div>
                <!-- Nội dung đánh giá -->
                <div class="review-content">{{ $review->content }}</div>

                
    
                <!-- Hiển thị ảnh đánh giá -->
                @php
    $images = $review->img_url ? explode(',', $review->img_url) : [];
@endphp

@if (!empty($images))
    <div class="row">
        @foreach (array_slice($images, 0, 3) as $img)
            @php
                $img = trim($img);
                if ($img === '') continue;
                $isUrl = Str::startsWith($img, ['http://', 'https://']);
            @endphp

            <div class="col-4 d-flex mb-2">
                <img
                    src="{{ $isUrl ? $img : asset('storage/' . $img) }}"
                    style="height:180px; width:140px; object-fit:cover; margin-right:0px"
                    class="img-fluid rounded shadow"
                    alt="Review Image"
                    onerror="this.src='{{ asset('frontend/images/tt.svg') }}';"
                >
            </div>
        @endforeach
    </div>
@endif



      
                <div class="mt-2 d-flex chucnang" style="margin-left:280px">
                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xoá đánh giá này không?');" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center" style="height:35px">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
         class="bi bi-x-lg me-1" viewBox="0 0 16 16">
        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
    </svg>
    Xóa
</button>

                    </form>

                    <!-- Nút chỉnh sửa -->
                    <button type="button" style="height:35px" class="btn btn-warning btn-sm" width="16" height="16" data-bs-toggle="modal" data-bs-target="#editModal-{{ $review->id }}">
                        ✏️ Chỉnh sửa
                    </button>
                    <!-- Modal Chỉnh Sửa Review -->
                    <div class="modal fade" id="editModal-{{ $review->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $review->id }}" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <!-- Tiêu đề -->
                          <div class="modal-header">
                            <h5  class="modal-title">Chỉnh sửa đánh giá tại: {{ $review->shop->shop_name ?? 'Quán không xác định' }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>

                          <!-- Form Chỉnh Sửa -->
                          <form action="{{ route('reviews.update', $review->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="modal-body">
                              <!-- Chọn số sao -->
                              <label class="form-label">Đánh giá sao:</label>
                              <select class="form-control" name="rating" required>
                                <option value="5" {{ $review->rating == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ - Xuất sắc</option>
                                <option value="4" {{ $review->rating == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ - Tốt</option>
                                <option value="3" {{ $review->rating == 3 ? 'selected' : '' }}>⭐⭐⭐ - Bình thường</option>
                                <option value="2" {{ $review->rating == 2 ? 'selected' : '' }}>⭐⭐ - Tệ</option>
                                <option value="1" {{ $review->rating == 1 ? 'selected' : '' }}>⭐ - Rất tệ</option>
                              </select>

                              <!-- Nội dung đánh giá -->
                              <label class="form-label mt-2">Nội dung đánh giá:</label>
                              <textarea class="form-control"  name="content" rows="6" required>{{ $review->content }}</textarea>

                              <!-- Ảnh đánh giá (nếu muốn cho phép sửa ảnh) -->
                              <!-- <label class="form-label mt-2">Thay ảnh (nếu cần):</label>
                              <input type="file" class="form-control" name="img_url" accept="image/*">
                              @error('img_url')
                                <span class="text-danger">{{ $message }}</span>
                              @enderror -->

                              <!-- Ngày đánh giá -->
                              <p class="mt-2 text-muted"><i class="bi bi-calendar"></i> Đã tạo: {{ $review->created_at->format('d/m/Y') }}</p>
                            </div>

                            <!-- Nút Gửi -->
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>


                </div>
            </div>
           
        @endforeach
        

</div>
   
</div>
<h4 class="mt-5 mb-3 fw-bold" style="font-size:x-large">📌 Các quán đã lưu</h4>

@if($savedShops->isEmpty())
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


</body>
@endsection
@if(session('jsAlert'))
    <script>
        alert('{{ session('jsAlert') }}');
    </script>
@endif

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const slides = document.querySelectorAll(".slide");
        const dots = document.querySelectorAll(".dot");
        const cards = document.querySelectorAll(".cafe-card");

        let currentIndex = 0;
        let slideInterval = null;

        function showSlide(index) {
            // Ẩn tất cả slide
            slides.forEach((slide, i) => {
                slide.style.display = i === index ? "block" : "none";
            });

            // Cập nhật dot
            dots.forEach(dot => dot.classList.remove("active"));
            if (dots[index]) dots[index].classList.add("active");

            // Cập nhật quán đang hot
            cards.forEach(card => card.classList.remove("active"));
            if (cards[index]) cards[index].classList.add("active");

            currentIndex = index;
        }

        function startAutoSlide() {
            slideInterval = setInterval(() => {
                currentIndex = (currentIndex + 1) % slides.length;
                showSlide(currentIndex);
            }, 6000); // thời gian mỗi slide (ms)
        }

        function stopAutoSlide() {
            clearInterval(slideInterval);
        }

        // Click vào dot
        dots.forEach(dot => {
            dot.addEventListener("click", function () {
                const index = parseInt(this.getAttribute("data-slide"));
                stopAutoSlide();
                showSlide(index);
                startAutoSlide();
            });
        });

        // Khởi động
        showSlide(0);
        startAutoSlide();
    });
</script>
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