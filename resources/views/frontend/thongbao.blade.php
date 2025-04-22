@extends('frontend.layout')
@section('title', 'Thông báo')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">📬 Thông báo của bạn</h2>

    {{-- Toast hiển thị thông báo mới --}}
    @if(session('new_notification'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
            <div class="toast show align-items-center text-white bg-success border-0">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('new_notification') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    @endif

    {{-- Bộ lọc thông báo --}}
    <form method="GET" class="mb-3">
        <select name="filter" class="form-select w-auto d-inline-block" onchange="this.form.submit()">
            <option value="">-- Tất cả --</option>
            <option value="unread" {{ request('filter') == 'unread' ? 'selected' : '' }}>Chưa đọc</option>
            <option value="read" {{ request('filter') == 'read' ? 'selected' : '' }}>Đã đọc</option>
        </select>
    </form>

    <div class="row">
        {{-- Danh sách thông báo --}}
        <div class="col-md-5">
            <h5 class="mb-3">📑 Danh sách thông báo</h5>
            <ul class="list-group">
                @forelse ($notifications as $notification)
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div>
                            <a href="{{ route('thongbao', ['view_id' => $notification->id, 'filter' => request('filter')]) }}"
                               style="color: {{ $notification->is_read ? '#6c757d' : '#000' }};
                                      font-weight: {{ $notification->is_read ? 'normal' : 'bold' }};">
                                {{ \Illuminate\Support\Str::limit($notification->message, 50) }}
                            </a>
                            <br>
                            <small class="text-muted">{{ $notification->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        @if (!$notification->is_read)
                            <span class="badge bg-danger rounded-pill">Mới</span>
                        @endif
                    </li>
                @empty
                    <li class="list-group-item text-muted">Không có thông báo nào.</li>
                @endforelse
            </ul>

            <div class="mt-3">
                {{ $notifications->links() }}
            </div>
        </div>

        {{-- Chi tiết thông báo --}}
        <div class="col-md-7">
            <h5 class="mb-3">📖 Chi tiết thông báo</h5>
            @if ($current)
                <div class="card">
                    <div class="card-body">
                        <p>{{ $current->message }}</p>
                        <small class="text-muted">Gửi lúc: {{ $current->created_at->format('d/m/Y H:i') }}</small>
                    </div>
                </div>
            @else
                <div class="alert alert-info">Chọn một thông báo để xem chi tiết.</div>
            @endif
        </div>
    </div>
</div>
@endsection
