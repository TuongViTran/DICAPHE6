@extends('frontend.layout')
@section('title', 'Trang Chủ')
@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF Token -->
    <title>Trang Chủ</title>
</head>
 <!--------------------Thanh tìm kiếm -------------------->
    <section class="search-section">
        <form method="GET" action="{{ route('search.result') }}" class="search-form" style="text-align: center;">
            {{-- Thanh tìm kiếm --}}
            <div class="position-relative search-box" style="display: flex; justify-content: center; align-items: center; gap: 10px;">
                <span class="icon">
                    <img src="{{ asset('frontend/images/Search.svg') }}" alt="Tìm kiếm">
                </span>
                <input type="text" id="searchInput" name="keyword" class="form-control" style="width: 400px; padding: 10px;"
                    placeholder="Hôm nay bạn muốn đi đâu?" value="{{ request('keyword') }}" autocomplete="off">
                    
                <!-- Input ẩn để gửi tọa độ -->
                <input type="hidden" name="user_latitude" id="user_latitude">
                <input type="hidden" name="user_longitude" id="user_longitude">

                <button type="submit" class="btn btn-warning">Tìm kiếm</button>

                <ul id="suggestionList" class="list-group position-absolute w-100" style="z-index: 1000; top: 100%; display: none;"></ul>
            </div>

            <div style="margin-top: 20px; display: flex; justify-content: center; gap: 20px; flex-wrap: wrap;">
                {{-- Khoảng cách --}}
                <div class="filter-container">
                    <button type="button" class="dropdown-btn">
                        <img src="{{ asset('frontend/images/icon_khoangcach.svg') }}" alt="icon" class="icon"> Khoảng cách ▾
                    </button>
                    <div class="dropdown-content">
                        <div class="form-check">
                            <input type="checkbox" name="distance[]" value="1"
                                {{ is_array(request('distance')) && in_array("1", request('distance')) ? 'checked' : '' }}>
                            <label>Có thể đi bộ (≈ 1km)</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="distance[]" value="3"
                                {{ is_array(request('distance')) && in_array("3", request('distance')) ? 'checked' : '' }}>
                            <label>< 3km</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="distance[]" value="5"
                                {{ is_array(request('distance')) && in_array("5", request('distance')) ? 'checked' : '' }}>
                            <label>< 5km</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="distance[]" value="7"
                                {{ is_array(request('distance')) && in_array("7", request('distance')) ? 'checked' : '' }}>
                            <label>< 7km</label>
                        </div>
                    </div>
                </div>


                {{-- Style quán --}}
                <div class="filter-container">
                    <button type="button" class="dropdown-btn">
                        <img src="{{ asset('frontend/images/icon_stylequan.svg') }}" alt="icon" class="icon"> Style quán ▾
                    </button>
                    <div class="dropdown-content">
                        @foreach($styles as $style)
                            <div class="form-check">
                                <input type="checkbox" name="style[]" value="{{ $style->id }}"
                                    {{ is_array(request('style')) && in_array($style->id, request('style')) ? 'checked' : '' }}>
                                <label>{{ $style->style_name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Khoảng giá --}}
                <div class="filter-container">
                    <button type="button" class="dropdown-btn">
                        <img src="{{ asset('frontend/images/icon_gia.svg') }}" alt="icon" class="icon"> Khoảng giá ▾
                    </button>
                    <div class="dropdown-content">
                        <div class="form-check">
                            <input type="checkbox" name="price_range[]" value="lt50"
                                {{ is_array(request('price_range')) && in_array("lt50", request('price_range')) ? 'checked' : '' }}>
                            <label>< 50k</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="price_range[]" value="50_70"
                                {{ is_array(request('price_range')) && in_array("50_70", request('price_range')) ? 'checked' : '' }}>
                            <label>50k - 70k</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="price_range[]" value="gt70"
                                {{ is_array(request('price_range')) && in_array("gt70", request('price_range')) ? 'checked' : '' }}>
                            <label>> 70k</label>
                        </div>
                    </div>
                </div>
            </div>
        </form>


    <div class="hello">
        <h2>Xin chào! Chúng tôi hỗ trợ<br> tìm kiếm quán cà phê</h2>
    </div>
</section>

  <!-------------------Slider -------------------->
   
   
 
<div class="container_slider mt-4">
  <div class="row">
    <!-- Bên trái -->
    <div class="content_slider col-md-6">
      <div class="slider" id="content-slider">
        @foreach($sliderPosts as $post)
          <div class="slide">
          <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark">
            <h2>{{ $post->title }}</h2>
            <p>{{ Str::limit(strip_tags($post->content), 150) }}</p>
            <p class="tacgia">
              <img src="{{ asset('storage/uploads/posts/' . $post->image_url) }}" alt="Tác giả">
              {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }} |
              Tác giả: {{ $post->user->full_name ?? 'Ẩn danh' }}
            </p>
            </a>
          </div>
        @endforeach
      </div>
      <!-- Các bài viết nhỏ -->
      <div class="row mt-4">
        @foreach($posts->skip(1)->take(3) as $post)
          <div class="col-md-4 mb-4">
            <div class="custom-card">
            <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark">
              <div class="card-image" style="background-image: url('{{ asset('storage/uploads/posts/' . $post->image_url) }}');">
                <div class="overlay"></div>
                <div class="card-content">
                  <h5 class="card-title">{{ $post->title }}</h5>
                  <p class="card-text">{{ Str::limit(strip_tags($post->content), 50) }}</p>
                </div>
              </div>
                </a>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Bên phải -->
    <div class="col-md-6">
      <div class="slider-wrapper">
        <div class="slider" id="auto-slider">
          @foreach($sliderPosts as $slide)
            <div class="slide">
            
              <img src="{{ asset('storage/uploads/posts/' . $slide->image_url) }}" alt="{{ $slide->title }}" style="object-fit: cover;">
           
            </div>
          @endforeach
        </div>
        <div class="slider-indicators">
          @foreach($sliderPosts as $index => $slide)
            <span class="dot" data-slide="{{ $index }}"></span>
          @endforeach
        </div>
      </div>
    </div>
  </div> <!-- /row -->
</div> <!-- Style các quán cà phê- -->

   <div class="containter_style">
     <div class="content_style">
        <h2>Trải nghiệm các loại phong cách khác nhau</h2>
          <div class="caption_style" >
         <p>“ Khám phá thế giới cà phê – Thưởng thức mọi phong cách! “</p>
         </div>
     </div>
   <div class=" styles row mt-4">
    <div class="style col-md-3">
        <a href="{{ route('style.show', 1) }}" class="card-link">
            <div class="style_card">
                <img src="{{asset('frontend/images/tt.svg') }}" alt="Truyển Thống">
            </div>
        </a>
    </div>
    <div class="style col-md-3">
        <a href="{{ route('style.show', 2) }}" class="card-link">
            <div class="style_card">
                <img src="{{asset('frontend/images/hd.svg') }}" alt="Hiện Đại">
            </div>
        </a>
    </div>
    <div class="style col-md-3">
        <a href="{{ route('style.show', 3) }}" class="card-link">
            <div class="style_card">
                <img src="{{asset('frontend/images/cs.svg') }}" alt="Công sở ">
            </div>
        </a>
    </div>
    <div class="style col-md-3">
        <a href="{{ route('style.show',4) }}" class="card-link">
            <div class="style_card">
                <img src="{{asset('frontend/images/nm.svg') }}" alt="Nhà Máy">
            </div>
        </a>
    </div>
 </div>
   <!-- Các quán gần tôi -------------------------------------- -------------------------------------------------->
   <div class="container_nearmes">
    <div class="content_nearme" >
          <img src="{{ asset('frontend/images/icon_ganday.svg') }}" alt="icon" class="icon">
          <h2>Gợi ý các quán gần đây</h2>
        </div>
          <div class="row">
                  @foreach($shops as $shop)
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
                                           
                                            <button class="save-btn {{ $shop->liked ? 'liked' : '' }}" data-shop-id="{{ $shop->id }}">
                                                <svg class="save-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-check" viewBox="0 0 16 16" style="width: 20px; height: 20px; margin-right: 5px;">
                                                    <path fill-rule="evenodd" d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                                                    <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                                                </svg>
                                                <span class="save-text">
                                                    @if($shop->liked)
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
                                                <!-- Avatar quán -->
                                                <div class="card_nearme-avatar text-center mt-2">
                                                    <img src="{{ asset('frontend/images/' . basename($shop->user->avatar_url)) }}" class="avatar-img" alt="Avatar">
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
        </div>
        <!-- Các quán gần tôi -------------------------------------- -------------------------------------------------->
   <div class="container_nearmes">
    <div class="content_nearme" >
          <h2>🌟 Các quán có lượt đánh giá 5 sao</h2>
        </div>
          <div class="row">
          @foreach($fiveStarShops as $shop)
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
                                           
                                            <button class="save-btn {{ $shop->liked ? 'liked' : '' }}" data-shop-id="{{ $shop->id }}">
                                                <svg class="save-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-check" viewBox="0 0 16 16" style="width: 20px; height: 20px; margin-right: 5px;">
                                                    <path fill-rule="evenodd" d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                                                    <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z"/>
                                                </svg>
                                                <span class="save-text">
                                                    @if($shop->liked)
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
                                                <!-- Avatar quán -->
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
        </div>
        <!-- Các quán gần tôi -------------------------------------- -------------------------------------------------->
   <div class="container_nearmes">
    <div class="content_nearme" >
          
          <h2>📌 Các quán đã lưu</h2>
        </div>
       
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

        </div>


@endsection
          
<script src="{{ asset('frontend/js/content-slider.js') }}"></script>
<script src="{{ asset('frontend/js/slider.js') }}"></script>
<script src="{{ asset('frontend/js/like.js') }}"></script>
<script src="{{ asset('frontend/js/save-favorite.js') }}"></script>
<script src="{{ asset('frontend/js/seacher.js') }}"></script>
<script src="{{ asset('frontend/js/ajax.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('frontend/js/save-favorite.js') }}"></script>

<script>
    function updateSliderValue(slider) {
    let valueLabel = slider.nextElementSibling;
    valueLabel.textContent = slider.value + (slider.max == 15 ? 'km' : 'k');
}
document.querySelectorAll('.dropdown-btn').forEach(button => {
    button.addEventListener('click', function() {
        let content = this.nextElementSibling;
        if (content.classList.contains('active')) {
            content.style.maxHeight = '0';
            content.style.opacity = '0';
            setTimeout(() => content.classList.remove('active'), 300);
        } else {
            content.classList.add('active');
            content.style.maxHeight = content.scrollHeight + 'px';
            content.style.opacity = '1';
        }
    });
});
</script>
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