
@extends('frontend.layout')
@section('title', 'Quán theo phong cách')
@section('content')
    <div class="container_slider mt-2">
        <h2 class="text-2xl font-semibold mb-4">Các quán thuộc phong cách: "{{ $style->style_name }}"</h2>

        <div class="row">
            {{-- Cột trái: Danh sách quán --}}
            <div class="col-lg-8">
                @if($coffeeshops->isEmpty())
                    <div class="alert alert-warning text-center">
                        <h5>😔 Xin lỗi!</h5>
                        <p>Hiện chưa có quán nào thuộc phong cách này.</p>
                    </div>
                @else
                    @foreach ($coffeeshops as $shop)
                    <a href="{{ route('frontend.shop', ['id' => $shop->id]) }}" class="text-decoration-none text-dark">
                        <div class="card mb-4 shadow-sm">
                            <div class="row g-0">
                                {{-- Hình ảnh --}}
                                <div class="col-md-4">
                                    <div class="position-relative" style="aspect-ratio: 1 / 1; overflow: hidden;">
                                        <img src="{{ asset('frontend/images/' . $shop->cover_image) }}"
                                            class="img-fluid object-fit-cover w-100 h-100"
                                            alt="{{ $shop->shop_name }}">
                                    </div>
                                </div>

                                {{-- Nội dung --}}
                                <div class="col-md-8">
                                    <div class="card-body h-100 d-flex flex-column justify-content-between">
                                        <div>
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h3 class="card-title mb-0 fw-bold h5">{{ $shop->shop_name }}</h3>

                                                <div class="d-flex align-items-center gap-2">
                                                    {{-- Màu sắc theo style --}}
                                                    @php
                                                        $styleId = $shop->styles_id;
                                                        $bgColor = '#DFFEF2';
                                                        $textColor = '#00B140';

                                                        switch ($styleId) {
                                                            case 1: $bgColor = '#EBF6F4'; $textColor = '#0F4C3A'; break; // Truyền thống
                                                            case 2: $bgColor = '#F1E8F8'; $textColor = '#5F276D'; break; // Hiện đại
                                                            case 3: $bgColor = '#FBF5E6'; $textColor = '#6F4E28'; break; // Công sở
                                                            case 4: $bgColor = '#F7E7E7'; $textColor = '#76333C'; break; // Nhà máy
                                                        }
                                                    @endphp

                                                    <span class="badge" style="background-color: {{ $bgColor }}; color: {{ $textColor }}; font-size: 1rem; font-weight: 500; padding: 6px 16px; border-radius: 999px;">
                                                        {{ $style->style_name }}
                                                    </span>

                                                    <span class="badge bg-{{ $shop->status === 'open' ? 'success' : 'secondary' }}">
                                                        {{ $shop->status === 'open' ? 'Đang mở cửa' : 'Đã đóng cửa' }}
                                                    </span>
                                                </div>
                                            </div>

                                            {{-- Đánh giá --}}
                                            @php $rating = $shop->reviews_avg_rating ?? 0; @endphp
                                            <div class="mb-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="{{ $i <= round($rating) ? 'fas' : 'far' }} fa-star text-warning"></i>
                                                @endfor
                                                <small class="text-muted">
                                                    {{ $rating > 0 ? '(' . number_format($rating, 1) . ')' : 'Chưa có đánh giá' }}
                                                </small>
                                            </div>

                                            {{-- Thông tin --}}
                                            <ul class="list-unstyled text-muted mb-0 small">
                                                <li class="mb-1">
                                                    <i class="fas fa-clock me-1"></i> 
                                                    {{ \Carbon\Carbon::parse($shop->opening_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($shop->closing_time)->format('H:i') }}
                                                </li>
                                                <li class="mb-1">
                                                    <i class="fas fa-tags me-1"></i>
                                                    {{ number_format($shop->min_price, 0) }}k - {{ number_format($shop->max_price, 0) }}k
                                                </li>
                                                <li>
                                                    <i class="fas fa-map-marker-alt me-1"></i>
                                                    {{ $shop->address->street ?? 'Chưa cập nhật địa chỉ' }}
                                                </li>
                                            </ul>
                                        </div>

                                        {{-- Avatar chủ quán --}}
                                        <div class="d-flex align-items-center mt-3">
                                            @php
                                                $avatar = $shop->user->avatar_url ?? 'avt.png';
                                                $fullName = $shop->user->full_name ?? 'Chủ quán';
                                            @endphp
                                            <img src="{{ asset('frontend/images/' . basename($shop->user->avatar_url)) }}"
                                                class="rounded-circle me-2"
                                                width="50" height="50" alt="Chủ quán">
                                            <span class="text-muted small">{{ $fullName }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a> 
                    @endforeach
                @endif
            </div>

            {{-- Cột phải: hình ảnh minh họa --}}
            <div class="col-lg-4 d-none d-lg-block">
                <div class="mb-4">
                    <img src="{{ asset('frontend/images/Minhhoa Search.png') }}" class="img-fluid rounded shadow" alt="Minh họa">
                </div>
                <div>
                    <img src="{{ asset('frontend/images/hihi.png') }}" class="img-fluid rounded shadow" alt="Banner quảng cáo">
                </div>
            </div>
        </div>
    </div>
@endsection

