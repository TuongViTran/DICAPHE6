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
.review-content {
  margin-left: 50px;
  white-space: nowrap;        /* Không cho xuống dòng */
  overflow: hidden;           /* Ẩn phần dư */
  text-overflow: ellipsis;    /* Hiện dấu ... */
  max-width: 400px;           /* Giới hạn chiều ngang */
  display: block;             /* Đảm bảo nó hoạt động đúng */
  margin-bottom:10px
}


.hot-cafes-right {
  flex: 1;
  display: grid;
  grid-template-columns: 1fr 1fr;
  
  gap: 0;
}

/* Tạo đường kẻ dọc ở giữa 2 cột */
.hot-cafes-right .cafe-card:nth-child(odd) {
  border-right: 1px solid #ccc;
  padding: 12px 15px 12px 15px;
}

.hot-cafes-right .cafe-card:nth-child(even) {
  padding: 12px 15px 12px 15px;
}




.slider-wrapper {
  flex: 1;
  position: relative;
  width: 60%;
  border-radius: 12px;
  overflow: hidden;
}

.slider {
  display: flex;
  height: 100%;
  transition: transform 0.5s ease;
}

.slide {
  min-width: 100%;
  display: none;
}

.slide:first-child {
  display: block;
}

.slide img {
  width: 100%;
  height: auto;
  border-radius: 12px;
  object-fit: cover;
}

.slider-indicators {
  position: absolute;
  bottom: 10px;
  left: 50%;
  transform: translateX(-50%);
  text-align: center;
  margin-top: 10px;
}

.dot {
  display: inline-block;
  width: 10px;
  height: 10px;
  margin: 5px;
  background-color: #bbb;
  border-radius: 50%;
  cursor: pointer;
}

.dot.active {
  background-color: #333;
}

/* Right side: Cafe list */
.hot-cafes-right {
  flex: 1;
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 15px;
  width: 40%;
}

.cafe-card {
  padding: 12px;
  border-radius: 0; /* Xóa bo góc */
  background-color: white;
  border: none; /* Bỏ viền xám */
}


.cafe-card.active {
  background-color: #fefebf;
}

.cafe-card h4 {
  font-size: 16px;
  font-weight: bold;
  margin-bottom: 8px;
}

.cafe-info {
  margin-bottom: 7px;
  font-size: 14px;
}

.stars {
  color: gold;
  font-size: 14px;
}

.cafe-card {
    background-color: white;
    transition: background-color 0.3s ease;
}

.cafe-card.active {
    background-color: #fdfdbc; /* nền vàng */
}



  
  </style>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

@section('content')
<div class="container mt-4">
        <div class="p-4 rounded shadow-sm mb-4 d-flex align-items-center justify-content-around" style="background: linear-gradient(to bottom, rgb(180, 241, 200), #c2ebfb00);">
            <!-- Cột bên trái: Ảnh đại diện + Thông tin quán -->
            <div class="d-flex flex-column align-items-center">
                <img src="{{ asset('frontend/images/' . basename($user->avatar_url ?? 'avt.png')) }}" alt="User profile picture" class="rounded-circle mb-2" width="90" height="90" style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
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
  <div class="section-title"><p style="font-weight:700;font-size: 22px;"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-list-task" viewBox="0 0 16 16">
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
                <p style="font-size: 22px; font-weight:bold">{{ sprintf('%02d', $index + 1) }} : {{ $cafe->shop_name }}</p >
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
                @php
                        $rating = $cafe->reviews_avg_rating;
                    @endphp

                    @for ($i = 1; $i <= 5; $i++)
                        @if ($rating >= $i)
                            <i class="fas fa-star" style="color: #FFC107;"></i> <!-- sao đầy -->
                        @elseif ($rating >= ($i - 0.5))
                            <i class="fas fa-star-half-alt" style="color: #FFC107;"></i> <!-- sao nửa -->
                        @else
                           <i class="far fa-star " style="color: #FFC107;"></i>  <!-- sao rỗng -->
                        @endif
                    @endfor
                </div>
            </div>
        @endforeach
    </div>
</div>
  <br>
<!-- <hr style="margin:30px"> -->

  <div class="row">
  <h5 style="font-weight:700;font-size: 22px;"><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
</svg> Feedback của bạn</h5>

<div style="display:flex; width:; ">
@if ($reviews->count() > 3)
    <div class="review-carousel">
@else
    <div style="display:flex; flex-wrap: wrap; ">
@endif
@foreach ($reviews->items() as $review)
            
<div class="card mb-1 p-3" style="border: none; position: relative; border-top-right-radius: 0; border-bottom-right-radius: 0;">
    <!-- Border phải giả, chiều cao giới hạn -->
    <div style="position: absolute; top: 15px; right: 0; height: 100%; max-height: 310px; width: 1px; background-color: #ccc;"></div>


                <div class="d-flex align-items-center">
                    <!-- Avatar người dùng -->
                     
                    <img src="{{ asset('frontend/images/' . basename($review->user->avatar_url)) }}"
         onerror="this.onerror=null; this.src='{{ asset('frontend/images/avt.png') }}';"
         width="60" height="60" alt="Avatar"
         style="border-radius: 50%; box-shadow: 0 2px 8px rgba(0,0,0,0.15); object-fit: cover; margin-right:15px">

                    <div class="ft" style="margin-top:15px">
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
