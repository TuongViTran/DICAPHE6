@extends('frontend.layout')
@section('title', $post->title)

@section('content')
<div class="container mt-5 d-flex flex-wrap">
    <!-- Phần nội dung bài viết -->
    <div class="col-lg-9">
        <div class="mb-4">
            <h2 class="mb-2">{{ $post->title }}</h2>
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

            @auth
            <form action="{{ isset($editingComment) ? route('comments.update', $editingComment->id) : route('posts.comment', $post->id) }}" method="POST">
                @csrf
                @if (isset($editingComment)) @method('PUT') @endif

                <textarea name="content" rows="3" class="form-control" placeholder="Viết bình luận..." required>{{ old('content', $editingComment->content ?? '') }}</textarea>
                <div class="mt-2 d-flex gap-2 mb-2">
                    <button type="submit" class="btn btn-primary">
                        {{ isset($editingComment) ? 'Cập nhật' : 'Gửi bình luận' }}
                    </button>
                    @if (isset($editingComment))
                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-secondary">Hủy</a>
                    @endif
                </div>
            </form>
            @else
                <div class="alert alert-warning">
                    <a href="{{ route('login') }}">Đăng nhập</a> để viết bình luận.
                </div>
            @endauth

            @if ($cmts->isNotEmpty())
                <ul class="list-group mb-3">
                    @foreach($cmts as $comment)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <strong>{{ $comment->user->full_name ?? 'Ẩn danh' }}</strong>
                                    <p class="mb-1">{{ $comment->content }}</p>
                                </div>

                                <div class="text-end">
                                    <small class="text-muted d-block">{{ $comment->created_at->diffForHumans() }}</small>

                                    @auth
                                        @if (auth()->id() === $comment->user_id)
                                            {{-- Nút ba chấm --}}
                                            <div class="dropdown">
                                                <a class="text-muted" href="#" role="button" id="dropdownMenu{{ $comment->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </a>

                                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenu{{ $comment->id }}">
                                                    <li>
                                                        <a href="{{ route('posts.show', ['id' => $post->id, 'edit_comment' => $comment->id]) }}" class="dropdown-item">✏️ Sửa</a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('Xóa bình luận này?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">❌ Xóa</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">Chưa có bình luận nào.</p>
            @endif

        </div>

    </div>

    <!-- Sidebar bài viết mới -->
    <div class="col-lg-3 mt-4 mt-lg-0 ps-lg-4">
        <h5 class="mb-3 text-danger">Bài viết mới</h5>
        @foreach($news_tin as $news)
            <div class="card mb-3" style="width: 100%;">
                <img src="{{ asset('storage/uploads/posts/' . $news->image_url) }}" class="card-img-top" alt="{{ $news->title }}">
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
