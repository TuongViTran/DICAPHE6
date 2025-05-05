@extends('frontend.layout')
@section('title', 'Feed')
@section('content')
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<style>
    .user-avatar {
    width: 40px;
    height: 40px;
    object-fit: cover;
}

.review-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
}

.review-images {
    display: flex;
    gap: 5px;
    margin-top: 5px;
    overflow-x: auto;
}

.review-img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 8px;
}

.card {
    transition: transform 0.2s ease-in-out;
    
    
}
.card strong{
    margin-left:5px
}
.card:hover {
    transform: translateY(-5px);
}

.btn {
    font-size: 13px;
    padding: 5px 10px;
}
.td{
    display:flex;
    font-size:small;
    display:flex
}
.td span{
    font-size:small;
    margin-left:5px
}
.ft{
    font-size:13px
}

    /* .header {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }
    .header img {
      width: 32px;
      height: 32px;
      margin-right: 10px;
    }
    .header h2 {
      font-size: 20px;
      font-weight: bold;
      margin: 0;
    } */
    .post {
      display: flex;
      margin-bottom: 16px;
      background: #f9fafb;
      border-radius: 8px;
      padding: 10px;
    }
    .post img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 8px;
      margin-right: 10px;
    }
    .post-content h4 {
      margin: 0;
      font-size: 16px;
      font-weight: bold;
    }
    .post-content p {
      margin: 4px 0 0;
      font-size: 14px;
      color: #4b5563;
    }
    .review-scroll-container {
    max-height: 1250px;
    overflow-y: auto;
    scrollbar-width: none; /* Firefox */
    margin-bottom: 50px
}
.review-scroll-container::-webkit-scrollbar {
    display: none; /* Chrome, Safari */
}
</style>
<hr>
<div class="container mt-4">
    <div class="row">
        <!-- Danh sách review -->
        <div class="col-md-7">
            <p style="margin-bottom:20px;font-size:x-large"><strong>Xem review để chọn quán nè</strong></p>
            <div class="review-scroll-container">
            @foreach ($reviews->items() as $review)
            @php
                $userLiked = auth()->check() && $review->likedUsers->contains(auth()->id());
            @endphp
            <div class="card mb-1 p-3" style="border:none">
                <div class="d-flex align-items-center">
                    <!-- Avatar người dùng -->
                    @php
    $shop = $review->shop ?? null;
    $avatarUrl = $shop && $shop->user && $shop->user->avatar_url
        ? asset('storage/uploads/avatars/' . basename($shop->user->avatar_url))
        : asset('frontend/images/avt.png');
@endphp


<div style="width: 60px; height: 60px; border-radius: 50%; overflow: hidden; margin-left: 12px; margin-top: 5px; flex-shrink: 0;">
<img src="{{ asset('storage/uploads/avatars/' . basename($review->user->avatar_url ?? 'avt.png')) }}"
     onerror="this.onerror=null; this.src='{{ asset('frontend/images/avt.png') }}';"
     width="60" height="60" alt="Avatar"
     style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; box-shadow: 0 2px 8px rgba(0,0,0,0.15); margin-right: 15px;">
</div>

    
                    <div style="margin-top:15px">
                        <strong>{{ $review->user->full_name ?? 'Người dùng ẩn danh' }}</strong>
                        <span style="max-width: 30px; "> đang ở tại 
                            <strong >  
                                <a href="{{ route('frontend.shop', ['id' => $review->shop->id]) }}">
                                <strong>{{ $review->shop->shop_name }}</strong>
                                </a>
                            </strong>
                        </span>
    
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
                                style="border: none; background: none; cursor: pointer; margin-top:-19px;position: relative; left: 200px; top:-23px">
                                <i class="fa{{ $userLiked ? 's' : 'r' }} fa-heart text-{{ $userLiked ? 'danger' : 'dark' }}"></i>
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
            @for ($i = 0; $i < 3; $i++)
                @php
                    $img = isset($images[$i]) ? trim($images[$i]) : '';
                    $isUrl = Str::startsWith($img, ['http://', 'https://']);
                @endphp
    
                <div class="col-4 d-flex mb-2">
                    @if ($img !== '')
                        <img
                            src="{{ $isUrl ? $img : asset('storage/' . $img) }}"
                            style="height:280px; width:250px; object-fit:cover; margin-right:10px"
                            class="img-fluid rounded shadow"
                            alt="Review Image"
                            onerror="this.src='{{ asset('frontend/images/tt.svg') }}';"
                        >
                    @else
                        <div style="height:280px; width:250px; margin-right:10px; background-color:#f0f0f0;"
                             class="d-flex align-items-center justify-content-center rounded shadow text-muted flex-column">
                            <i class="fas fa-image fa-2x mb-2"></i>
                            <small>Chưa có ảnh</small>
                        </div>
                    @endif
                </div>
            @endfor
        </div>
    @endif
      
            
            </div>
        @endforeach
            </div>





        </div>
        
        <!-- Sidebar phải -->
        <div class="col-md-5">
            <!-- Bảng tin -->
            <div class="card mb-3">
                
                <div class="card-header bg-light"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
  <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5"/>
  <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
</svg> <strong>Bảng tin Dicaphe</strong></div>
                <div class="card-body">
                    <ul class="list-unstyled">
                       
                    <div class="container">
    <!-- <div class="header">
      <img src="https://img.icons8.com/color/48/000000/coffee-to-go.png" alt="icon">
      <h2>Bảng tin DiCaPhe</h2>
    </div> -->

    <!-- Post item -->
     @foreach ($posts as $post)
     <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark">
        <div class="post">
        <img src="{{ asset('storage/uploads/posts/' . $post->image_url) }}" alt="cafe">
        <div class="post-content">
            <h4>{{ $post->title }}</h4>
            <p>{{ Str::limit(strip_tags($post->content), 50) }}</p>
        </div>
        </div>
    </a>
        @endforeach

    
  </div>
                    
                    </ul>
                </div>
            </div>
            
            <!-- Mã khuyến mãi
            <div class="card mb-3">
                <div class="card-header bg-light"><strong>Thu thập mã khuyến mãi</strong></div>
                <div class="card-body">
                <img style="margin-left:20px" src="{{ asset('frontend/images/voucher.jpg') }}" alt="Flower">



                </div>
            </div> -->
            
            <img src="{{ asset('frontend/images/anhdep.jpg') }}" alt="">

            <div class="mt-6">
            <img alt="" class="rounded-lg" style="height:100px;width:400px; margin-left:60px"  src="{{ asset('frontend/images/quangcao.jpg' ) }}" />
        </div>

        </div>
    </div>
</div>
@endsection

<!--  -->




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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


