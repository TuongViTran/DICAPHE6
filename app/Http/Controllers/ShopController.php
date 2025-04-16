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
        
        return view('frontend.shop', compact('coffeeShop'));
        
    }
}
