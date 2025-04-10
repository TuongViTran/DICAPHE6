<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'shop_id' => 'required|exists:coffeeshop,id',
        'content' => 'required|string',
        'rating' => 'required|integer|min:1|max:5',
        'img_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

   
    // Nếu không có ảnh, lưu lỗi vào session để giữ modal mở
    if (!$request->hasFile('img_url')) {
        return redirect()->back()
            ->withInput()
            ->withErrors(['img_url' => 'Bạn chưa thêm ảnh, vui lòng tải lên một ảnh!'])
            ->with('openModal', true); // Đánh dấu mở modal
    }
    $review = new Review();
    $review->user_id = auth()->id();
    $review->shop_id = $request->shop_id;
    $review->content = $request->content;
    $review->rating = $request->rating;

  
    
     // Lưu ảnh nếu có
     if ($request->hasFile('img_url')) {
        $imagePath = $request->file('img_url')->store('reviews', 'public');
        $review->img_url = $imagePath;
    }


    $review->save();

    return redirect()->back()->with('success', 'Đánh giá đã được gửi!');
}


}
