@extends('frontend.layout')
@section('title', 'Kết quả tìm kiếm')
@section('content')
    <div class="container_slider mt-2">
        @php
            $summary = [];

            // Từ khoá
            if(request('keyword')) {
                $summary[] = 'từ khóa "' . request('keyword') . '"';
            }

            // Style
            if(request()->has('style')) {
                $selectedStyleNames = $styles->whereIn('id', request('style'))->pluck('style_name')->toArray();
                if (!empty($selectedStyleNames)) {
                    $summary[] = 'style ' . implode(', ', $selectedStyleNames);
                }
            }

            // Khoảng giá
            if(request()->has('price_range')) {
                $prices = [];
                foreach (request('price_range') as $price) {
                    if ($price == 'lt50') $prices[] = '< 50k';
                    if ($price == '50_70') $prices[] = '50k - 70k';
                    if ($price == 'gt70') $prices[] = '> 70k';
                }
                if (!empty($prices)) {
                    $summary[] = 'giá ' . implode(', ', $prices);
                }
            }

            // Khoảng cách
            if(request()->has('distance')) {
                $summary[] = 'quán trong ' . implode(', ', request('distance')) . 'km';
            }

            $resultText = count($summary) > 0
                ? 'Kết quả tìm kiếm theo ' . implode('; ', $summary)
                : 'Kết quả tìm kiếm';
        @endphp

        <h2 class="text-2xl font-semibold mb-4">{{ $resultText }}</h2>


        <div class="row">
            {{-- Cột bên trái: Danh sách quán --}}
            <div class="col-lg-10">
                @if($coffeeShops->isEmpty())
                    <div class="alert alert-warning text-center">
                        <h5>😔 Xin lỗi!</h5>
                        <p>Tôi không tìm thấy quán mà bạn muốn.</p>
                    </div>
                @else
                    @foreach ($coffeeShops as $shop)
                    <a href="{{ route('frontend.shop', ['id' => $shop->id]) }}" class="text-decoration-none text-dark">
                        <div class="card mb-4 shadow-sm">
                            <div class="row g-0">
                                {{-- Hình ảnh --}}
                                <div class="col-md-4">
                                    <div class="position-relative" style="aspect-ratio: 1 / 1; overflow: hidden;">
                                        <img src="{{ asset('frontend/images/' . $shop->cover_image) }}"
                                            class="img-fluid object-fit-cover w-100 h-100"
                                            style="object-fit: cover;"
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
                                                @php
                                                    $styleId = $shop->styles_id ?? null; // ← lấy id style từ cột đã select

                                                    $bgColor = '#DFFEF2';
                                                    $textColor = '#00B140';

                                                    if ($styleId) {
                                                        switch ($styleId) {
                                                            case 1:
                                                                $bgColor = '#EBF6F4'; $textColor = '#0F4C3A'; break; // Truyền thống
                                                            case 2:
                                                                $bgColor = '#F1E8F8'; $textColor = '#5F276D'; break; // Hiện đại
                                                            case 3:
                                                                $bgColor = '#FBF5E6'; $textColor = '#6F4E28'; break; // Công sở
                                                            case 4:
                                                                $bgColor = '#F7E7E7'; $textColor = '#76333C'; break; // Nhà máy
                                                        }
                                                    }
                                                @endphp

                                                @if (!empty($shop->style_name))
                                                    <span class="badge" style="background-color: {{ $bgColor }}; color: {{ $textColor }}; font-size: 1rem; font-weight: 500; padding: 6px 16px; border-radius: 999px; margin:0 5px 0 5px ">
                                                        {{ $shop->style_name }}
                                                    </span>
                                                @endif


                                                    <span class="badge bg-{{ $shop->status === 'Đang mở cửa' ? 'success' : 'secondary' }}">
                                                        {{ $shop->status === 'Đang mở cửa' ? 'Đang mở cửa' : 'Đã đóng cửa' }}
                                                    </span>

                                                    <!-- <div class="text-danger small mb-1">
                                                        <i class="fas fa-heart me-1"></i> Đã thích | {{ number_format($shop->likes_count ?? 0) }}
                                                    </div> -->

                                                    @if(isset($shop->distance))
                                                        <div class="text-muted small">
                                                            <i class="fas fa-map-marker-alt me-1"></i> Cách bạn: {{ $shop->distance }} km
                                                        </div>
                                                    @endif


                                                </div>
                                            </div>
                                            

                                            {{-- Đánh giá sao --}}
                                            @php $rating = $shop->reviews_avg_rating ?? 0; @endphp
                                                <div class="mb-2">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="{{ $i <= round($rating) ? 'fas' : 'far' }} fa-star text-warning"></i>
                                                    @endfor
                                                    @if ($rating > 0)
                                                        <small class="text-muted">({{ number_format($rating, 1) }})</small>
                                                    @else
                                                        <small class="text-muted">Chưa có đánh giá</small>
                                                    @endif
                                                </div>


                                                {{-- Thông tin chi tiết --}}
                                                    <ul class="list-unstyled text-muted mb-0 text-base leading-relaxed">
                                                        <li class="mb-1">
                                                            <i class="fas fa-clock me-1"></i> 
                                                            {{ \Carbon\Carbon::parse($shop->opening_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($shop->closing_time)->format('H:i') }}
                                                        </li>
                                                        <li class="mb-1">
                                                            <i class="fas fa-tags me-1"></i>
                                                            @if (is_numeric($shop->min_price) && is_numeric($shop->max_price))
                                                                {{ number_format($shop->min_price, 0) }}k - {{ number_format($shop->max_price, 0) }}k
                                                            @else
                                                                Không rõ giá
                                                            @endif
                                                        </li>
                                                        <li>
                                                            <i class="fas fa-map-marker-alt me-1"></i>
                                                            @if (!empty($shop->address_street))
                                                                {{ $shop->address_street }}
                                                            @else
                                                                <span class="text-muted">Chưa cập nhật địa chỉ</span>
                                                            @endif
                                                        </li>
                                                    </ul>

                                        </div>
                                        


                                    </div>
                                </div>
                            </div>
                        </div>
                     </a>
                    @endforeach
                @endif
            </div>

            {{-- Cột bên phải: Hình minh họa + Banner --}}
            <div class="col-lg-2 d-none d-lg-block">
                <div class="mb-4">
                    <img  src="{{ asset('frontend/images/Minhhoa Search.png') }}" class="img-fluid rounded shadow" alt="Minh họa">
                </div>
                <div>
                <img  src="{{ asset('frontend/images/hihi.png') }}" class="img-fluid rounded shadow" alt="Banner quảng cáo">
                </div>
            </div>
        </div>
    </div>
@endsection


