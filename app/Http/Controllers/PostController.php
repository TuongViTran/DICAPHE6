<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\CoffeeShop;
use App\Models\Comment;
use App\Models\Notification;
use App\Models\Review;
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
        // $posts = Post::with('user')
        // ->where('status', 'Published')
        // ->orderBy('created_at', 'desc')
        // ->paginate(4); 

        $posts = Post::orderBy('created_at', 'desc')->where('status', 'Published')->paginate(4);

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
        $postCount = Post::where('user_id', $userId)->count(); // Lấy tổng số bài viết của người dùng hiện tại
        $coffeeShop = CoffeeShop::where('user_id', $id)->with('user')->first(); // Lấy thông tin quán cà phê của người dùng
        $reviewCount = $coffeeShop->reviews()->count();  //Tổng lượt đánh giá của shop

        // Lấy danh sách đánh giá theo shop_id
        $reviews = Review::with('user')
        ->where('shop_id', $coffeeShop->id)
        ->latest()
        ->get();

        return view('frontend.owner', compact('posts','coffeeShop', 'reviews', 'postCount', 'reviewCount'));
    }
    
    // Hàm lưu bài viết mới trong owner
    public function store(Request $request, $userId)
    {
        $coffeeShop = CoffeeShop::where('user_id', $userId)->first();

        if (!$coffeeShop) {
            return redirect()->back()->with('error', 'Không tìm thấy quán cà phê cho người dùng này.');
        }

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:500',
                'content' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'title.required' => 'Tiêu đề không được để trống.',
                'description.required' => 'Mô tả không được để trống.',
                'content.required' => 'Nội dung không được để trống.',
                'image.required' => 'Hình ảnh là bắt buộc.',
                'image.image' => 'Tệp phải là hình ảnh.',
                'image.mimes' => 'Ảnh phải thuộc định dạng: jpeg, png, jpg, gif.',
            ]);
    
            // Upload ảnh
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('uploads/posts', $imageName, 'public');
    
            Post::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => 'Published',
                'content' => $request->content,
                'image_url' => $imageName,
                'user_id' => $userId,
            ]);
    
            return redirect()->route('posts.index', ['id' => $userId])->with('success', 'Tạo bài viết thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // ⚠️ Đánh dấu lỗi là của modal "create"
            session()->flash('create_modal', true);
            throw $e;
        }
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
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string|max:500',
                'content' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'title.required' => 'Tiêu đề không được để trống.',
                'description.required' => 'Mô tả không được để trống.',
                'content.required' => 'Nội dung không được để trống.',
                'image.required' => 'Hình ảnh là bắt buộc.',
                'image.image' => 'Tệp phải là hình ảnh.',
                'image.mimes' => 'Ảnh phải thuộc định dạng: jpeg, png, jpg, gif.',
            ]);

            if ($request->hasFile('image')) {
                $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
                $request->file('image')->storeAs('uploads/posts', $imageName, 'public');
                $post->image_url = $imageName;
            }

            $post->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'content' => $validated['content'],
            ]);

            return redirect()->back()->with('success', 'Cập nhật thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            session()->flash('edit_modal_id', $post->id); // 👈 để biết mở modal edit nào
            throw $e;
        }
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
  
        $news_tin = Post::where('id', '!=', $post->id) // Lấy bài viết khác với bài viết hiện tại
                    ->orderBy('created_at', 'desc')
                    ->take(3)
                    ->get();

        // Lấy bình luận theo bài viết
        $cmts = Comment::where('post_id', $id)->orderBy('created_at', 'desc')->get();
        // Lấy thông tin người dùng đã bình luận
        $editingComment = null;
            if ($request->has('edit_comment')) {
                $editingComment = Comment::where('id', $request->edit_comment)
                                        ->where('user_id', auth()->id())
                                        ->first();
            }

        return view('frontend.post', compact('post', 'cmts','editingComment', 'news_tin'));
    }
    public function storeComment(Request $request, $postId)
{
    $request->validate([
        'content' => 'required|string|max:1000',
    ]);

    if (!auth()->check()) {
        return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để bình luận.');
    }

    // Nếu là chỉnh sửa
    if ($request->filled('comment_id')) {
        $comment = Comment::findOrFail($request->comment_id);

        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }

        $comment->content = $request->content;
        $comment->save();

        return back()->with('success', 'Cập nhật bình luận thành công!');
    }

    // Nếu là bình luận mới
    $comment = Comment::create([
        'post_id' => $postId,
        'user_id' => auth()->id(),
        'content' => $request->content,
    ]);

    // Gửi thông báo cho chủ bài viết nếu không phải người tự bình luận vào bài viết mình
    $post = Post::find($postId);
    if ($post && $post->user_id != auth()->id()) {
        Notification::create([
            'user_id' => $post->user_id,
            'type' => 'comment',
            'message' => auth()->user()->name . ' đã bình luận vào bài viết "' . $post->title . '"',
            'link' => route('posts.show', $post->id),
        ]);
    }

    return back()->with('success', 'Bình luận đã được gửi.');
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