@extends('frontend.layout')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
<script src="https://cdn.tailwindcss.com"></script>


    <div class="max-w-7xl mx-auto bg-white p-6 rounded-lg ">
        <div class="flex flex-col md:flex-row">
            <div class="md:w-1/2">
                <img alt="Front view of Ngày Bình Yên Cà Phê" class="rounded-lg mb-4" height="400" src="https://placehold.co/600x400" width="600"/>
                <div class="grid grid-cols-3 gap-2">
                    <img alt="Food item 1" class="rounded-lg" height="150" src="https://placehold.co/150x150" width="150"/>
                    <img alt="Food item 2" class="rounded-lg" height="150" src="https://placehold.co/150x150" width="150"/>
                    <img alt="Food item 3" class="rounded-lg" height="150" src="https://placehold.co/150x150" width="150"/>
                </div>
                <div class="text-gray-500 text-sm mt-2">
                    3.3k likes
                </div>
            </div>
            <div class="md:w-1/2 md:pl-6">
                <h1 class="text-4xl font-bold">Ngày Bình Yên Cà Phê</h1>
                <div class="flex items-center mt-2">
                    <div class="flex text-yellow-500">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="ml-2 text-gray-500">3.5</span>
                </div>
                <div class="mt-2">
                    <p class="text-gray-500">Open daily: 7:00 - 22:00</p>
                    <p class="text-gray-500">Price: 35k - 65k</p>
                    <p class="text-gray-500">Address: 75 Bùi Thị Xuân</p>
                </div>
                <div class="mt-4">
                    <h2 class="text-3xl font-semibold">Thông tin</h2>
                    <p class="text-gray-500">@Ngaybinhyen_Giaolộ8</p>
                    <p class="text-gray-500">Đặt xe: Trước cửa quán - Miễn phí</p>
                    <p class="text-gray-500">Mã khuyến mãi: ngaybinhyen</p>
                    <p class="text-gray-500">Hotline: 0902002493</p>
                </div>
                <div class="mt-4 flex space-x-2">
                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg">Đi thôi</button>
                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Chia sẻ</button>
                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Lưu nè</button>
                    <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Đánh giá</button>
                </div>
            </div>
        </div>

        <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
            <div class="mt-6">
            <h2 class="text-2xl font-bold">Mô tả</h2>

            <p class="text-gray-500">Quán đượcc đóng góp nên bọn mình chưa có thử qua. Các bạn đi cho tụi mình xin ý kiến ở comment nhé !</p>
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
                <input class="w-full p-2 border rounded-lg" placeholder="Thêm nhận xét của bạn" type="text"/>
            </div>
        </div>
            </div>
            <div class="col-md-6">
            <div class="mt-6">
            <h2 class="text-lg font-semibold">Vị trí</h2>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3834.2547299694816!2d108.16610517459974!3d16.052265939892848!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3142196d9a203685%3A0x4e8027fe58d65525!2zQ2FvIMSR4bqzbmcgRlBUIEPGoSBT4bufIDI!5e0!3m2!1svi!2s!4v1744278102972!5m2!1svi!2s" width="600" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="mt-6">
            <img alt="" class="rounded-lg" style="height:100px;width:400px; margin-left:60px"  src="{{ asset('frontend/images/quangcao.jpg' ) }}" />
        </div>
            </div>
        </div>
    </div>

       
    </div>

@endsection
