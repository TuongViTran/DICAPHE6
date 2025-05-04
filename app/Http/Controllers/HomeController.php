<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\CoffeeShop;
use App\Models\Style;
use App\Models\Address;

class HomeController extends Controller
{
    // Hiển thị các trang chính
    public function trangchu() {
        return view('frontend.trangchu', ['latitude' => $latitude, 'longitude' => $longitude]);
    }

    public function feed() {
        return view('frontend.feed');
    }

    public function tintuc() {
        return view('frontend.tintuc');
    }

    public function thongbao() {
        return view('frontend.thongbao');
    }
    public function user() {
        return view('frontend.user');
    }
    public function owner() {
        return view('frontend.owner');
    }
    
    public function index() {
        // Lấy bài viết cho slider và bài viết thường
        $styles = Style::all(); // Lấy danh sách kiểu quán
        $posts = Post::with('user')
            ->where('status', 'Published')
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Lấy bài viết cho slider (5 bài gần đây nhất)
        $sliderPosts = $posts->take(5);
    
        // Lấy danh sách quán cà phê kèm địa chỉ, trạng thái like của người dùng
        $shops = CoffeeShop::with('address', 'style')
        ->take(4)
        ->get()
        ->each(function ($shop) {
            $shop->liked = false;
            if (auth()->check()) {
                $shop->liked = \DB::table('favoriteshop')
                    ->where('user_id', auth()->id())
                    ->where('shop_id', $shop->id)
                    ->exists();
            }
        });

        
         // Lấy các quán đã lưu của user
         $user = auth()->user();
         $savedShops = [];
         
         if ($user) {
             $savedShops = $user->favoriteShops()->with('address')->get();
         }
        
        // Lấy danh sách các quán có rating 5 sao
        $fiveStarShops = CoffeeShop::with('address')
        ->where('reviews_avg_rating',  '>=', 5.0)
        ->get()
        ->each(function ($shop) {
            $shop->liked = false;
            if (auth()->check()) {
                $shop->liked = \DB::table('favoriteshop')
                    ->where('user_id', auth()->id())
                    ->where('shop_id', $shop->id)
                    ->exists();
            }
        });
        
        // Trả về view và truyền dữ liệu
        return view('frontend.trangchu', compact('sliderPosts', 'shops', 'posts', 'fiveStarShops','styles','savedShops'));
    }
    public function saveFavorite($shopId)
    {
        $user = auth()->user();  // Lấy người dùng hiện tại
    
        // Kiểm tra xem người dùng đã lưu quán này chưa
        $existingFavorite = \DB::table('favoriteshop')
            ->where('user_id', $user->id)
            ->where('shop_id', $shopId)
            ->first();
    
        if ($existingFavorite) {
            // Nếu đã lưu, thì xóa (bỏ yêu thích)
            \DB::table('favoriteshop')
                ->where('user_id', $user->id)
                ->where('shop_id', $shopId)
                ->delete();
    
            return response()->json([
                'status' => 'removed',
                'message' => 'Quán đã được xóa khỏi danh sách yêu thích.'
            ]);
        } else {
            // Nếu chưa lưu, thì thêm vào bảng
            \DB::table('favoriteshop')
                ->insert([
                    'user_id' => $user->id,
                    'shop_id' => $shopId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
    
            return response()->json([
                'status' => 'saved',
                'message' => 'Quán đã được thêm vào danh sách yêu thích.'
            ]);
        }
    }
}