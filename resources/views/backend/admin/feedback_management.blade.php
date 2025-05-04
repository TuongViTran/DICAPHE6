@extends('backend.admin.layout')

@section('title', 'Quản lý quán cà phê ')

@section('header', 'Quản lý đánh giá')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="container mt-5">
    

   <div style="display:flex">
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

    {{-- Thanh tìm kiếm --}}
    <form method="GET" action="{{ route('feed.index') }}" class="mb-4 row g-3 align-items-center">
        <div class="col-auto">
            <input type="text" name="keyword" class="form-control" style="width: 260px;margin-left:50px" placeholder="Tìm người dùng hoặc quán"
                value="{{ request('keyword') }}">
        </div>

        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </div>
    </form>
   </div>


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
    <!-- @for ($i = 1; $i <= 5; $i++)
        @if ($i <= $feed->rating)
            <span style="color: #ffc107; font-size: 24px;">&#9733;</span> {{-- sao đầy --}}
        @else
            <span style="color: #ffc107; font-size: 24px;">&#9734;</span> {{-- sao rỗng --}}
        @endif
    @endfor -->
    @for ($i = 1; $i <= 5; $i++)
    <i class="fa{{ $i <= $feed->rating ? 's' : 'r' }} fa-star text-warning"></i>
@endfor
    ({{ $feed->rating }})
</td>
<td>{{ $feed->likes_count ?? 0 }}</td>
                    <td>{{ $feed->created_at->format('d/m/Y H:i') }}</td>
                    <td style="display:flex">
                        <form action="{{ route('feed.destroy', $feed->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa feedback này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn  btn-sm">    <img src="{{ asset('backend/img/Icon (admin)/Xóa.svg') }}" alt="Delete" class="w-7 h-7"></button>
                        </form>
                        
                            <button type="button" class="btn  btn-sm view-detail" data-id="{{ $feed->id }}" style="margin-top:-15px;">
                                <img src="{{ asset('backend/img/Icon (admin)/Mở rộng.svg') }}" alt="View" class="w-7 h-7">
                            </button>
                        
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


<!-- Modal -->
<div class="modal fade" id="feedDetailModal" tabindex="-1" aria-labelledby="feedDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-4">
    <strong style="font-size:large">Xem đánh giá</strong>
      <div class="modal-body">
            
        <div class="d-flex align-items-center mb-3" style="margin-right:350px;">
            <img id="modalAvatar" src="" width="50" height="50" alt="Avatar" class="rounded-circle me-3"
                 onerror="this.src='{{ asset('frontend/images/avt.png') }}'">
            <div>
                <strong id="modalUser">User</strong>
                <span> đang ở tại <strong id="modalShop">Tên quán</strong></span>
                <div class="d-flex align-items-center mt-1">
                    <small class="text-muted" id="modalDate">--/--/----</small>&ensp;
                    <span id="modalLikes" class="ms-3">0 lượt thích</span>
                    <div class="ms-3 text-warning" id="modalRating"></div>
                </div>
            </div>
        </div>

        <p id="modalContent" class="ms-5"></p>
        <br>

        <div class="row" id="modalImages"></div>

      </div>
    </div>
  </div>
</div>



@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $('.view-detail').click(function() {
        var feedId = $(this).data('id');

        $.ajax({
            url: '/feed-management/' + feedId,
            method: 'GET',
            success: function(data) {
                $('#modalUser').text(data.user?.full_name ?? 'Ẩn danh');
                $('#modalShop').text(data.shop?.shop_name ?? 'Không rõ');
                $('#modalDate').text(new Date(data.created_at).toLocaleDateString('vi-VN'));
                $('#modalLikes').text(data.likes_count + ' lượt thích');
                $('#modalContent').text(data.content);

                // Avatar
                const avatarPath = data.user?.avatar_url
                    ? `/frontend/images/${data.user.avatar_url.split('/').pop()}`
                    : '{{ asset("frontend/images/avt.png") }}';
                $('#modalAvatar').attr('src', avatarPath);

                // Star rating
                let stars = '';
                for (let i = 1; i <= 5; i++) {
                    stars += `<i class="fa${i <= data.rating ? 's' : 'r'} fa-star"></i>`;
                }
                $('#modalRating').html(stars);

                // Images
                let imagesHtml = '';
                if (data.img_url) {
                    const urls = data.img_url.split(',').slice(0, 3);
                    urls.forEach(img => {
                        img = img.trim();
                        if (img === '') return;
                        const isUrl = img.startsWith('http');
                        const fullPath = isUrl ? img : `/storage/${img}`;
                        imagesHtml += `
                          <div class="col-4 d-flex mb-2">
                            <img src="${fullPath}" style="height:280px; width:250px; object-fit:cover;" class="img-fluid rounded shadow" alt="Review Image"
                                 onerror="this.src='{{ asset('frontend/images/tt.svg') }}';">
                          </div>`;
                    });
                }
                $('#modalImages').html(imagesHtml);

                $('#feedDetailModal').modal('show');
            },
            error: function() {
                alert('Không thể tải chi tiết đánh giá.');
            }
        });
    });
});
</script>

