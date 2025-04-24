<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CoffeeShop;


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

                // Gán vào cột thật sự trong DB và lưu lại
                $shop->setAttribute('reviews_avg_rating', $avgRating);
                $shop->save();

                
                
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
                $shop->setAttribute('reviews_avg_rating', $avgRating);
                $shop->save();

                
                
            });





return view('backend.admin.dashboard', compact('fiveStarShops', 'worstShops'));



}

}
