<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        // Trả về view shop.blade.php trong thư mục frontend
        return view('frontend.shop');
    }
}
