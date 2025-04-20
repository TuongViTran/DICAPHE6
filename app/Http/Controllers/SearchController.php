<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CoffeeShop;
use App\Models\Style;
use App\Models\Address;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $styles = Style::all();

        $query = CoffeeShop::with('address');

       
           // --- Lọc theo từ khoá (tên quán và mô tả) ---
            if ($request->has('keyword') && !empty($request->keyword)) {
                $keyword = $request->keyword;
                $query->where(function($q) use ($keyword) {
                    $q->where('shop_name', 'like', '%' . $keyword . '%')
                    ->orWhere('description', 'like', '%' . $keyword . '%');
                });
            }



        // --- Lọc theo style ---
        if ($request->has('style') && is_array($request->style)) {
            $query->whereIn('styles_id', $request->style);
        }

        // --- Lọc theo khoảng giá ---
        if ($request->has('price_range')) {
            $priceRanges = $request->input('price_range');
        
            $query->where(function($q) use ($priceRanges) {
                foreach ($priceRanges as $price) {
                    if ($price == 'lt50') {
                        $q->orWhere('min_price', '<', 50);
                    } elseif ($price == '50_70') {
                        $q->orWhere(function ($q2) {
                            $q2->where('min_price', '>=', 50)
                               ->where('max_price', '<=', 70);
                        });
                    } elseif ($price == 'gt70') {
                        $q->orWhere('max_price', '>', 70);
                    }
                }
            });
        }
        

        // --- Lọc theo khoảng cách ---
        if ($request->has('distance') && auth()->check()) {
            $user = auth()->user();
            $userAddress = $user->address; // Đảm bảo người dùng có address liên kết

            if ($userAddress && $userAddress->latitude && $userAddress->longitude) {
                $userLat = $userAddress->latitude;
                $userLng = $userAddress->longitude;

                $query->whereHas('address', function ($q) use ($request, $userLat, $userLng) {
                    $q->whereNotNull('latitude')->whereNotNull('longitude');

                    $q->where(function ($distanceQ) use ($request, $userLat, $userLng) {
                        foreach ($request->distance as $dist) {
                            $distanceQ->orWhereRaw("
                                6371 * acos(
                                    cos(radians(?)) * cos(radians(latitude)) *
                                    cos(radians(longitude) - radians(?)) +
                                    sin(radians(?)) * sin(radians(latitude))
                                ) <= ?
                            ", [$userLat, $userLng, $userLat, $dist]);
                        }
                    });
                });
            }
        }

        $coffeeShops = $query->get();

        return view('frontend.search-result', compact('coffeeShops', 'styles'));
    }
    // Hỗ trợ tìm kiếm bằng autocomlete
    
    public function autocomplete(Request $request)
    {
        $keyword = $request->get('keyword');
    
        // Kiểm tra nếu từ khóa rỗng
        if (!$keyword) {
            return response()->json([]);
        }
    
        $results = [];
    
        // Gợi ý tên quán
        $shopNames = CoffeeShop::where('shop_name', 'like', "%{$keyword}%")
            ->limit(5)
            ->pluck('shop_name')
            ->toArray();
    
        foreach ($shopNames as $name) {
            $results[] = ['type' => 'shop_name', 'label' => $name];
        }
        $keyword = $request->get('keyword');

        // Lấy danh sách description có chứa từ khóa
        $descriptions = CoffeeShop::where('description', 'like', "%{$keyword}%")
            ->limit(5)
            ->pluck('description')
            ->toArray();

        // Cắt ngắn phần mô tả chứa từ khóa
        foreach ($descriptions as $desc) {
            // Tìm vị trí từ khóa trong mô tả
            $pos = stripos($desc, $keyword);

            if ($pos !== false) {
                // Cắt ra khoảng 50 ký tự xung quanh từ khóa
                $start = max(0, $pos - 25);
                $snippet = substr($desc, $start, 80);
                // Thêm dấu "..." nếu cắt giữa câu
                if ($start > 0) $snippet = '...' . ltrim($snippet);
                if ($start + 80 < strlen($desc)) $snippet = rtrim($snippet) . '...';

                $results[] = [
                    'type' => 'description',
                    'label' => $snippet,
                ];
            }
        }


    
        // Gợi ý theo khoảng giá
        $priceSuggestions = [
            ['label' => '< 50k', 'value' => 'lt50'],
            ['label' => '50k - 70k', 'value' => '50_70'],
            ['label' => '> 70k', 'value' => 'gt70'],
        ];
        foreach ($priceSuggestions as $suggestion) {
            if (stripos($suggestion['label'], $keyword) !== false) {
                $results[] = ['type' => 'price_range', 'label' => $suggestion['label']];
            }
        }
    
        // Gợi ý style
        $styles = Style::where('style_name', 'like', "%{$keyword}%")
            ->limit(5)
            ->pluck('style_name')
            ->toArray();
    
        foreach ($styles as $style) {
            $results[] = ['type' => 'style', 'label' => $style];
        }
    
        // Gợi ý từ khóa hot
        $specialSuggestions = [
            'Quán gần đây',
            'Hot trend',
            'Được yêu thích',
            'Mở cửa bây giờ'
        ];
        foreach ($specialSuggestions as $special) {
            if (stripos($special, $keyword) !== false) {
                $results[] = ['type' => 'keyword_suggestion', 'label' => $special];
            }
        }
    
        // Loại bỏ các mục trùng lặp dựa trên 'label'
        $results = array_unique($results, SORT_REGULAR);
    
        // Giới hạn tổng số kết quả trả về
        $results = array_slice($results, 0, 10);
    
        return response()->json($results);
    }
}    
