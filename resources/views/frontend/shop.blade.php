@extends('frontend.layout')

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
</style>
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com"></script>


    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg ">
        <div class="flex flex-col md:flex-row">
            <div class="md:w-1/2">
                <img alt="Front view of Ngày Bình Yên Cà Phê" class="rounded-lg mb-4" max-height="400" src="https://placehold.co/600x400" min-width="600"/>
                <div class="grid grid-cols-3 gap-2">
                    <img alt="Food item 1" class="rounded-lg" height="150" src="https://placehold.co/150x150" width="170"/>
                    <img alt="Food item 2" class="rounded-lg" height="150" src="https://placehold.co/150x150" width="170"/>
                    <img alt="Food item 3" class="rounded-lg" height="150" src="https://placehold.co/150x150" width="170"/>
                </div>
               
            </div>
            <div class="md:w-1/2 md:pl-6">
                <h1 class="text-4xl font-bold">{{ $coffeeShop->shop_name }}</h1>
                <div class="flex items-center mt-2">
                    <div class="flex text-yellow-500">
                    @for ($i = 1; $i <= 5; $i++)
                                    <i class="fa{{ $i <= $coffeeShop->rating ? 's' : 'r' }} fa-star"></i>
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
                             <p class="text-gray-500">Price: {{ $coffeeShop->min_price }} - {{ $coffeeShop->max_price }}</</p>
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
        <div class="mt-6">
            <h2 class="text-2xl font-bold">Đánh giá</h2>
            <div class="mt-2">
                <div class="flex items-center">
                    <img alt="Reviewer 1" class="rounded-full" height="40" src="https://placehold.co/40x40" width="40"/>
                    <div class="ml-5">
                        <p class="font-semibold">Hoàng Long</p>
                        <p class="text-gray-500">Quán có đồ ăn nhẹ rất ngon</p>
                    </div>
                </div>
                <div class="flex items-center mt-3">
                    <img alt="Reviewer 2" class="rounded-full" height="40" src="https://placehold.co/40x40" width="40"/>
                    <div class="ml-5">
                        <p class="font-semibold">Tuyết</p>
                        <p class="text-gray-500">Không gian yên tĩnh, nước ngon và nhân viên phục vụ nhiệt tình!</p>
                    </div>
                </div>
                <div class="flex items-center mt-3">
                    <img alt="Reviewer 2" class="rounded-full" height="40" src="https://placehold.co/40x40" width="40"/>
                    <div class="ml-5">
                        <p class="font-semibold">Tuyết</p>
                        <p class="text-gray-500">Không gian yên tĩnh, nước ngon và nhân viên phục vụ nhiệt tình!</p>
                    </div>
                </div>
                <div class="flex items-center mt-3">
                    <img alt="Reviewer 2" class="rounded-full" height="40" src="https://placehold.co/40x40" width="40"/>
                    <div class="ml-5">
                        <p class="font-semibold">Tuyết</p>
                        <p class="text-gray-500">Không gian yên tĩnh, nước ngon và nhân viên phục vụ nhiệt tình!</p>
                    </div>
                </div>
                <div class="flex items-center mt-3">
                    <img alt="Reviewer 2" class="rounded-full" height="40" src="https://placehold.co/40x40" width="40"/>
                    <div class="ml-5">
                        <p class="font-semibold">Tuyết</p>
                        <p class="text-gray-500">Không gian yên tĩnh, nước ngon và nhân viên phục vụ nhiệt tình!</p>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <input class="w-full p-2 border  rounded-lg" placeholder="Thêm nhận xét của bạn" type="text"/>
            </div>
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
