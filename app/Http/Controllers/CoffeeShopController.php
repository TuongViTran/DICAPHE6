<?php

namespace App\Http\Controllers;

use App\Models\CoffeeShop;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\SocialNetwork;
use Illuminate\Support\Facades\Storage;
use App\Models\Address;

class CoffeeShopController extends Controller
{
    public function like($id)
    {
        $shop = CoffeeShop::findOrFail($id);
        $user = auth()->user();
    
        if ($shop->likes()->where('user_id', $user->id)->exists()) {
            $shop->likes()->where('user_id', $user->id)->delete();
            $liked = false;
        } else {
            $shop->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }
    
        return response()->json([
            'liked' => $liked,
            'likes' => $shop->likes()->count(),
        ]);
    }
    public function index()
    {
        $coffeeshops = CoffeeShop::all();
        return view('backend.admin.coffeeshops_management', compact('coffeeshops'));
    }
    
    /**
     * Hiển thị chi tiết quán coffee.
     *  // Tìm quán coffee theo ID, đồng thời lấy cả danh sách đánh giá
     */
    public function show($id)
    {
       
        $coffeeShop = CoffeeShop::with('reviews.user')->findOrFail($id);
        $reviews = Review::where('shop_id', $id)
        ->with('user') // Nếu có mối quan hệ với bảng users
        ->orderBy('created_at', 'desc')
        ->get();

        dd($reviews->toArray()); // In ra danh sách đánh giá và dừng chương trình

        
        return view('owner.index', compact('coffeeShop', 'reviews'));

        
    }

    /**
     * Xử lý lưu đánh giá từ người dùng.
     */
    public function storeReview(Request $request, $id)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'content' => 'required|string|max:500',
            'rating' => 'required|integer|min:1|max:5',
            'img_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Lưu ảnh nếu có
        $imgPath = null;
        if ($request->hasFile('img_url')) {
            $imgPath = $request->file('img_url')->store('reviews', 'public');
        }

        // Thêm đánh giá vào database
        Review::create([
            'user_id' => auth()->id(), // Lấy ID người dùng đăng nhập
            'shop_id' => $id,
            'content' => $request->content,
            'rating' => $request->rating,
            'img_url' => $imgPath,
            'likes_count' => 0,
        ]);

        return redirect()->back()->with('success', 'Đánh giá của bạn đã được gửi.');
    }
    
}


