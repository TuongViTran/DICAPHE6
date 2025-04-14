<?php
namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use App\Models\Feed;

use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function feed()
    {
        // Lấy danh sách review kèm thông tin user và sắp xếp theo thời gian mới nhất
        $reviews = Review::with('user')->orderBy('created_at', 'desc')->paginate(10);

        return view('frontend.feed', compact('reviews'));
    }
    public function index(Request $request)
    {
        $query = Review::with('user')->latest();
    
        if ($request->has('rating') && is_numeric($request->rating)) {
            $query->where('rating', $request->rating);
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

}

