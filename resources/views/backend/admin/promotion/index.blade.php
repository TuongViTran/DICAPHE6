@extends('backend.admin.layout')


@section('title', 'Quản lý khuyến mãi')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Danh sách khuyến mãi</h1>
    
    <a class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">
        + Thêm khuyến mãi mới
    </a>
    
    <div class="bg-white p-4 rounded-lg shadow-md mt-4">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-gray-200 text-gray-800">
                    <th class="py-2 px-6 text-sm">Tiêu đề</th>
                    <th class="py-2 px-6 text-sm">Mô tả</th>
                    <th class="py-2 px-6 text-sm">Giảm giá (%)</th>
                    <th class="py-2 px-6 text-sm">Giảm giá (VNĐ)</th>
                    <th class="py-2 px-6 text-sm">Ngày bắt đầu</th>
                    <th class="py-2 px-6 text-sm">Ngày kết thúc</th>
                    <th class="py-2 px-2 text-sm">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($promotions as $promotion)
                <tr class="hover:bg-gray-50 transition duration-200 ease-in-out">
                    <td class="py-2 px-6 text-sm text-center">{{ $promotion->title }}</td>
                    <td class="py-2 px-6 text-sm text-center">{{ $promotion->description }}</td>
                    <td class="py-2 px-6 text-sm text-center">{{ $promotion->discount_percent }}</td>
                    <td class="py-2 px-6 text-sm text-center">{{ $promotion->discount_amount }}</td>
                    <td class="py-2 px-6 text-sm text-center">{{ $promotion->start_date }}</td>
                    <td class="py-2 px-6 text-sm text-center">{{ $promotion->end_date }}</td>
                    <td class="py-2 px-2 text-sm text-center">
                        <div class="flex justify-center items-center space-x-2">
                            <a class="text-gray-500 hover:text-gray-700" href="{{ route('promotions.edit', $promotion->id) }}">
                                <i class="fas fa-edit w-4 h-4"></i>
                            </a>
                            <form action="{{ route('promotions.destroy', $promotion->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-gray-500 hover:text-gray-700" type="submit">
                                    <i class="fas fa-trash w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach

                <!-- Nội dung giả định cho quán cà phê -->
                <tr class="hover:bg-gray-50 transition duration-200 ease-in-out">
                    <td class="py-2 px-6 text-sm text-center">Giảm giá cà phê sáng</td>
                    <td class="py-2 px-6 text-sm text-center">Giảm giá 30% cho tất cả các loại cà phê từ 7h đến 9h sáng</td>
                    <td class="py-2 px-6 text-sm text-center">30</td>
                    <td class="py-2 px-6 text-sm text-center">10000</td>
                    <td class="py-2 px-6 text-sm text-center">01/09/2023</td>
                    <td class="py-2 px-6 text-sm text-center">30/09/2023</td>
                    <td class="py-2 px-2 text-sm text-center">
                        <div class="flex justify-center items-center space-x-2">
                            <a class="text-gray-500 hover:text-gray-700" href="#">
                                <i class="fas fa-edit w-4 h-4"></i>
                            </a>
                            <form action="#" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-gray-500 hover:text-gray-700" type="submit">
                                    <i class="fas fa-trash w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition duration-200 ease-in-out">
                    <td class="py-2 px-6 text-sm text-center">Khuyến mãi sinh tố</td>
                    <td class="py-2 px-6 text-sm text-center">Mua 1 tặng 1 cho tất cả các loại sinh tố vào thứ 7 hàng tuần</td>
                    <td class="py-2 px-6 text-sm text-center">50</td>
                    <td class="py-2 px-6 text-sm text-center">20000</td>
                    <td class="py-2 px-6 text-sm text-center">01/10/2023</td>
                    <td class="py-2 px-6 text-sm text-center">31/10/2023</td>
                    <td class="py-2 px-2 text-sm text-center">
                        <div class="flex justify-center items-center space-x-2">
                            <a class="text-gray-500 hover:text-gray-700" href="#">
                                <i class="fas fa-edit w-4 h-4"></i>
                            </a>
                            <form action="#" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-gray-500 hover:text-gray-700" type="submit">
                                    <i class="fas fa-trash w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition duration-200 ease-in-out">
                    <td class="py-2 px-6 text-sm text-center">Khuyến mãi trà sữa</td>
                    <td class="py-2 px-6 text-sm text-center">Giảm giá 15% cho tất cả các loại trà sữa vào ngày chủ nhật</td>
                    <td class="py-2 px-6 text-sm text-center">15</td>
                    <td class="py-2 px-6 text-sm text-center">5000</td>
                    <td class="py-2 px-6 text-sm text-center">01/11/2023</td>
                    <td class="py-2 px-6 text-sm text-center">30/11/2023</td>
                    <td class="py-2 px-2 text-sm text-center">
                        <div class="flex justify-center items-center space-x-2">
                            <a class="text-gray-500 hover:text-gray-700" href="#">
                                <i class="fas fa-edit w-4 h-4"></i>
                            </a>
                            <form action="#" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-gray-500 hover:text-gray-700" type="submit">
                                    <i class="fas fa-trash w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection