<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CoffeeShop;
use App\Models\User;
use App\Models\Post;
use App\Models\Review; // << THÊM DÒNG NÀY

class AdminController extends Controller
{
    public function dashboard()
    {
        // Quán 5 sao
        $fiveStarShops = CoffeeShop::with('address')
            ->withCount('reviews as total_reviews_count')
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->limit(5)
            ->get()
            ->each(function ($shop) {
                $avgRating = $shop->reviews_avg_rating !== null
                    ? number_format($shop->reviews_avg_rating, 1, '.', '')
                    : 0;

                $shop->reviews_avg_rating = $avgRating;
                $shop->save();
            });

        // Quán tệ nhất
        $worstShops = CoffeeShop::with('address')
            ->withCount('reviews as total_reviews_count')
            ->withAvg('reviews', 'rating')
            ->whereNotNull('reviews_avg_rating')
            ->orderBy('reviews_avg_rating')
            ->limit(5)
            ->get()
            ->each(function ($shop) {
                $avgRating = $shop->reviews_avg_rating !== null
                    ? number_format($shop->reviews_avg_rating, 1, '.', '')
                    : 0;

                $shop->reviews_avg_rating = $avgRating;
                $shop->save();
            });

        // Thống kê tổng quan
        $totalCoffeeshops = CoffeeShop::count();
        $totalUsers = User::count();
        $totalPosts = Post::count();
        $customerCount = User::where('role', 'user')->count();
        $ownerCount = User::where('role', 'owner')->count();
        $approvedPostsCount = Post::where('status', 'published')->count();
        $unapprovedPostsCount = Post::where('status', 'draft')->count();

        // Thống kê theo tháng
        $userCounts = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('role', 'user')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count')
            ->toArray();

        $ownerCounts = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('role', 'owner')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count')
            ->toArray();

        $userCounts = array_pad($userCounts, 7, 0);
        $ownerCounts = array_pad($ownerCounts, 7, 0);

        // Admin info
        $admin = User::where('role', 'admin')->first();
        $adminAvatar = $admin?->avatar_url;
        $adminName = $admin?->full_name;

        // 4 người dùng mới nhất
        $latestUsers = User::orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // Feedback nổi bật
        $featuredFeedbacks = Review::with('user','shop') // đảm bảo bảng reviews có quan hệ user
            ->where('rating', '>=', 4)
            ->orderByDesc('rating')
            ->limit(3)
            ->get();

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
            'userCounts',
            'ownerCounts',
            'latestUsers',
            'adminAvatar',
            'adminName',
            'featuredFeedbacks' // THÊM BIẾN NÀY
        ));
    }
}
