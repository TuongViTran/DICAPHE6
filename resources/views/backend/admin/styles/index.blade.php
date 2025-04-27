@extends('backend.admin.layout')

@section('header', 'Quản lý phong cách')

@section('content')

<br>

<div class="flex flex-wrap justify-between items-center mb-6 gap-4">
    <!-- Cột bên trái: Thêm mới -->
    <a href="{{ route('styles.create') }}" class="inline-block bg-blue-500 text-white font-semibold rounded-lg px-6 py-3 shadow-md hover:bg-blue-600 transition duration-300">
        + Thêm mới phong cách
    </a>

    <!-- Cột bên phải: Form tìm kiếm + filter -->
    <form action="{{ route('styles.index') }}" method="GET" class="flex flex-wrap items-center gap-3 bg-white p-4 border border-gray-300 rounded-lg shadow-sm">
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}"
            placeholder="Tìm kiếm phong cách..." 
            class="flex-grow px-4 py-3 border border-gray-300 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400"
        />

        <select name="filter" class="px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">-- Sắp xếp --</option>
            <option value="asc" {{ request('filter') == 'asc' ? 'selected' : '' }}>Ít quán nhất</option>
            <option value="desc" {{ request('filter') == 'desc' ? 'selected' : '' }}>Nhiều quán nhất</option>
        </select>

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg transition duration-300">
            Tìm kiếm
        </button>
    </form>
</div>

<!-- Bảng phong cách -->
<div class="overflow-x-auto bg-white rounded-lg shadow-lg">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-200 text-gray-800">
            <tr>
                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">STT</th>
                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Tên phong cách</th>
                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Mô tả ngắn</th>
                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Số lượng quán</th>
                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">Hành động</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse ($styles as $k => $style)
                <tr class="hover:bg-gray-100 transition-all duration-200 ease-in-out">
                    <td class="px-6 py-4 text-center text-sm text-gray-600">{{ $k + 1 }}</td>

                    <!-- Tên -->
                    <td class="px-6 py-4 text-center font-semibold text-gray-800">
                        {{ $style->style_name }}
                    </td>

                    <!-- Mô tả -->
                    <td class="px-6 py-4 text-gray-600">
                        {{ \Illuminate\Support\Str::limit($style->description, 50) }}
                    </td>

                    <!-- Số lượng quán -->
                    <td class="px-6 py-4 text-center">
                        @if ($style->coffeeshops_count == 0)
                            <span class="text-red-500 font-bold">Chưa có quán</span>
                        @else
                            {{ $style->coffeeshops_count }}
                        @endif
                    </td>

                    <!-- Hành động -->
                    <td class="px-6 py-4">
                        <div class="flex justify-center items-center gap-3">
                            <!-- Sửa -->
                            <a href="{{ route('styles.edit', $style->id) }}" class="p-2 bg-white rounded-full hover:bg-gray-100 transition" title="Sửa">
                                <img src="{{ asset('backend/img/Icon (admin)/Sửa.svg') }}" alt="Sửa" class="w-6 h-6">
                            </a>

                            <!-- Xóa -->
                            <form action="{{ route('styles.destroy', $style->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa phong cách này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-white rounded-full hover:bg-gray-100 transition" title="Xóa">
                                    <img src="{{ asset('backend/img/Icon (admin)/Xóa.svg') }}" alt="Xóa" class="w-6 h-6">
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Không tìm thấy phong cách nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
