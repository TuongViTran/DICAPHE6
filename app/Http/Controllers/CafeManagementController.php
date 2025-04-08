<?php
namespace App\Http\Controllers;

use App\Models\CoffeeShop;
use Illuminate\Http\Request;

class CafeManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $coffeeShops = CoffeeShop::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'LIKE', "%{$query}%")
                ->orWhere('address', 'LIKE', "%{$query}%")
                ->orWhere('style', 'LIKE', "%{$query}%");
        })->get();
    
        // Định nghĩa các từ khóa và khu vực phổ biến
        $popularKeywords = ['Cà phê sữa', 'Trà sữa', 'Cà phê rang xay'];
        $popularLocations = ['Hà Nội', 'TP. Hồ Chí Minh', 'Đà Nẵng'];
    
        // Truyền các biến vào view
        return view('backend.admin.cafe.index', compact('coffeeShops', 'query', 'popularKeywords', 'popularLocations'));
    }
}