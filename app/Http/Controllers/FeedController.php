<?php
namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\Feed;
use App\Models\Post;

use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function feed()
    {
        // Lấy danh sách review kèm thông tin user và sắp xếp theo thời gian mới nhất
        $reviews = Review::with('user')->orderBy('created_at', 'desc')->paginate(10);
        $posts = Post::where('status', 'Published') // Lấy bài viết cùng user tạo bài viết đó
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();
        return view('frontend.feed', compact('reviews', 'posts'));  
    }
    public function index(Request $request)
    {
        $query = Review::with('user')->latest();
    
        if ($request->has('rating') && is_numeric($request->rating)) {
            $query->where('rating', $request->rating);
        }
    
        // Tìm kiếm theo tên người dùng hoặc tên quán
    if ($request->filled('keyword')) {
        $keyword = $request->keyword;
        $query->where(function ($q) use ($keyword) {
            $q->whereHas('user', function ($q1) use ($keyword) {
                $q1->where('full_name', 'like', '%' . $keyword . '%');
            })->orWhereHas('shop', function ($q2) use ($keyword) {
                $q2->where('shop_name', 'like', '%' . $keyword . '%');
            });
        });
    }
        
        $feeds = $query->paginate(10)->withQueryString();
    
        return view('backend.admin.feedback_management', compact('feeds'));
    }
    public function destroy($id)
{
    $feed = Review::findOrFail($id); // Tìm review theo ID hoặc báo lỗi nếu không tồn tại
    $feed->delete(); // Xóa khỏi database

    return redirect()->route('feed.index')->with('success', 'Đã xóa feedback thành công!');
}
public function show($id)
{
    $feed = \App\Models\Review::with('user', 'shop')->findOrFail($id);
    return response()->json($feed);
}

}

