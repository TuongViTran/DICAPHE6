@extends('frontend.layout')
@section('title', 'Blog')
@section('content')
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



    <div class="container_slider">
      <div class="row">
        <!-- Cột trái: danh sách bài viết -->
        <div class="col-md-9">
          <h5 class="fw-bold mb-3">📸 Các góc nhìn mới</h5>

          @foreach($posts as $post)
          <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark">
            <div class="d-flex mb-4 border-bottom pb-3 " style="height: 220px;">
                <div style="width: 320px; height: 200px; overflow: hidden; flex-shrink: 0;">
                <img src="{{ asset('storage/uploads/posts/' . $post->image_url) }}" 
                    alt="{{ $post->title }}" 
                    class="img-fluid rounded"
                    style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div class="ms-3">
                <h6 class="fw-bold mb-1">{{ $post->title }}</h6>
                <p class="text-muted small mb-1">
                    {{ \Carbon\Carbon::parse($post->created_at)->format('H:i d/m/Y') }} | 
                    Tác giả: {{ $post->user->full_name ?? 'Ẩn danh' }}
                </p>
                <p class="mb-0">{{ Str::limit(strip_tags($post->content), 80) }}</p>
                </div>
            </div>
            </a>
          @endforeach
          <!-- Pagination -->
          <div class="mt-3">
                {{ $posts->links('pagination::bootstrap-5') }}
            </div>

        </div>

        
        <!-- Cột phải: banner / quảng cáo -->
        <div class="col-md-3 ">
          <img src="{{ asset('frontend/images/banner1.png') }}" class="img-fluid rounded shadow-sm mb-5 " alt="Banner quảng cáo" style="width: 100%;">
          <img src="{{ asset('frontend/images/hihi.png') }}" class="img-fluid rounded shadow-sm" alt="Banner quảng cáo" style="width: 100%;">
        </div>
      </div>
  </div>
@endsection
<script src="{{ asset('frontend/js/slider.js') }}"></script>