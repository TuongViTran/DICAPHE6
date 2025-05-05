<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Style;
use Illuminate\Support\Facades\DB;
use App\Models\CoffeeShop;
use App\Models\RecentSearch;



class SearchController extends Controller
{
    public function search(Request $request)
    {
        $styles = Style::all();
    
        $latitude = $request->input('user_latitude', 16.052597851703318);
        $longitude = $request->input('user_longitude', 108.16862472923815);
        
        if ((!$latitude || !$longitude) && auth()->check() && auth()->user()->address) {
            $latitude = auth()->user()->address->latitude ?? 16.052597851703318;
            $longitude = auth()->user()->address->longitude ?? 108.16862472923815;
        }
    
        $latitude = $latitude ?: 16.052597851703318;
        $longitude = $longitude ?: 108.16862472923815;

        // Công thức có alias -> dùng cho SELECT
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

            // Công thức không có alias -> dùng trong WHERE
            $distanceOnlyFormula = "
            111.045 * DEGREES(
                ACOS(
                    LEAST(1.0, 
                        COS(RADIANS(?)) * COS(RADIANS(addresses.latitude)) 
                        * COS(RADIANS(addresses.longitude) - RADIANS(?)) 
                        + SIN(RADIANS(?)) 
                        * SIN(RADIANS(addresses.latitude))
                    )
                )
            )
            ";


        $query = DB::table('coffeeshop')
        ->join('addresses', 'coffeeshop.address_id', '=', 'addresses.id')
        ->leftJoin('styles', 'coffeeshop.styles_id', '=', 'styles.id')
        ->leftJoin('users', 'coffeeshop.user_id', '=', 'users.id') // 👈 Thêm dòng này
        ->select(
            'coffeeshop.*',
            'addresses.street as address_street',
            'addresses.ward as address_ward',
            'addresses.district as address_district',
            'addresses.city as address_city',
            'styles.style_name as style_name',
            'styles.id as styles_id',
            'users.avatar_url as user_avatar_url',  // 👈 Lấy avatar
            'users.full_name as user_full_name',    // 👈 Lấy tên
            DB::raw($distanceFormula)
    )

        ->addBinding($latitude, 'select')
        ->addBinding($longitude, 'select')
        ->addBinding($latitude, 'select');
    
        // --- Lọc theo từ khoá ---
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('coffeeshop.shop_name', 'like', "%$keyword%")
                  ->orWhere('coffeeshop.description', 'like', "%$keyword%");
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
        $distanceRanges = $request->input('distance', []);
        if (!empty($distanceRanges) && is_array($distanceRanges)) {
            $query->where(function ($q) use ($distanceRanges, $latitude, $longitude, $distanceOnlyFormula) {
                foreach ($distanceRanges as $range) {
                    if (is_numeric($range)) {
                        $q->orWhereRaw("($distanceOnlyFormula) <= ?", [
                            $latitude, $longitude, $latitude, $range
                        ]);
                    }
                }
            });
        }


        $coffeeShops = $query->get();

        foreach ($coffeeShops as $shop) {
            if (isset($shop->distance)) {
                $shop->distance = round($shop->distance, 2);
            }
        }
        // ✅ Thêm tại đây:
        RecentSearch::create([
            'user_id'      => auth()->check() ? auth()->id() : null,
            'keyword'      => $request->keyword,
            'style_id'     => is_array($request->style) ? ($request->style[0] ?? null) : $request->style,
            'min_price'    => null,
            'max_price'    => null,
            'latitude'     => $latitude,
            'longitude'    => $longitude,
            'distance' => (is_array($distanceRanges) && count($distanceRanges) > 0) ? max($distanceRanges) : null,
            'result_count' => $coffeeShops->count(),
        ]);

        return view('frontend.search-result', compact('coffeeShops', 'styles',));
    }


    public function autocomplete(Request $request)
{
    $keyword = $request->get('keyword');

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

    // Gợi ý theo mô tả
    $descriptions = CoffeeShop::where('description', 'like', "%{$keyword}%")
        ->limit(5)
        ->pluck('description')
        ->toArray();

    foreach ($descriptions as $desc) {
        $pos = stripos($desc, $keyword);
        if ($pos !== false) {
            $start = max(0, $pos - 25);
            $snippet = substr($desc, $start, 80);

            if ($start > 0) {
                $snippet = '...' . ltrim($snippet);
            }
            if ($start + 80 < strlen($desc)) {
                $snippet = rtrim($snippet) . '...';
            }

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

    // Gợi ý theo style
    $styles = Style::where('style_name', 'like', "%{$keyword}%")
        ->limit(5)
        ->pluck('style_name')
        ->toArray();

    foreach ($styles as $style) {
        $results[] = ['type' => 'style', 'label' => $style];
    }

    // Gợi ý từ khóa đặc biệt
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

    // Xoá trùng theo label
    $results = collect($results)->unique('label')->values()->take(10);

    return response()->json($results);
}

    
}    
