@extends('backend.admin.layout')

@section('title', 'Quản lý quán cà phê ')

@section('header', 'Quản lý đánh giá')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@section('content')
<div class="container mt-5">
    

    {{-- Form lọc theo số sao --}}
    <form method="GET" action="{{ route('feed.index') }}" class="mb-4 row g-3 align-items-center">
        <div class="col-auto">
            <label for="rating" class="col-form-label">Lọc theo số sao:</label>
        </div>
        <div class="col-auto">
            <select name="rating" id="rating" class="form-select">
                <option value="">-- Tất cả --</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} sao ⭐</option> 
                @endfor
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Lọc</button>
        </div>
    </form>

    {{-- Bảng feedback --}}
    <table class="table table-striped table-bordered">
        <thead class="table-secondary">
            <tr>
                <th>STT</th>
                <th>Người gửi</th>
                <th>Tên quán</th>
                <th>Nội dung</th>
                <th>Số sao</th>
                <th>Lượt thích</th>
                <th>Ngày gửi</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($feeds as $index => $feed)
                <tr>
                    <td>{{ $feeds->firstItem() + $index }}</td>
                    <td>{{ $feed->user->full_name ?? 'Ẩn danh' }}</td>
                    <td>{{ $feed->shop->shop_name ?? 'Không rõ' }}</td>
                    <td>{{ $feed->content }}</td>
                    <td>
    @for ($i = 1; $i <= 5; $i++)
        @if ($i <= $feed->rating)
            <span style="color: #ffc107; font-size: 24px;">&#9733;</span> {{-- sao đầy --}}
        @else
            <span style="color: #ffc107; font-size: 24px;">&#9734;</span> {{-- sao rỗng --}}
        @endif
    @endfor
    ({{ $feed->rating }})
</td>
<td>{{ $feed->likes_count ?? 0 }}</td>
                    <td>{{ $feed->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <form action="{{ route('feed.destroy', $feed->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa feedback này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">Không có feedback nào.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $feeds->links() }}
    </div>
</div>
@endsection