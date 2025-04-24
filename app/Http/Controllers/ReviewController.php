<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'shop_id' => 'required|exists:coffeeshop,id',
        'content' => 'required|string',
        'rating' => 'required|integer|min:1|max:5',
        'img_url' => 'required|array', // bắt buộc là mảng
        'img_url.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Nếu không có ảnh thì báo lỗi (giữ nguyên chức năng cũ của bạn)
    if (!$request->hasFile('img_url')) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['img_url' => 'Bạn chưa thêm ảnh, vui lòng tải lên ít nhất một ảnh!'])
            ->with('openModal', true);
    }

    $imagePaths = [];
    foreach ($request->file('img_url') as $image) {
        $filename = uniqid() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('reviews', $filename, 'public');
        $imagePaths[] = $path;
    }

    $review = new Review();
    $review->user_id = auth()->id();
    $review->shop_id = $request->shop_id;
    $review->content = $request->content;
    $review->rating = $request->rating;
    $review->img_url = implode(',', $imagePaths); // Lưu nhiều ảnh thành chuỗi

    $review->save();

    return redirect()->back()->with('jsAlert', 'Đánh giá đã được gửi!');
}


    public function update(Request $request, Review $review)
    {
        if (auth()->id() !== $review->user_id) {
            abort(403, 'Bạn không có quyền sửa đánh giá này.');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review->update([
            'content' => $request->content,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('jsAlert', 'Cập nhật đánh giá thành công.');
    }

    public function destroy(Review $review)
    {
        if (auth()->id() !== $review->user_id) {
            abort(403, 'Bạn không có quyền xoá đánh giá này.');
        }

        // Xoá các ảnh nếu có
        if ($review->img_url) {
            $images = explode(',', $review->img_url);
            foreach ($images as $img) {
                Storage::disk('public')->delete($img);
            }
        }

        $review->delete();

        return redirect()->back()->with('jsAlert', 'Đánh giá đã được xoá.');
    }
    public function toggleLike(Review $review)
    {
        $user = auth()->user();
    
        // Kiểm tra xem user đã like hay chưa
        $existingLike = $review->likedUsers()->where('user_id', $user->id)->first();
    
        if ($existingLike) {
            // Nếu đã like thì un-like
            $review->likedUsers()->detach($user->id);
            $liked = false;
            $review->decrement('likes_count');
        } else {
            // Nếu chưa like thì like
            $review->likedUsers()->attach($user->id);
            $liked = true;
            $review->increment('likes_count');
        }
    
        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $review->likes_count
        ]);
    }
    
    
    

}
