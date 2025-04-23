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

        // Kiểm tra và gán giá trị cho latitude và longitude
        $latitude = $shop->address->latitude ?? null;
        $longitude = $shop->address->longitude ?? null;
        
        return view('frontend.shop', compact('coffeeShop','latitude', 'longitude', 'shop'));
        
    }
}
