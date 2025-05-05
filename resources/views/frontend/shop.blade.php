@extends('frontend.layout')
@section('title', 'Shop')
<style>
    #tt1 {
        display:flex;
    }
   
    #tt1 div p{
        font-size:22px;
        
    }
    .flex i{
        font-size:x-large;
        margin:5px
    }
    .tt2 div{
        display:flex;
        margin-bottom:5px;
    }
    .tt2 div svg{
        margin: 5px 15px 0 20px
    }
    #tt3{
        font-size:20px;
    }
    #tt3 p{
        margin: 10px 0 5px 25px;
    }
    #bt button{
        border: solid 1px;
    }
    .rounded-lg img{
        max-height:180px;
    }
    .grid-cols-3 img {
    width: 100%;
    height: 200px; /* hoặc 220px tùy bạn */
    object-fit: cover;
}
 
    .hide-scrollbar {
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none; /* Internet Explorer 10+ */
    }
    .hide-scrollbar::-webkit-scrollbar {
        display: none; /* Chrome, Safari and Opera */
    }
    .slogan {
    font-size: 1.5rem; /* nhỏ lại từ 2rem còn 1.5rem */
    font-family: 'Dancing Script', cursive;
    color: #5e412f;
    text-align: center;
    margin: 30px auto;
    padding: 15px 20px; /* giảm padding */
    max-width: 500px; /* thu nhỏ khung */
    background: #fff9f5;
    border: 1.5px dashed #c19a6b; /* viền mỏng hơn */
    border-radius: 15px; /* bo góc mềm hơn */
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08); /* bóng đổ nhẹ hơn */
    animation: fadeIn 2s ease-in-out;
    position: relative;
}

@keyframes fadeIn {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}

.slogan::before {
    content: "☕";
    font-size: 2rem; /* icon nhỏ hơn */
    position: absolute;
    top: -15px;
    left: -15px;
}

.slogan::after {
    content: "☕";
    font-size: 2rem;
    position: absolute;
    bottom: -15px;
    right: -15px;
}
.decoration-space {
    width: 100%;
    height: 80px;
    margin-top: 20px;
    background: url('/path-to-your-leaf-or-coffee-pattern.png') center no-repeat;
    background-size: contain;
    opacity: 0.5;
}
</style>

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- CSRF Token -->
   
</head>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com"></script>


    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg ">
        <div class="flex flex-col md:flex-row">
            <div class="md:w-1/2">
            <img 
    alt="Front view of Ngày Bình Yên Cà Phê" 
    class="rounded-2xl mb-4" 
    style="max-height: 400px; min-width: 615px; object-fit: cover;" 
    src="{{ asset('frontend/images/' . $coffeeShop->cover_image) }}" 
/>                <div class="grid grid-cols-3 gap-x-4 mt-4">
                    <img alt="Food item 1" class="rounded-2xl w-full aspect-[3/2] object-cover" src="{{ asset('frontend/images/' . $coffeeShop->image_1) }}" />
                    <img alt="Food item 2" class="rounded-2xl w-full aspect-[3/2] object-cover" src="{{ asset('frontend/images/' . $coffeeShop->image_2) }}" />
                    <img alt="Food item 3" class="rounded-2xl w-full aspect-[3/2] object-cover" src="{{ asset('frontend/images/' . $coffeeShop->image_3) }}" />
                </div>

               
            </div>
            &emsp;&emsp;
            <div class="md:w-1/2 md:pl-6">
                <h1 class="text-5xl font-bold" style="font-family:Futura">{{ $coffeeShop->shop_name }}</h1>
                <div class="flex items-center mt-2">
                    <div class="flex text-yellow-500">
                    <x-rating :score="$shop->reviews_avg_rating ?? 0" />

                  
                    </div>
                        @php
                        $style = $coffeeShop->style;
                        $bgColor = '#DFFEF2';
                        $textColor = '#00B140';

                        if ($style->id == 1) {
                            $bgColor = '#EBF6F4'; $textColor = '#0F4C3A'; // Truyền thống
                        } elseif ($style->id == 2) {
                            $bgColor = '#F1E8F8'; $textColor = '#5F276D'; // Hiện đại
                        } elseif ($style->id == 3) {
                            $bgColor = '#FBF5E6'; $textColor = '#6F4E28'; // Công sở
                        } elseif ($style->id == 4) {
                            $bgColor = '#F7E7E7'; $textColor = '#76333C'; // Nhà máy
                        }
                        @endphp
                    <span class="badge" style="background-color: {{ $bgColor }}; color: {{ $textColor }}; font-size: 1rem; font-weight: 500; padding: 6px 16px; border-radius: 999px; margin:0 5px 0 5px ">
                        {{ $style->style_name }}
                    </span>
                    <span class="badge" style="background-color: #DFFEF2; color: #00B140; font-size: 1rem; font-weight: 500; padding: 6px 16px; border-radius: 999px;">
                        {{$coffeeShop->status}}
                    </span>

                </div>
                <br>
                <div class="mt-2" id="tt1">
                @if ($shop->user && $shop->user->avatar_url)
    <img src="{{ asset('storage/uploads/avatars/' . basename($shop->user->avatar_url)) }}"
         onerror="this.onerror=null; this.src='{{ asset('frontend/images/avt.png') }}';"
         style="width:80px; height:80px; border-radius:50%; margin-top:5px; margin-left:20px"
         class="shadow-lg"
         alt="Avatar chủ quán">
@else
    <img src="{{ asset('frontend/images/avt.png') }}"
         style="width:80px; height:80px; border-radius:50%; margin-top:5px; margin-left:20px"
         class="shadow-lg"
         alt="Avatar mặc định">
@endif

                    <div class="tt2" >
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-door-open-fill" viewBox="0 0 16 16">
                            <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15zM11 2h.5a.5.5 0 0 1 .5.5V15h-1zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
                            </svg>
                            <p class="text-gray-500">Open daily: {{ $coffeeShop->opening_time }} - {{ $coffeeShop->closing_time }}</p>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-tags-fill" viewBox="0 0 16 16">
                            <path d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                            <path d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043z"/>
                            </svg>
                             <p class="text-gray-500">Price: {{ $coffeeShop->min_price }} - {{ $coffeeShop->max_price }}</p>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                            </svg>
                            <p class="text-gray-500">Address: {{ $coffeeShop->address->street}}, {{ $coffeeShop->address->district}}, {{ $coffeeShop->address->city}}</p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4" id="tt3">
                    <h2 class="text-3xl font-bold">Thông tin</h2>
                    <p class="text-gray-500">IG: @Ngaybinhyen_Giaolộ8</p>
                    <p class="text-gray-500"><strong>Đậu xe:</strong> {{ $coffeeShop->parking }}</p>
                    <p class="text-gray-500"><strong>Mật khẩu WiFi:</strong> {{ $coffeeShop->wifi_password }}</p>
                    <p class="text-gray-500"><strong>Hotline:</strong> {{ $coffeeShop->phone }}</p>
                </div>
                
                <div class="mt-4  flex space-x-2" id="bt">
                    <!-- Button mở Modal menu -->
                        <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#menuModal">
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
                                                                    data-menu-id="{{ $menu->id }}" alt="Menu Image" style="width: 100%; max-height:600px ;">
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <p class="text-muted">Chưa có menu nào được thêm.</p>
                                                    @endif
                                                </div>

                                                

                                            </div>
                                        </div>
                                    </div>
                                    <button class="save-btn {{ $savedShops->contains($shop->id) ? 'liked' : '' }}" data-shop-id="{{ $shop->id }}">
    <svg class="save-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
        viewBox="0 0 16 16" style="width: 20px; height: 20px; margin-right: 5px;">
        <path fill-rule="evenodd"
            d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0" />
        <path
            d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1z" />
    </svg>
    <span class="save-text">
        @if($savedShops->contains($shop->id))
            Đã Lưu
        @else
            Lưu
        @endif
    </span>
</button>
                    <!-- Nút Đánh giá -->
   
            
            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">
                         Đánh giá quán
                     </button> -->
                     @if(Auth::check())
             <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal">Viết đánh giá</button>
         @else
             <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="btn btn-primary">Đăng nhập để đánh giá</a>
         @endif
               
      
         
         
         <!-- Modal Đánh Giá -->
         
         
         <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
             <div class="modal-dialog">
                 <div class="modal-content">
                     <!-- Tiêu đề -->
                     <div class="modal-header">
                         <h5 class="modal-title">Đánh giá quán: {{ $coffeeShop->shop_name }}</h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                     </div>
         
                     <!-- Form Đánh Giá -->
                     <form action="{{ route('review.store') }}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <input type="hidden" name="shop_id" value="{{ $coffeeShop->id }}">
         
                         <div class="modal-body">
                             <!-- Tên quán -->
                             <p><strong>Quán:</strong> {{ $coffeeShop->shop_name }}</p>
         
                             <!-- Chọn số sao -->
                             <label class="form-label">Đánh giá sao:</label>
                             <select class="form-control" name="rating" required>
                                 <option value="5">⭐⭐⭐⭐⭐ - Xuất sắc</option>
                                 <option value="4">⭐⭐⭐⭐ - Tốt</option>
                                 <option value="3">⭐⭐⭐ - Bình thường</option>
                                 <option value="2">⭐⭐ - Tệ</option>
                                 <option value="1">⭐ - Rất tệ</option>
                             </select>
         
                             <!-- Nội dung đánh giá -->
                             <label class="form-label mt-2">Nội dung đánh giá:</label>
                             <textarea class="form-control" name="content" rows="3" placeholder="Viết cảm nhận của bạn..." required></textarea>
         
                             <!-- Ảnh đánh giá -->
                             <label class="form-label mt-2">Hình ảnh:</label>
                             <input type="file" class="form-control" name="img_url[]" accept="image/*" multiple required>
<small class="text-muted">Tối đa 4 ảnh</small>

                             @error('img_url')
             <span class="text-danger">{{ $message }}</span>
         @enderror
         
                             <!-- Ngày đánh giá (hiển thị nhưng không chỉnh sửa) -->
                             <p class="mt-2 text-muted"><i class="bi bi-calendar"></i> Ngày đánh giá: {{ now()->format('d/m/Y') }}</p>
                         </div>
         
                         <!-- Nút Gửi -->
                         <div class="modal-footer">
                             <button type="submit" class="btn btn-success">Gửi đánh giá</button>
                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                         </div>
               
         
         
                     </form>
                 </div>
             </div>
         </div>
         
         
         @if(session('openModal'))
             <script>
                 document.addEventListener("DOMContentLoaded", function() {
                     var myModal = new bootstrap.Modal(document.getElementById('reviewModal'));
                     myModal.show();
                 });
             </script>
         @endif
         
         
         
         
         
         <!-- -->
         
                          

                    <!-- ket thuc div/button -->
                </div>
                <br>
               
                <div class="flex mt-1 items-center  text-black text-base">
                ☕ <p style="font-size: 14px; color: rgba(0, 0, 0, 0.6);">
                        Cảm ơn bạn đã lựa chọn quán cà phê của chúng tôi. Chúc bạn một ngày tuyệt vời!
                    </p>

                </div>  

                
            </div>
        </div>

        <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
            <div class="mt-6">
            <h2 class="text-2xl font-bold">Mô tả</h2>

            <p class="text-gray-500">{{ $coffeeShop->description }}</p>
        </div>
        <br>
        <div style="display:flex">
            <h2 class="text-2xl font-bold">Đánh giá</h2> 
            <p class="text-gray-600 mb-4" style="margin:8px 0 0 5px">
            ({{ $coffeeShop->reviews->count() }} lượt)
            </p>
        </div>
      
        <div class="mt-1 max-h-[400px] overflow-y-auto pr-2 scroll-smooth hide-scrollbar">       
            @foreach($coffeeShop->reviews as $review)
            @php
    $userLiked = auth()->check() && $review->likedUsers->contains(auth()->id());
@endphp 
    <div class=" pt-2" x-data="{ expanded: false }" style="margin-bottom:10px">
        <div class="flex justify-between relative">
            <div class="flex items-center">
            <img src="{{ asset('storage/uploads/avatars/' . basename($review->user->avatar_url ?? 'avt.png')) }}"
     onerror="this.onerror=null; this.src='{{ asset('frontend/images/avt.png') }}';"
     width="60" height="60" alt="Avatar"
     style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; box-shadow: 0 2px 8px rgba(0,0,0,0.15); margin-right: 15px; transform: translateX(-5px);">

                <div class="ml-3" style="margin-left:30px">
                <div class="f justify-between items-start" >
                    <p class="mb-1" style="font-size: 14px;">
                        <strong>{{ $review->user->full_name ?? 'Người dùng ẩn danh' }}</strong>
                        <span class="text-muted"> đang ở tại </span>
                        <strong>{{ $review->shop->shop_name ?? 'Quán ẩn danh' }}</strong>
                    </p>   
                    
                    <div style="display:flex;">
                        <p class="text-sm text-gray-500">{{ $review->created_at->format('d/m/Y') }}</p>
                        <span style="margin: -3px 0px 0 10px" class="like-count ">{{ $review->likes_count }}  </span>  <span style="margin-top:-3px; margin-left:2px"> lượt thích</span>   <!-- Hiển thị số sao -->

                            <p class="text-warning" style="margin-left:25px; margin-top:-3px">    
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star" style="font-size: 0.75rem;margin-right: 3px;"></i>
                            @endfor
                        </p>
                    </div>

                 <button class="like-button" 
                        data-id="{{ $review->id }}" 
                        style="border: none; background: none; cursor: pointer; position: absolute; top: 35px; right: 15px; font-size: 0.6rem;">
                    <i class="fa{{ $userLiked ? 's' : 'r' }} fa-heart text-{{ $userLiked ? 'danger' : 'dark' }}" style="font-size: 1.0rem;"></i>
                </button>

                   
                </div>
             

                    <!-- Nội dung đánh giá -->
                <div class="text-gray-700 text-sm relative font-semibold transition-all duration-300 ease-in-out">
                    <p
                        x-show="!expanded"
                        class="line-clamp-2 max-w-xs break-words"
                        style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; 
                         font-family: 'Nunito', sans-serif;font-weight: 500;font-size: 0.9rem; color: #111;"
                    >
                        {{ $review->content }}
                    </p>
                    <p
                        x-show="expanded"
                        x-cloak
                        class="max-w-xs break-words" style="font-family: 'Poppins', sans-serif;font-weight: 500; font-size: 0.9rem;"
                    >
                        {{ $review->content }}
                    </p>
                </div>
                </div>
            </div>
            <div>
            <!-- <p class="text-sm font-normal text-gray-500">Đã thích ({{ $review->likes_count ?? 0 }})</p> -->
            
                <button @click="expanded = !expanded" class="text-blue-500 text-sm hover:underline">
                    <span x-text="expanded ? 'Ẩn bớt' : 'Xem thêm'"></span>
                </button>
            </div>
        </div>
        <!-- Hình ảnh (ẩn khi chưa mở) -->
        

        <div x-show="expanded" x-cloak class="mt-2 flex flex-wrap gap-4">
            @php
                    $images = $review->img_url ? explode(',', $review->img_url) : [];
                @endphp

                @if (!empty($images))
                <div class="col flex gap-3 mt-2">
                        @foreach (array_slice($images, 0, 3) as $img)
                            @php
                                $img = trim($img);
                                if ($img === '') continue;
                                $isUrl = Str::startsWith($img, ['http://', 'https://']);
                            @endphp

                            
                            <div class="flex-none">
                <img
                    src="{{ $isUrl ? $img : asset('storage/' . $img) }}"
                    alt="Ảnh đánh giá"
                    class="w-[190px] h-[360px] object-cover rounded"
                    onerror="this.src='{{ asset('frontend/images/tt.svg') }}';"
                >
            </div>
                        @endforeach
                        
                    </div>
                @endif
            </div>
        </div>
@endforeach
           
        </div>
            <div class="mt-4">
                <div class="slogan" style="">
                    Giọt cà phê rơi, lòng người bỗng nhẹ, ước mơ nảy nở bay xa.
                </div>
            </div>
        </div>


            
            <div class="col-md-6">
            <div class="mt-6">
            <h2 class="text-2xl font-bold">Vị trí</h2>
            @if ($latitude && $longitude)
        <!-- Sử dụng iframe của Google Maps với latitude và longitude từ database -->
        <iframe
            width="650"
            height="530"
            style="border:0; border-radius:30px;"
            loading="lazy"
            allowfullscreen
            referrerpolicy="no-referrer-when-downgrade"
            src="https://www.google.com/maps?q={{ $latitude }},{{ $longitude }}&hl=vi&z=15&output=embed">
        </iframe>
    @else
        <p class="text-red-500">Chưa có địa chỉ để hiển thị bản đồ.</p>
    @endif
        </div>
        <div class="mt-6">
            <img alt="" class="rounded-lg" style="height:100px;width:400px; margin-left:60px"  src="{{ asset('frontend/images/quangcao.jpg' ) }}" />
        </div>
            </div>
        </div>
    </div>

       
    </div>

@endsection
@if(session('jsAlert'))
    <script>
        alert('{{ session('jsAlert') }}');
    </script>
@endif
<script src="//unpkg.com/alpinejs" defer></script>
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
