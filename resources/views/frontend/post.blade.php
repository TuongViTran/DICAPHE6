@extends('frontend.layout')
@section('title', $post->title)
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@section('content')
<div class="container mt-5 d-flex flex-wrap">
    <!-- Phần nội dung bài viết -->
    <div class="col-lg-9">
        <div class="mb-4">
            <h2 class="mb-2 text-4xl font-bold">{{ $post->title }}</h2>
            <div class="text-muted mb-2">
                <i class="fa-regular fa-calendar"></i> {{ $post->created_at->format('d/m/Y') }} |
                <i class="fa-regular fa-user"></i> {{ $post->user->full_name ?? 'Ẩn danh' }}
            </div>
            <p class="text-secondary fs-5">{{ $post->description }}</p>
            <img src="{{ asset('storage/uploads/posts/' . $post->image_url) }}" alt="Ảnh bài viết" class="img-fluid rounded my-3">
            <div class="post-content" style="max-width: 100%; overflow: hidden;">
            <style>
                .post-content img {
                    width: 80%;
                    max-width: 100%;
                    height: auto;
                    display: block;
                    margin: 10px auto;
                }
            </style>
            {!! $post->content !!}
            </div>
        </div>

        <!-- Phần bình luận -->
<div class="mt-5">
    <h5 class="mb-3">Bình luận</h5>

    {{-- Form viết bình luận (viết mới hoặc chỉnh sửa) --}}
    @auth
        <form action="{{ route('posts.comment', $post->id) }}" method="POST" class="mb-4" id="comment-form">
            @csrf
            <input type="hidden" name="comment_id" id="comment_id" value="">
            <textarea name="content" id="comment_content" rows="3" class="form-control" placeholder="Viết bình luận..." required></textarea>
            <button type="submit" class="btn btn-primary mt-4">Gửi bình luận</button>
        </form>
    @else
        <div class="alert alert-warning">
            <a href="{{ route('login') }}">Đăng nhập</a> để viết bình luận.
        </div>
    @endauth

    @if ($cmts->isNotEmpty())
        <ul class="list-group mt-4 mb-4">
            @foreach($cmts as $comment)
                <li class="list-group-item position-relative">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong>{{ $comment->user->full_name ?? 'Ẩn danh' }}</strong>
                            <small class="text-muted d-block">{{ $comment->created_at->diffForHumans() }}</small>
                            <p class="mb-0">{{ $comment->content }}</p>
                        </div>

                        {{-- Nếu là chủ bình luận --}}
                        @auth
                            @if (auth()->id() === $comment->user_id)
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        &#x22EE; {{-- dấu 3 chấm dọc --}}
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <button class="dropdown-item btn-edit" 
                                                data-id="{{ $comment->id }}"
                                                data-content="{{ $comment->content }}">
                                                Chỉnh sửa
                                            </button>
                                        </li>
                                        <li>
                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa bình luận này không?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">Xóa</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        @endauth
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-muted">Chưa có bình luận nào.</p>
    @endif
</div>

@push('scripts')
<script>
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const content = btn.dataset.content;

            document.getElementById('comment_id').value = id;
            document.getElementById('comment_content').value = content;
            document.querySelector('#comment_content').focus();
        });
    });
</script>
@endpush



    </div>

    <!-- Sidebar bài viết mới -->
    <div class="col-lg-3 mt-4 mt-lg-0 ps-lg-4">
        <h5 class="mb-3 text-danger text-xl font-semibold">Bài viết mới</h5>
        @foreach($news_tin as $news)
            <div class="card mb-3" style="width: 100%;">
                <img src="{{ asset('storage/uploads/posts/' . $news->image_url) }}" class="card-img-top" alt="{{ $news->title }}" style="height: 180px; object-fit: cover;">
                <div class="card-body p-2 ">
                    <a href="{{ route('posts.show', $news->id) }}" class="text-decoration-none text-dark">
                        <h6 class="card-title mb-1">{{ $news->title }}</h6>
                    </a>
                    <i class="fa-regular fa-calendar"></i><small class="text-muted">{{ $news->created_at->format('d/m/Y') }}</small> |
                    <i class="fa-regular fa-user"></i><small class="text-muted"> {{ $post->user->full_name ?? 'Ẩn danh' }}</small>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
