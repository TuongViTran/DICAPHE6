@extends('frontend.layout')
@section('title', 'Feed')
@section('content')

<div class="container py-4">
    <h2 class="mb-4">📬 Thông báo của bạn</h2>

    <div class="row">
        <!-- Danh sách thông báo -->
        <div class="col-md-5">
            <h5>Danh sách thông báo</h5>
            <ul class="list-group">
                @foreach ($notifications as $notification)
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div>
                            <a href="{{ route('thongbao', ['view_id' => $notification->id]) }}"
                               style="{{ $notification->is_read ? 'color: gray;' : 'font-weight: bold;' }}">
                                {{ \Illuminate\Support\Str::limit($notification->message, 50) }}
                            </a>
                            <br>
                            <small>{{ $notification->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        @if (!$notification->is_read)
                            <span class="badge bg-primary rounded-pill">Mới</span>
                        @endif
                    </li>
                @endforeach
            </ul>

            <div class="mt-3">
                {{ $notifications->withQueryString()->links() }}
            </div>
        </div>

        <!-- Chi tiết thông báo -->
        <div class="col-md-7">
            <h5>Chi tiết thông báo</h5>
            @if ($current)
                <div class="card">
                    <div class="card-body">
                        <p>{{ $current->message }}</p>
                        <small class="text-muted">Gửi lúc: {{ $current->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                </div>
            @else
                <p>Chọn một thông báo để xem chi tiết.</p>
            @endif
        </div>
    </div>
</div>
@endsection
