@extends('frontend.layout')
@section('title', 'Feed')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

</style>
<hr>
<div class="container mt-4">
    <div class="row">
        <!-- Danh sách review -->
        <div class="col-md-7">
            <h4 style="margin-bottom:20px"><strong>Xem review để chọn quán nè</strong></h4>
            @foreach ($reviews->items() as $review)
            
        <div class="card mb-1 p-3" style="border:none">
            <div class="d-flex align-items-center">
                <!-- Avatar người dùng -->
                <img src="https://surl.li/qroawz" style="width:50px;height:50px; margin-top:-15px" class="rounded-circle me-2" alt="User Avatar">
                <div>
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

                        <button class="like-button" data-id="{{ $review->id }}" style="border: none; background: none; cursor: pointer; margin-top:-19px;position: relative; left: 200px; top:-23px">
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
                    style="height:230px; width:190px; object-fit:cover; margin-right:15px"
                    class="img-fluid rounded shadow"
                    alt="Review Image"
                    onerror="this.src='{{ asset('frontend/images/tt.svg') }}';"
                >
            </div>
        @endforeach
    </div>
@endif
  
        
        </div>
    @endforeach





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
    <div class="post">
      <img src="" alt="cafe">
      <div class="post-content">
        <h4>Quán cà phê ngõ nhỏ Đà Nẵng</h4>
        <p>Trước khi bạn bắt đầu chuyến phiêu lưu cà phê Hà Nội của riêng mình, hãy để vietcetera gợi ý cho bạn những nhà cà phê đậm chất tỉnh lẻ và sáng tạo nhé.</p>
      </div>
    </div>

    <!-- Lặp lại post -->
    <div class="post">
      <img src="" alt="cafe">
      <div class="post-content">
        <h4>Quán cà phê ngõ nhỏ Đà Nẵng</h4>
        <p>Trước khi bạn bắt đầu chuyến phiêu lưu cà phê Hà Nội của riêng mình, hãy để vietcetera gợi ý cho bạn những nhà cà phê đậm chất tỉnh lẻ và sáng tạo nhé.</p>
      </div>
    </div>

    <div class="post">
      <img src="" alt="cafe">
      <div class="post-content">
        <h4>Quán cà phê ngõ nhỏ Đà Nẵng</h4>
        <p>Trước khi bạn bắt đầu chuyến phiêu lưu cà phê Hà Nội của riêng mình, hãy để vietcetera gợi ý cho bạn những nhà cà phê đậm chất tỉnh lẻ và sáng tạo nhé.</p>
      </div>
    </div>

    <div class="post">
      <img src="" alt="cafe">
      <div class="post-content">
        <h4>Quán cà phê ngõ nhỏ Đà Nẵng</h4>
        <p>Trước khi bạn bắt đầu chuyến phiêu lưu cà phê Hà Nội của riêng mình, hãy để vietcetera gợi ý cho bạn những nhà cà phê đậm chất tỉnh lẻ và sáng tạo nhé.</p>
      </div>
    </div>

    <div class="post">
      <img src="" alt="cafe">
      <div class="post-content">
        <h4>Quán cà phê ngõ nhỏ Đà Nẵng</h4>
        <p>Trước khi bạn bắt đầu chuyến phiêu lưu cà phê Hà Nội của riêng mình, hãy để vietcetera gợi ý cho bạn những nhà cà phê đậm chất tỉnh lẻ và sáng tạo nhé.</p>
      </div>
    </div>
  </div>
                    
                    </ul>
                </div>
            </div>
            
            <!-- Mã khuyến mãi -->
            <div class="card mb-3">
                <div class="card-header bg-light"><strong>Thu thập mã khuyến mãi</strong></div>
                <div class="card-body">
                <img style="margin-left:20px" src="{{ asset('frontend/images/voucher.jpg') }}" alt="Flower">



                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!--  -->




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.like-button').click(function() {
            let reviewId = $(this).data('id'); // Lấy ID của review
            let likeCount = $(this).siblings('.like-count'); // Vị trí hiển thị số lượt thích
            let button = $(this);

            $.ajax({
                url: `/review/${reviewId}/like`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}' // Token bảo mật Laravel
                },
                success: function(response) {
                    likeCount.text(response.likes); // Cập nhật số lượt thích
                    button.addClass('liked'); // Thêm hiệu ứng nếu cần
                },
                error: function() {
                    alert('Có lỗi xảy ra, vui lòng thử lại!');
                }
            });
        });
    });
</script>
