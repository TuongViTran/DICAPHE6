<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\CoffeeShop;
use App\Models\Comment;

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

    // Hàm hiển thị trang Blog với bài viết và slider
    public function Blog_Post()
    {
        $posts = Post::with('user')
        ->where('status', 'Published')
        ->orderBy('created_at', 'desc')
        ->paginate(5); // paginate phải là bước cuối cùng

        // Lấy 3 bài viết cho slider
        $sliderPosts = Post::where('status', 'Published')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // Trả về giao diện frontend.trangchu
        return view('frontend.tintuc', compact('posts', 'sliderPosts'));
    }

    // Hàm hiển thị danh sách bài viết
    public function index($id)
    {
        $posts = Post::with('user') // Lấy bài viết cùng user tạo bài viết đó
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        $userId = auth()->id();

        $coffeeShop = CoffeeShop::where('user_id', $id)->with('user')->first();

        return view('frontend.owner', compact('posts','coffeeShop'));
    }
    
    // Hàm lưu bài viết mới trong owner
    public function store(Request $request,$userId)
    {
        $coffeeShop = CoffeeShop::where('user_id', $userId)->with('user')->first();

        if (!$coffeeShop) {
            return redirect()->back()->with('error', 'Không tìm thấy quán cà phê cho người dùng này.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        // Xử lý upload ảnh
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = $image->storeAs('uploads/posts', $imageName, 'public');
        }

        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'Published',
            'content' => $request->content,
            //'image_url' => $request->image, // Ảnh đã được lưu từ CKEditor
            'image_url' => $imageName,
            'user_id' => $userId
        ]);

        return redirect()->route('posts.index', ['id' => $userId])->with('success', 'Bài viết đã được tạo.');
    }

    // Hàm xóa bài viết
    public function destroy($postId)
    {
        $post = Post::findOrFail($postId);

        // Xoá ảnh nếu có
        if ($post->image_url && \Storage::disk('public')->exists('uploads/posts/' . $post->image_url)) {
            \Storage::disk('public')->delete('uploads/posts/' . $post->image_url);
        }
        $post->comments()->delete(); // Xóa bình luận liên quan đến bài viết

        $post->delete();

        return redirect()->back()->with('success', 'Bài viết đã được xóa.');
    }

    // Hàm cập nhật bài viết
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Nếu có ảnh mới thì xử lý
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('uploads/posts', $imageName, 'public');
            $post->image_url = $imageName;
        }

        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Cập nhật bài viết thành công!');
    }


    // upload anh cho ckeditor
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);

            return response()->json([
                'url' => asset('uploads/' . $filename)
            ]);
        }

        return response()->json(['error' => ['message' => 'Upload failed.']]);
    }
    // Hàm hiển thị trang chi tiết bài viết
    public function show($id,Request $request)
    {
        $post = Post::with('user')->findOrFail($id);

        // Giả sử bạn có bảng "news" khác (tin tức hot và mới)
        $list_four_tin = Post::orderBy('created_at', 'desc')->take(3)->get(); // bài hot (có thể sửa logic)
        $news_tin = Post::orderBy('created_at', 'desc')->take(3)->get(); // mới nhất

        // Lấy bình luận theo bài viết
        $cmts = Comment::where('post_id', $id)->orderBy('created_at', 'desc')->get();
        // Lấy thông tin người dùng đã bình luận
        $editingComment = null;
            if ($request->has('edit_comment')) {
                $editingComment = Comment::where('id', $request->edit_comment)
                                        ->where('user_id', auth()->id())
                                        ->first();
            }

        return view('frontend.post', compact('post', 'cmts','editingComment', 'list_four_tin', 'news_tin'));
    }
    // Hàm lưu bình luận
    public function storeComment(Request $request, $id)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để bình luận.');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'post_id' => $id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Bình luận đã được gửi.');
    }
    // Hàm xóa bình luận
    public function destroyComment($id)
    {
        $comment = Comment::findOrFail($id);

        // Kiểm tra người dùng hiện tại có phải là chủ bình luận không
        if (auth()->id() !== $comment->user_id) {
            abort(403, 'Bạn không có quyền xóa bình luận này.');
        }

        $comment->delete();

        return back()->with('success', 'Xóa bình luận thành công!');
    }

    // Hàm sửa bình luận
    public function updateComment(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        if (auth()->id() !== $comment->user_id) {
            abort(403, 'Bạn không có quyền chỉnh sửa bình luận này.');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Cập nhật bình luận thành công!');
    }




}
