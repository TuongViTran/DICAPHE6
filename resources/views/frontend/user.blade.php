@extends('frontend.layout')
@section('title', 'User')

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
    .hot-cafes-container {
      display: flex;
      flex-wrap: wrap;
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }
    .hot-cafes-left {
      flex: 1;
      min-width: 220px;
    }
    .hot-cafes-left img {
      width: 100%;
      height: 70%;
      border-radius: 10px;
      object-fit: cover;
    }
    .hot-cafes-right {
      flex: 2;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 15px;
      padding-left: 20px;
    }
    .cafe-card {
      background-color: #f9f9f9;
      border-radius: 8px;
      padding: 10px 15px;
    }
    .cafe-card:nth-child(1) {
      background-color: #f4f8cc;
    }
    .cafe-card h4 {
      margin: 0 0 6px;
      font-size: 16px;
    }
    .cafe-info {
      font-size: 13px;
      margin: 2px 0;
    }
    .stars {
      color: #fbbf24;
      font-size: 14px;
    }
    .indicator {
      text-align: center;
      margin-top: 10px;
    }
    .indicator span {
      display: inline-block;
      width: 10px;
      height: 10px;
      margin: 0 3px;
      border-radius: 50%;
      background: #d1d5db;
    }
    .indicator span.active {
      background: #c0d904;
    }
    .chucnang {
        margin-left:195px
    }
    .chucnang button{
        margin-left: 10px;
        color:white
    }
    .chucnang button svg{
        margin-top:-4px;
        margin-left:4px
    }
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

  </style>
@section('content')
<div class="container mt-4">
        <div class="p-4 rounded shadow-sm mb-4 d-flex align-items-center justify-content-around" style="background: linear-gradient(to bottom, rgb(180, 241, 200), #c2ebfb00);">
            <!-- Cột bên trái: Ảnh đại diện + Thông tin quán -->
            <div class="d-flex flex-column align-items-center">
                <img src="{{ asset('frontend/images/' . ($user->avatar_url ?? 'avt.png')) }}" alt="User profile picture" class="rounded-circle mb-2" width="90" height="90" style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
                <div class="text-left">
                <h4 class="text-center fw-bold mb-1">{{ $user->full_name ?? 'Khách hàng' }}</h4>
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


        <body>
  <div class="section-title"><h5 style="font-weight:700"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-list-task" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M2 2.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V3a.5.5 0 0 0-.5-.5zM3 3H2v1h1z"/>
  <path d="M5 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M5.5 7a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1zm0 4a.5.5 0 0 0 0 1h9a.5.5 0 0 0 0-1z"/>
  <path fill-rule="evenodd" d="M1.5 7a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2a.5.5 0 0 1-.5-.5zM2 7h1v1H2zm0 3.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm1 .5H2v1h1z"/>
</svg> Danh sách quán café đang hot:</h5></div>
  <div class="hot-cafes-container">
    <div class="hot-cafes-left">
      <img src="" alt="Cafe Image">
      <div class="indicator">
        <span class="active"></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div class="hot-cafes-right">
      <div class="cafe-card">
        <h4>01 : Thong Thả</h4>
        <div class="cafe-info">🕒 Open daily: 7:00 - 22:00</div>
        <div class="cafe-info">💸 Price: 25k - 65k</div>
        <div class="cafe-info">📍 Address: 75 Bùi Thị Xuân</div>
        <div class="stars">★★★★★</div>
      </div>
      <div class="cafe-card">
        <h4>02 : Ngày Bình Yên</h4>
        <div class="cafe-info">🕒 Open daily: 7:00 - 22:00</div>
        <div class="cafe-info">💸 Price: 35k - 65k</div>
        <div class="cafe-info">📍 Address: 75 Bùi Thị Xuân</div>
        <div class="stars">★★★★★</div>
      </div>
      <div class="cafe-card">
        <h4>03 : Ngày Bình Yên</h4>
        <div class="cafe-info">🕒 Open daily: 7:00 - 22:00</div>
        <div class="cafe-info">💸 Price: 35k - 65k</div>
        <div class="cafe-info">📍 Address: 75 Bùi Thị Xuân</div>
        <div class="stars">★★★★★</div>
      </div>
      <div class="cafe-card">
        <h4>04 : Ngày Bình Yên</h4>
        <div class="cafe-info">🕒 Open daily: 7:00 - 22:00</div>
        <div class="cafe-info">💸 Price: 35k - 65k</div>
        <div class="cafe-info">📍 Address: 75 Bùi Thị Xuân</div>
        <div class="stars">★★★★★</div>
      </div>
    </div>
  </div>
  <br>
<!-- <hr style="margin:30px"> -->

  <div class="row">
  <h5 style="font-weight:700"><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
</svg> Feedback của bạn</h5>

<div style="display:flex; width:;">
@if ($reviews->count() > 3)
    <div class="review-carousel">
@else
    <div style="display:flex; flex-wrap: wrap;">
@endif
@foreach ($reviews->items() as $review)
            
            <div class="card mb-1 p-3" style=" border:none; border-right:1px" >
                <div class="d-flex align-items-center" >
                    <!-- Avatar người dùng -->
                     
                    <img src="{{ asset('frontend/images/' . ($review->user->avatar_url ?? 'avt.png')) }}" style="width:50px;height:50px; margin-top:-15px" class="rounded-circle me-2" alt="User Avatar">

                    <div class="ft">
                        <strong>{{ $review->user->full_name ?? 'Người dùng ẩn danh' }}</strong>
                        <span style="max-width: 30px; "> đang ở tại <strong >{{ $review->shop->shop_name ?? 'Người dùng ẩn danh' }}</strong>
                        </span>
    
                        <div style="display:flex">
                        <p class="text-muted small">{{ $review->created_at ? $review->created_at->format('d/m/Y') : 'Không có ngày' }}</p>&ensp;
                            <span style="margin-right:5px;margin-left:0px;" class="like-count ">{{ $review->likes_count }} </span>  lượt thích   <!-- Hiển thị số sao -->
                            <p class="text-warning" style="margin-left:25px;">    
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star"></i>
                                    @endfor
                            </p>
    
                            <button class="like-button" data-id="{{ $review->id }}" style="border: none; background: none; cursor: pointer; margin-top:-19px;position: relative; left: 50px; top:-23px">
                                ❤️ 
                            </button>
                            
                        </div>
                    </div>           
                </div>
                <!-- Nội dung đánh giá -->
                <p class="" style="margin-left:50px">{{ $review->content }}</p>
                
    
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
                    style="height:150px; width:130px; object-fit:cover; margin-right:15px"
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
                  <button type="submit" class="btn btn-danger btn-sm" style="height:35px">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
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
        <h5 class="modal-title">Chỉnh sửa đánh giá tại: {{ $review->shop->shop_name ?? 'Quán không xác định' }}</h5>
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
          <textarea class="form-control" name="content" rows="3" required>{{ $review->content }}</textarea>

          <!-- Ảnh đánh giá (nếu muốn cho phép sửa ảnh) -->
          <label class="form-label mt-2">Thay ảnh (nếu cần):</label>
          <input type="file" class="form-control" name="img_url" accept="image/*">
          @error('img_url')
            <span class="text-danger">{{ $message }}</span>
          @enderror

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

</body>
@endsection
