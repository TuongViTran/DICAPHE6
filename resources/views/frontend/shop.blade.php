@extends('frontend.layout')
@section('title', 'Shop')
<style>
    #tt1 {
        display:flex;
    }
   
    #tt1 div p{
        font-size:large;
        
    }
    .flex i{
        font-size:x-large;
        margin:5px
    }
    .tt2 div{
        display:flex
    }
    .tt2 div svg{
        margin: 5px 15px 0 10px
    }
    #tt3{
        font-size:large;
    }
    #tt3 p{
        margin: 10px 0 5px 25px;
    }
    #bt button{
        border: solid 1px;
    }
    .rounded-lg img{
        max-height:150px;
    }
    .hide-scrollbar {
        scrollbar-width: none; /* Firefox */
        -ms-overflow-style: none; /* Internet Explorer 10+ */
    }
    .hide-scrollbar::-webkit-scrollbar {
        display: none; /* Chrome, Safari and Opera */
    }
</style>

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com"></script>


    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg ">
        <div class="flex flex-col md:flex-row">
            <div class="md:w-1/2">
                <img alt="Front view of Ngày Bình Yên Cà Phê" class="rounded-lg mb-4" style="max-height: 400px; min-width: 600px;" src="{{ asset('frontend/images/' . $coffeeShop->cover_image) }}  " />
                <div class="grid grid-cols-3 gap-2">
                    <img alt="Food item 1" class="rounded-lg"  src="{{ asset('frontend/images/' . $coffeeShop->image_1) }}" width="170"/>
                    <img alt="Food item 2" class="rounded-lg"  src="{{ asset('frontend/images/' . $coffeeShop->image_2) }}" width="170"/>
                    <img alt="Food item 3" class="rounded-lg"  src="{{ asset('frontend/images/' . $coffeeShop->image_3) }}" width="170"/>
                </div>
               
            </div>
            <div class="md:w-1/2 md:pl-6">
                <h1 class="text-4xl font-bold">{{ $coffeeShop->shop_name }}</h1>
                <div class="flex items-center mt-2">
                    <div class="flex text-yellow-500">
                    @php
                        $rating = $coffeeShop->reviews_avg_rating;
                    @endphp

                    @for ($i = 1; $i <= 5; $i++)
                        @if ($rating >= $i)
                            <i class="fas fa-star" style="color: #FFC107;"></i> <!-- sao đầy -->
                        @elseif ($rating >= ($i - 0.5))
                            <i class="fas fa-star-half-alt" style="color: #FFC107;"></i> <!-- sao nửa -->
                        @else
                        <i class="far fa-star text-yellow-400"></i>  <!-- sao rỗng -->
                        @endif
                    @endfor
                  
                    </div>
                    <span class="badge bg-success">Open</span>

                </div>
                <br>
                <div class="mt-2" id="tt1">
                    <div>
                         <img src="{{ asset('frontend/images/c1.jpg') }}" style="width:80px; height:80px; border-radius:50%;margin-top:5px;margin-left:20px" class="shadow-lg"alt="">
                    </div>
                    <div class="tt2" style="margin-left:20px">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-door-open-fill" viewBox="0 0 16 16">
                            <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15zM11 2h.5a.5.5 0 0 1 .5.5V15h-1zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
                            </svg>
                            <p class="text-gray-500">Open daily: {{ $coffeeShop->opening_time }} - {{ $coffeeShop->closing_time }}</p>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-tags-fill" viewBox="0 0 16 16">
                            <path d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                            <path d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043z"/>
                            </svg>
                             <p class="text-gray-500">Price: {{ $coffeeShop->min_price }} - {{ $coffeeShop->max_price }}</p>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                            </svg>
                            <p class="text-gray-500">Address: {{ $coffeeShop->address->street}}, {{ $coffeeShop->address->district}}, {{ $coffeeShop->address->city}}</p>
                        </div>
                    </div>
                </div>
                <br>
                <div class="mt-4" id="tt3">
                    <h2 class="text-3xl font-bold">Thông tin</h2>
                    <p class="text-gray-500">IG: @Ngaybinhyen_Giaolộ8</p>
                    <p class="text-gray-500"><strong>Đậu xe:</strong> {{ $coffeeShop->parking }}</p>
                    <p class="text-gray-500"><strong>Mật khẩu WiFi:</strong> {{ $coffeeShop->wifi_password }}</p>
                    <p class="text-gray-500"><strong>Hotline:</strong> {{ $coffeeShop->phone }}</p>
                </div>
                
                <div class="mt-4  flex space-x-2" id="bt">
                    <button class="bg-yellow-900 text-white px-4 py-2 rounded-lg">Đi thôi</button>
                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Chia sẻ</button>
                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Lưu nè</button>
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
                <br>
                <div class="text-gray-500 text-sm mt-4">
                    Đã thích(3,3k)
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
    <div class=" pt-2" x-data="{ expanded: false }" style="margin-bottom:10px">
       
        <div class="flex justify-between relative">
            <div class="flex items-center">
                <img src="{{ asset('frontend/images/' . basename($review->user->avatar_url)) }}"
                  class="rounded-full object-cover shadow-md" width="60" height="60" alt="Avatar">
                <div class="ml-3" style="margin-left:30px">
                <div class="flex justify-between items-start" >
                    <p class="font-semi text-gray-500">
                        <span>{{ $review->user->full_name ?? 'Người dùng' }}</span>
                    </p>
                    
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
        
        <div  x-show="expanded" x-cloak >
              <div style="display:flex;margin-left:90px">
              <p class="text-sm text-gray-500">{{ $review->created_at->format('d/m/Y') }}</p>
                <p class="text-warning" style="margin-left:25px; margin-top:-3">    
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star" style="font-size: 0.75rem;margin-right: 3px;"></i>
                @endfor
             </p>
              </div>
        </div>

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
                <input class="w-full p-2 border  rounded-lg" placeholder="Thêm nhận xét của bạn" type="text"/>
            </div>
            </div>


            
            <div class="col-md-6">
            <div class="mt-6">
            <h2 class="text-2xl font-bold">Vị trí</h2>
            <iframe style="border-radius:30px" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3834.2547299694816!2d108.16610517459974!3d16.052265939892848!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3142196d9a203685%3A0x4e8027fe58d65525!2zQ2FvIMSR4bqzbmcgRlBUIEPGoSBT4bufIDI!5e0!3m2!1svi!2s!4v1744278102972!5m2!1svi!2s" width="600" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
