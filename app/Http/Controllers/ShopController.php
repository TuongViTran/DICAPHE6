<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CoffeeShop;

class ShopController extends Controller
{
    public function show($id)
    {
        $coffeeShop = CoffeeShop::with(['reviews.user'])->findOrFail($id); // dùng with() để eager load
    return view('frontend.shop', compact('coffeeShop'));
    }
}
