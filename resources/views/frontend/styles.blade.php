@extends('frontend.layout')
@section('title', 'Feed')
@section('content')
<section class="search-section py-5 px-4">
    <div class="container">
        <h2 class="mb-4 font-semibold text-xl">Kết quả các quán thuộc phong cách: "{{ $style->style_name }}"</h2>

        @if($coffeeshops->count() > 0)
            @foreach($coffeeshops as $shop)
                <div class="shop-card mb-4 p-4 border rounded-lg shadow-sm flex">
                    <div class="w-1/3">
                        <img src="{{ asset('storage/' . $shop->cover_image) }}" alt="{{ $shop->shop_name }}" class="w-full h-48 object-cover rounded-lg">
                    </div>
                    <div class="w-2/3 pl-6">
                        <h3 class="text-xl font-semibold mb-1">{{ $shop->shop_name }}</h3>
                        <span class="inline-block bg-green-100 text-green-800 text-sm px-2 py-1 rounded-full mb-2">
                            {{ $style->style_name }}
                        </span>
                        <div class="text-gray-600 text-sm mb-1">
                            🕒 {{ \Carbon\Carbon::parse($shop->opening_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($shop->closing_time)->format('H:i') }}
                        </div>
                        <div class="text-gray-600 text-sm mb-1">
                            💸 {{ $shop->min_price }}k - {{ $shop->max_price }}k
                        </div>
                        <div class="text-gray-600 text-sm mb-1">
                            📍 {{ $shop->address->street }}, {{ $shop->address->district }}
                        </div>
                        <div class="text-gray-600 text-sm">
                            ☕ Chủ quán: {{ $shop->user->full_name }}
                        </div>

                        <div class="mt-2">
                            @if($shop->status === 'open')
                                <span class="bg-green-200 text-green-800 px-2 py-1 text-sm rounded">Đang mở cửa</span>
                            @else
                                <span class="bg-gray-200 text-gray-800 px-2 py-1 text-sm rounded">Đã đóng cửa</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-gray-500">Hiện chưa có quán nào thuộc phong cách này.</p>
        @endif
    </div>
</section>
@endsection
