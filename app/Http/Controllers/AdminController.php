<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CoffeeShop;
use App\Models\User;
use App\Models\Post;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Quán có sao 5 sao
        $fiveStarShops = CoffeeShop::with('address')
            ->withCount('reviews as total_reviews_count') // Đếm tổng các đánh giá
            ->withAvg('reviews', 'rating') // Tính điểm đánh giá trung bình
            ->orderByDesc('reviews_avg_rating') // Sắp xếp theo điểm trung bình giảm dần
            ->limit(5)
            ->get()
            ->each(function ($shop) {
                // Tính và làm tròn trung bình
                $avgRating = $shop->reviews_avg_rating !== null
                    ? number_format($shop->reviews_avg_rating, 1, '.', '')
                    : 0;
    
                // Gán vào để hiển thị
                $shop->reviews_avg_rating = $avgRating;
    
                // Kiểm tra like
                $shop->liked = auth()->check() && $shop->likes()->where('user_id', auth()->id())->exists();
            });
    
        // Quán có sao tệ nhất
        $worstShops = CoffeeShop::with('address')
            ->withCount('reviews as total_reviews_count') // Đếm tất cả các đánh giá
            ->withAvg('reviews', 'rating')
            ->whereNotNull('reviews_avg_rating') // Lọc các quán có đánh giá thực sự
            ->orderBy('reviews_avg_rating') // Sắp xếp theo điểm đánh giá trung bình từ thấp đến cao
            ->limit(5) // Lấy 5 quán có điểm đánh giá thấp nhất
            ->get()
            ->each(function ($shop) {
                // Làm tròn điểm đánh giá trung bình
                $avgRating = $shop->reviews_avg_rating !== null
                    ? number_format($shop->reviews_avg_rating, 1, '.', '')
                    : 0;
    
                // Cập nhật lại điểm đánh giá sau khi làm tròn
                $shop->reviews_avg_rating = $avgRating;
    
                // Kiểm tra like
                $shop->liked = auth()->check() && $shop->likes()->where('user_id', auth()->id())->exists();
            });
    
        // Thông tin tổng quan
        $totalCoffeeshops = CoffeeShop::count();
        $totalUsers = User::count();
        $totalPosts = Post::count();
    
        // Tính số lượng người dùng theo vai trò
        $customerCount = User::where('role', 'user')->count();
        $ownerCount = User::where('role', 'owner')->count();
    
        // Tính số lượng bài viết theo trạng thái
        $approvedPostsCount = Post::where('status', 'published')->count();
        $unapprovedPostsCount = Post::where('status', 'draft')->count();
    
        // Lấy số lượng người dùng theo tháng
        $userCounts = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('role', 'user') // Lọc chỉ lấy khách hàng
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count')
            ->toArray();
    
        // Lấy số lượng chủ quán theo tháng
        $ownerCounts = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('role', 'owner') // Lọc chỉ lấy chủ quán
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count')
            ->toArray();
    
        // Đảm bảo rằng mảng có đủ 7 phần tử (cho 7 tháng)
        $userCounts = array_pad($userCounts, 7, 0);
        $ownerCounts = array_pad($ownerCounts, 7, 0);
    
        return view('backend.admin.dashboard', compact(
            'fiveStarShops',
            'worstShops',
            'totalCoffeeshops',
            'totalUsers',
            'customerCount',
            'ownerCount',
            'totalPosts',
            'approvedPostsCount',
            'unapprovedPostsCount',
            'userCounts', // Truyền dữ liệu số lượng khách hàng theo tháng
            'ownerCounts' // Truyền dữ liệu số lượng chủ quán theo tháng
        ));
    }
}