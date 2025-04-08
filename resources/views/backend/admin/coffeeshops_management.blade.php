<!-- resources/views/coffee_management.blade.php -->
@extends('backend.admin.layout')

@section('title', 'Quản lý quán cà phê ')

@section('header', 'Quản lý quán cà phê')


@section('content') <!-- Bắt đầu phần nội dung -->
    <div class="container mx-auto p-4">
     
        </header>
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <a class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-200" href="#">
                    + THÊM MỚI
                </a>
            </div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow-md">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gray-200 text-gray-800">
                        <th class="py-2 px-6 text-sm">STT</th>
                        <th class="py-2 px-6 text-sm">Tiêu đề</th>
                        <th class="py-2 px-6 text-sm">Mô tả</th>
                        <th class="py-2 px-6 text-sm">Ảnh bìa</th>
                        <th class="py-2 px-6 text-sm">Ngày đăng</th>
                        <th class="py-2 px-6 text-sm">Số lượng thích</th>
                        <th class="py-2 px-6 text-sm">Trạng thái</th>
                        <th class="py-2 px-2 text-sm">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr class="hover:bg-gray-50 transition duration-200 ease-in-out">
                        <td class="py-2 px-6 text-sm text-center">1</td>
                        <td class="py-2 px-6 text-sm text-center">Quán Cà Phê Trình</td>
                        <td class="py-2 px-6 text-sm text-center">Quán cà phê nổi tiếng với không gian thoáng đãng.</td>
                        <td class="py-2 px-6 text-sm text-center">
                            <img alt="Ảnh bìa của Quán Cà Phê A" class="w-20 h-20 object-cover rounded-full" height="80" src="https://danangfantasticity.com/wp-content/uploads/2023/04/trinh-ca-phe-34-4-nguyen-huu-tho-001.jpg" width="80"/>
                        </td>
                        <td class="py-2 px-6 text-sm text-center">01/01/2025</td>
                        <td class="py-2 px-6 text-sm text-center">234</td>
                        <td class="py-2 px-6 text-sm text-center">
                            <span class="bg-green-100 text-green-700 py-1 px-2 rounded-full text-xs whitespace-nowrap">Đã duyệt</span>
                        </td>
                        <td class="py-2 px-2 text-sm text-center">
                            <div class="flex justify-center items-center space-x-2">
                                <a class="text-gray-400 flex items-center" href="#">
                                    <i class="fas fa-edit w-4 h-4"></i>
                                </a>
                                <button class="text-gray-400 flex items-center" type="submit">
                                    <i class="fas fa-trash w-4 h-4"></i>
                                </button>
                                <a class="text-gray-400 flex items-center" href="#">
                                    <i class="fas fa-eye w-4 h-4"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition duration-200 ease-in-out">
                        <td class="py-2 px-6 text-sm text-center">2</td>
                        <td class="py-2 px-6 text-sm text-center">Quán Cà Phê Miên </td>
                        <td class="py-2 px-6 text-sm text-center">Nơi lý tưởng để thư giãn và làm việc.</td>
                        <td class="py-2 px-6 text-sm text-center">
                            <img alt="Ảnh bìa của Quán Cà Phê B" class="w-20 h-20 object-cover rounded-full" height="80" src="https://toidicafe.vn/static/images/place/hiencaphe/hiencaphe-avatar-1648201759024.jpg" width="80"/>
                        </td>
                        <td class="py-2 px-6 text-sm text-center">02/01/2025</td>
                        <td class="py-2 px-6 text-sm text-center">200</td>
                        <td class="py-2 px-6 text-sm text-center">
                            <span class="bg-yellow-100 text-yellow-700 py-1 px-2 rounded-full text-xs whitespace-nowrap">Chờ duyệt</span>
                        </td>
                        <td class="py-2 px-2 text-sm text-center">
                            <div class="flex justify-center items-center space-x-2">
                                <a class="text-gray-400 flex items-center" href="#">
                                    <i class="fas fa-edit w-4 h-4"></i>
                                </a>
                                <button class="text-gray-400 flex items-center" type="submit">
                                    <i class="fas fa-trash w-4 h-4"></i>
                                </button>
                                <a class="text-gray-400 flex items-center" href="#">
                                    <i class="fas fa-eye w-4 h-4"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition duration-200 ease-in-out">
                        <td class="py-2 px-6 text-sm text-center">3</td>
                        <td class="py-2 px-6 text-sm text-center">Quán Cà Phê Nóc </td>
                        <td class="py-2 px-6 text-sm text-center">Quán cà phê với phong cách vintage.</td>
                        <td class="py-2 px-6 text-sm text-center">
                            <img alt="Ảnh bìa của Quán Cà Phê C" class="w-20 h-20 object-cover rounded-full" height="80" src="https://danalocal.info/wp-content/uploads/2023/08/lap-keo-san-may-bay-tai-quan-ca-phe-rooftop-chill-het-nac-9.jpg" width="80"/>
                        </td>
                        <td class="py-2 px-6 text-sm text-center">03/01/2025</td>
                        <td class="py-2 px-6 text-sm text-center">150</td>
                        <td class="py-2 px-6 text-sm text-center">
                            <span class="bg-red-100 text-red-700 py-1 px-2 rounded-full text-xs whitespace-nowrap">Chưa duyệt</span>
                        </td>
                        <td class="py-2 px-2 text-sm text-center">
                            <div class="flex justify-center items-center space-x-2">
                                <a class="text-gray-400 flex items-center" href="#">
                                    <i class="fas fa-edit w-4 h-4"></i>
                                </a>
                                <button class="text-gray-400 flex items-center" type="submit">
                                    <i class="fas fa-trash w-4 h-4"></i>
                                </button>
                                <a class="text-gray-400 flex items-center" href="#">
                                    <i class="fas fa-eye w-4 h-4"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition duration-200 ease-in-out">
                        <td class="py-2 px-6 text-sm text-center">4</td>
                        <td class="py-2 px-6 text-sm text-center">Quán Cà Phê Dena </td>
                        <td class="py-2 px-6 text-sm text-center">Quán cà phê với không gian yên tĩnh.</td>
                        <td class="py-2 px-6 text-sm text-center">
                            <img alt="Ảnh bìa của Quán Cà Phê D" class="w-20 h-20 object-cover rounded-full" height="80" src="https://stcd02265632633.cloud.edgevnpay.vn/website-vnpay-public/fill/2023/11/0lb4oxu3sw8n1698946447580.jpg" width="80"/>
                        </td>
                        <td class="py-2 px-6 text-sm text-center">04/01/2025</td>
                        <td class="py-2 px-6 text-sm text-center">300</td>
                        <td class="py-2 px-6 text-sm text-center">
                            <span class="bg-green-100 text-green-700 py-1 px-2 rounded-full text-xs whitespace-nowrap">Đã duyệt</span>
                        </td>
                        <td class="py-2 px-2 text-sm text-center">
                            <div class="flex justify-center items-center space-x-2">
                                <a class="text-gray-400 flex items-center" href="#">
                                    <i class="fas fa-edit w-4 h-4"></i>
                                </a>
                                <button class="text-gray-400 flex items-center" type="submit">
                                    <i class="fas fa-trash w-4 h-4"></i>
                                </button>
                                <a class="text-gray-400 flex items-center" href="#">
                                    <i class="fas fa-eye w-4 h-4"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition duration-200 ease-in-out">
                        <td class="py-2 px-6 text-sm text-center">5</td>
                        <td class="py-2 px-6 text-sm text-center">Quán Cà Phê Bông </td>
                        <td class="py-2 px-6 text-sm text-center">Quán cà phê với menu đa dạng.</td>
                        <td class="py-2 px-6 text-sm text-center">
                            <img alt="Ảnh bìa của Quán Cà Phê E" class="w-20 h-20 object-cover rounded-full" height="80" src="https://cdn.khamphadanang.vn/wp-content/uploads/2024/11/bong-food-drink-2.jpg?strip=all&lossy=1&ssl=1" width="80"/>
                        </td>
                        <td class="py-2 px-6 text-sm text-center">05/01/2025</td>
                        <td class="py-2 px-6 text-sm text-center">120</td>
                        <td class="py-2 px-6 text-sm text-center">
                            <span class="bg-yellow-100 text-yellow-700 py-1 px-2 rounded-full text-xs whitespace-nowrap">Chờ duyệt</span>
                        </td>
                        <td class="py-2 px-2 text-sm text-center">
                            <div class="flex justify-center items-center space-x-2">
                                <a class="text-gray-400 flex items-center" href="#">
                                    <i class="fas fa-edit w-4 h-4"></i>
                                </a>
                                <button class="text-gray-400 flex items-center" type="submit">
                                    <i class="fas fa-trash w-4 h-4"></i>
                                </button>
                                <a class="text-gray-400 flex items-center" href="#">
                                    <i class="fas fa-eye w-4 h-4"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition duration-200 ease-in-out">
                        <td class="py-2 px-6 text-sm text-center">6</td>
                        <td class="py-2 px-6 text-sm text-center">Quán Cà Phê Ô cửa sổ </td>
                        <td class="py-2 px-6 text-sm text-center">Quán cà phê với không gian nghệ thuật.</td>
                        <td class="py-2 px-6 text-sm text-center">
                            <img alt="Ảnh bìa của Quán Cà Phê F" class="w-20 h-20 object-cover rounded-full" height="80" src="https://danalocal.info/wp-content/uploads/2022/08/luu-ban-nhap-tu-dong-4-1.jpg" width="80"/>
                        </td>
                        <td class="py-2 px-6 text-sm text-center">06/01/2025</td>
                        <td class="py-2 px-6 text-sm text-center">180</td>
                        <td class="py-2 px-6 text-sm text-center">
                            <span class="bg-green-100 text-green-700 py-1 px-2 rounded-full text-xs whitespace-nowrap">Đã duyệt</span>
                        </td>
                        <td class="py-2 px-2 text-sm text-center">
                            <div class="flex justify-center items-center space-x-2">
                                <a class="text-gray-400 flex items-center" href="#">
                                    <i class="fas fa-edit w-4 h-4"></i>
                                </a>
                                <button class="text-gray-400 flex items-center" type="submit">
                                    <i class="fas fa-trash w-4 h-4"></i>
                                </button>
                                <a class="text-gray-400 flex items-center" href="#">
                                    <i class="fas fa-eye w-4 h-4"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection