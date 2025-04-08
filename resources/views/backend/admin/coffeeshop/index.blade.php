@extends('backend.admin.layout')


@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Quản lý quán cà phê</h1>

    <form action="{{ route('coffeeShops.index') }}" method="GET" class="mb-4">
        <input type="text" name="query" value="{{ $query }}" placeholder="Tìm kiếm quán cà phê..." class="border rounded p-2">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tìm kiếm</button>
        <a href="{{ route('coffeeShops.create') }}" class="bg-green-500 text-white px-4 py-2 rounded ml-2">+ Thêm quán cà phê mới</a>
    </form>

    @if(session('success'))
        <div class="bg-green-200 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white p-4 rounded-lg shadow-md mt-4">
        <table class="min-w-full bg-white">
            <thead>
                <tr class="bg-gray-200 text-gray-800">
                    <th class="py-2 px-6 text-sm">Tên quán</th>
                    <th class="py-2 px-6 text-sm">Địa chỉ</th>
                    <th class="py-2 px-6 text-sm">Phong cách</th>
                    <th class="py-2 px-6 text-sm">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($coffeeShops as $shop)
                <tr class="hover:bg-gray-50 transition duration-200 ease-in-out">
                    <td class="py-2 px-6 text-sm text-center">{{ $shop->name }}</td>
                    <td class="py-2 px-6 text-sm text-center">{{ $shop->address }}</td>
                    <td class="py-2 px-6 text-sm text-center">{{ $shop->style }}</td>
                    <td class="py-2 px-2 text-sm text-center">
                        <div class="flex justify-center items-center space-x-2">
                            <a class="text-blue-500 hover:text-blue-700" href="{{ route('coffeeShops.edit', $shop->id) }}">
                                <i class="fas fa-edit w-4 h-4"></i>
                            </a>
                            <form action="{{ route('coffeeShops.destroy', $shop->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:text-red-700" type="submit">
                                    <i class="fas fa-trash w-4 h-4"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection