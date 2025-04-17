@extends('frontend.layout')
@section('title', 'Trang Chủ')
@section('content')
 <!-- Thanh tìm kiếm -------------------->
 <section class="search-section">
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
       
    </section>

<div class="container_slider mt-4">
  <div class="row">
    <!-- Bên trái -->
    <div class="content_slider col-md-6">
      <div class="slider" id="content-slider">
        @foreach($sliderPosts as $post)
          <div class="slide">
            <h2>{{ $post->title }}</h2>
            <p>{{ Str::limit(strip_tags($post->content), 150) }}</p>
            <p class="tacgia">
              <img src="{{ asset('storage/uploads/posts/' . $post->image_url) }}" alt="Tác giả">
              {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }} |
              Tác giả: {{ $post->user->full_name ?? 'Ẩn danh' }}
            </p>
          </div>
        @endforeach
      </div>
      <!-- Các bài viết nhỏ -->
      <div class="row mt-4">
        @foreach($posts->skip(1)->take(3) as $post)
          <div class="col-md-4 mb-4">
            <div class="custom-card">
              <div class="card-image" style="background-image: url('{{ asset('storage/uploads/posts/' . $post->image_url) }}');">
                <div class="overlay"></div>
                <div class="card-content">
                  <h5 class="card-title">{{ $post->title }}</h5>
                  <p class="card-text">{{ Str::limit(strip_tags($post->content), 50) }}</p>
                </div>
              </div>
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
</div> <!-- /container_slider -->

   <div class="containter_style">
     <div class="content_style">
        <h2>Trải nghiệm các loại phong cách khác nhau</h2>
          <div class="caption_style" >
         <p>“ Khám phá thế giới cà phê – Thưởng thức mọi phong cách! “</p>
         </div>
     </div>
   <div class=" styles row mt-4">
    <div class="style col-md-3">
        <a href="link_traditional.html" class="card-link">
            <div class="style_card">
                <img src="{{asset('frontend/images/tt.svg') }}" alt="Traditional Coffee Shop">
            </div>
        </a>
    </div>
    <div class="style col-md-3">
        <a href="link_traditional.html" class="card-link">
            <div class="style_card">
                <img src="{{asset('frontend/images/hd.svg') }}" alt="Traditional Coffee Shop">
            </div>
        </a>
    </div>
    <div class="style col-md-3">
        <a href="link_traditional.html" class="card-link">
            <div class="style_card">
                <img src="{{asset('frontend/images/cs.svg') }}" alt="Traditional Coffee Shop">
            </div>
        </a>
    </div>
    <div class="style col-md-3">
        <a href="link_traditional.html" class="card-link">
            <div class="style_card">
                <img src="{{asset('frontend/images/nm.svg') }}" alt="Traditional Coffee Shop">
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
                                            @for($i = 0; $i < 5; $i++)
                                                <span class="card_nearme-star" style="color: {{ $i < $shop->reviews_avg_rating ? '#FFC107' : '#e4e5e9' }}; font-size: 1.2em;">★</span>
                                            @endfor
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="heart-icon me-1 like-btn" data-id="{{ $shop->id }}" 
                                                style="font-size: 1.4em; cursor: pointer; transition: 0.3s; color: {{ $shop->liked ? '#FF4D4D' : '#e4e5e9' }};">
                                                {{ $shop->liked ? '❤️' : '♡' }}
                                            </span>
                                            <span id="like-count-{{ $shop->id }}" style="margin-left: 5px; font-weight: bold;">
                                                {{ $shop->likes_count }}
                                            </span>
                                            <button class="card_nearme-save">
                                            <img src="{{ asset('frontend/images/icon_luu.svg') }}" alt="save icon" style="width: 20px; height: 20px; margin-bottom:5px;"> Lưu Nè
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
          <img src="{{ asset('frontend/images/icon_ganday.svg') }}" alt="icon" class="icon">
          <h2>Các quán có lượt đánh giá 5 sao</h2>
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
                                            @for($i = 0; $i < 5; $i++)
                                                <span class="card_nearme-star" style="color: {{ $i < $shop->reviews_avg_rating ? '#FFC107' : '#e4e5e9' }}; font-size: 1.2em;">★</span>
                                            @endfor
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <span class="heart-icon me-1 like-btn" data-id="{{ $shop->id }}" 
                                                style="font-size: 1.4em; cursor: pointer; transition: 0.3s; color: {{ $shop->liked ? '#FF4D4D' : '#e4e5e9' }};">
                                                {{ $shop->liked ? '❤️' : '♡' }}
                                            </span>
                                            <span id="like-count-{{ $shop->id }}" style="margin-left: 5px; font-weight: bold;">
                                                {{ $shop->likes_count }}
                                            </span>
                                            <button class="card_nearme-save">
                                            <img src="{{ asset('frontend/images/icon_luu.svg') }}" alt="save icon" style="width: 20px; height: 20px; margin-bottom:5px;"> Lưu Nè
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
@endsection
          
<script src="{{ asset('frontend/js/content-slider.js') }}"></script>
<script src="{{ asset('frontend/js/slider.js') }}"></script>
<script src="{{ asset('frontend/js/like.js') }}"></script>
<script src="{{ asset('frontend/js/seacher.js') }}"></script>
    
    