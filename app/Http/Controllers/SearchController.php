<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Style;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $styles = Style::all();
    
        $latitude = $request->input('user_latitude', 16.4724736);
        $longitude = $request->input('user_longitude', 107.56096);
        
        if ((!$latitude || !$longitude) && auth()->check() && auth()->user()->address) {
            $latitude = auth()->user()->address->latitude ?? 16.4724736;
            $longitude = auth()->user()->address->longitude ?? 107.56096;
        }
    
        $latitude = $latitude ?: 16.4724736;
        $longitude = $longitude ?: 107.56096;

        // Công thức tính khoảng cách
        $distanceFormula = "
            111.045 * DEGREES(
                ACOS(
                    LEAST(1.0, 
                        COS(RADIANS(?)) * COS(RADIANS(addresses.latitude)) 
                        * COS(RADIANS(addresses.longitude) - RADIANS(?)) 
                        + SIN(RADIANS(?)) 
                        * SIN(RADIANS(addresses.latitude))
                    )
                )
            ) AS distance
        ";

        $query = DB::table('coffeeshop')
            ->join('addresses', 'coffeeshop.address_id', '=', 'addresses.id')
            ->leftJoin('styles', 'coffeeshop.styles_id', '=', 'styles.id')
            ->select(
                'coffeeshop.*',
                'addresses.*',
                'styles.style_name as style_name',
                'styles.id as styles_id',
                DB::raw($distanceFormula)
            )
            // Ràng buộc các tham số vào câu truy vấn
            ->addBinding($latitude, 'select')
            ->addBinding($longitude, 'select')
            ->addBinding($latitude, 'select');

        // --- Lọc theo từ khoá ---
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
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
            $query->where(function ($q) use ($priceRanges) {
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
        $distanceSelected = $request->input('distance');
        if ($distanceSelected && is_numeric($distanceSelected)) {
            $query->whereRaw("$distanceFormula <= ?", [$latitude, $longitude, $latitude, $distanceSelected]);
        }

        $coffeeShops = $query->get();

        foreach ($coffeeShops as $shop) {
            if (isset($shop->distance)) {
                $shop->distance = round($shop->distance, 2);
            }
        }

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
