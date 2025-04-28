<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CoffeeShop;

class ShopController extends Controller
{
    public function show($id)
    {
        $coffeeShop = CoffeeShop::with(['reviews' => function($query) {
            $query->with('user')->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        $shop = Coffeeshop::with('address')->findOrFail($id);

            // Cập nhật sao trung bình sau khi lấy dữ liệu quán
            $shop->updateAverageRating();

        // Kiểm tra và gán giá trị cho latitude và longitude
        $latitude = $shop->address->latitude ?? null;
        $longitude = $shop->address->longitude ?? null;
        
        $savedShops = collect(); // Mặc định là rỗng nếu chưa đăng nhập
        if (auth()->check()) {
            $savedShops = \DB::table('favoriteshop')
                ->where('user_id', auth()->id())
                ->pluck('shop_id');
        }

        

        return view('frontend.shop', compact('coffeeShop','latitude', 'longitude', 'shop', 'savedShops'));
        
    }
}
