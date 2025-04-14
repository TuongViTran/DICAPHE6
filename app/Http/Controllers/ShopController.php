<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CoffeeShop;

class ShopController extends Controller
{
    public function show($id)
    {
        $coffeeShop = CoffeeShop::find($id); // hoặc first()
return view('frontend.shop', compact('coffeeShop'));
    }
}
