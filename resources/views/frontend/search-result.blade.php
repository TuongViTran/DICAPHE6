@extends('frontend.layout')
@section('title', 'Kết quả tìm kiếm')
@section('content')
<div class="container">
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

    <h3 class="mb-4">{{ $resultText }}</h3>

    <div class="row">
        {{-- Cột bên trái: Danh sách quán --}}
        <div class="col-lg-8">
            @if($coffeeShops->isEmpty())
                <div class="alert alert-warning text-center">
                    <h5>😔 Xin lỗi!</h5>
                    <p>Tôi không tìm thấy quán mà bạn muốn.</p>
                </div>
            @else
                @foreach ($coffeeShops as $shop)
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
                                        <h3 class="card-title mb-0 fw-bold">{{ $shop->shop_name }}</h3>
                                        <div class="d-flex align-items-center gap-2">
                                        @php
                                                $style = $shop->style;
                                                $bgColor = '#DFFEF2';
                                                $textColor = '#00B140';

                                                if ($style) {
                                                    switch ($style->id) {
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

                                            @if($style)
                                                <span class="badge" style="background-color: {{ $bgColor }}; color: {{ $textColor }}; font-size: 1rem; font-weight: 500; padding: 6px 16px; border-radius: 999px; margin:0 5px 0 5px ">
                                                    {{ $style->style_name }}
                                                </span>
                                            @endif
                                            <span class="badge bg-{{ $shop->status === 'open' ? 'success' : 'secondary' }}">
                                                {{ $shop->status === 'open' ? 'Đang mở cửa' : 'Đã đóng cửa' }}
                                            </span>
                                            <div class="text-danger small">
                                                <i class="fas fa-heart me-1"></i> Đã thích | {{ number_format($shop->likes_count ?? 0) }}
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Đánh giá sao --}}
                                    <div class="mb-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= round($shop->rating))
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                        <small class="text-muted">({{ number_format($shop->rating, 1) }})</small>
                                    </div>

                                    {{-- Thông tin chi tiết --}}
                                    <ul class="list-unstyled text-muted mb-0 small">
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
                                            {{ $shop->address->street }}, {{ $shop->address->ward }}
                                        </li>
                                    </ul>
                                </div>

                                {{-- Avatar chủ quán --}}
                                <div class="d-flex align-items-center mt-3">
                                    <img src="{{ asset('frontend/images/' . ($shop->user->avatar_url ?? 'avt.png')) }}"
                                         class="rounded-circle me-2"
                                         width="50" height="50" alt="Chủ quán">
                                    <span class="text-muted small">{{ $shop->user->full_name ?? 'Chủ quán' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

        {{-- Cột bên phải: Hình minh họa + Banner --}}
        <div class="col-lg-4 d-none d-lg-block">
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

@section('scripts')
<script>
    window.coffeeShops = @json($coffeeShops->map(function ($shop) {
        return [
            'id' => $shop->id,
            'latitude' => $shop->address->latitude,
            'longitude' => $shop->address->longitude
        ];
    }));
</script>
<script src="{{ asset('frontend/js/seacher.js') }}"></script>
@endsection
