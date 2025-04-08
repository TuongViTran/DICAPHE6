<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    // Hàm hiển thị trang Home với bài viết và slider
    public function Hienthi_Post()
    {
        $posts = Post::with('user') // Lấy bài viết cùng user tạo bài viết đó
            ->where('status', 'Published')
            ->orderBy('created_at', 'desc')
            ->get();
        // Lấy 3 bài viết cho slider
        $sliderPosts = Post::where('status', 'Published')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // Trả về giao diện frontend.trangchu
        return view('frontend.trangchu', compact('posts', 'sliderPosts'));
    }
}
