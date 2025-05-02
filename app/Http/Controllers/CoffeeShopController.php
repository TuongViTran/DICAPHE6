<?php

namespace App\Http\Controllers;

use App\Models\CoffeeShop;
use App\Models\Review;
use App\Models\User;
use App\Models\Style;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoffeeShopController extends Controller
{
    // =============== Danh sách ===============
    public function index()
    {
        $coffeeShops = CoffeeShop::with(['user', 'address', 'style'])->get();
        return view('backend.admin.coffeeshops_management', compact('coffeeShops'));
    }

    // =============== Trang tạo mới ===============
    public function create()
    {
        $users = User::all();
        $styles = Style::all();
        $addresses = Address::all();
        return view('backend.admin.create_coffeeshop', compact('users', 'styles', 'addresses'));
    }

    // =============== Lưu quán mới ===============
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shop_name'     => 'required|string|max:255',
            'phone'         => 'nullable|string|max:15',
            'user_id'       => 'required|exists:users,id',
            'styles_id' => 'required|exists:styles,id',
            'status'        => 'required|in:Đang mở cửa,Đã đóng cửa',
            'opening_time'  => 'nullable|date_format:H:i',
            'closing_time'  => 'nullable|date_format:H:i',
            'min_price'     => 'nullable|numeric|min:0',
            'max_price'     => 'nullable|numeric|min:0',
            'description'   => 'nullable|string',
            'street'        => 'nullable|string',
            'ward'          => 'required|string',
            'district'      => 'required|string',
            'city'          => 'required|string',
            'wifi_password' => 'nullable|string',
            'hotline'       => 'nullable|string',
            'parking'       => 'nullable|string',
            'cover_image'   => 'nullable|image',
            'image_1'       => 'nullable|image',
            'image_2'       => 'nullable|image',
            'image_3'       => 'nullable|image',
        ]);

        try {
            // Tạo địa chỉ trước
            $address = new Address([
                'street'   => $validated['street'],
                'ward'     => $validated['ward'],
                'district' => $validated['district'],
                'city'     => $validated['city'],
            ]);
            $address->save();

            // Tạo CoffeeShop và gán address_id
            $coffeeshop = new CoffeeShop($validated);
            $coffeeshop->styles_id = $validated['styles_id'];
            $coffeeshop->address_id = $address->id;

            // Lưu ảnh và gán tên ảnh vào model
            foreach (['cover_image', 'image_1', 'image_2', 'image_3'] as $img) {
                if ($request->hasFile($img)) {
                    $imageName = time() . '_' . $request->file($img)->getClientOriginalName();
                    $request->file($img)->move(public_path('frontend/images'), $imageName);
                    $coffeeshop->$img = $imageName;
                }
            }

            $coffeeshop->save();

            return redirect()->route('coffeeshops_management')->with('success', 'Quán cà phê đã được thêm thành công.');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi: ' . $e->getMessage());
        }
    }

    // =============== Trang chỉnh sửa ===============
    public function edit(CoffeeShop $coffeeshop)
    {
        $users = User::all();
        $styles = Style::all();
        return view('backend.admin.edit_coffeeshop', compact('coffeeshop', 'users', 'styles'));
    }

    // =============== Cập nhật quán ===============
    public function update(Request $request, CoffeeShop $coffeeshop)
    {
        $validated = $request->validate([
            'shop_name'     => 'required|string|max:255',
            'phone'         => 'nullable|string|max:20',
            'user_id'       => 'required|exists:users,id',
            'styles_id'     => 'required|exists:styles,id',
            'status'        => 'required|in:Đang mở cửa,Đã đóng cửa',
            'cover_image'   => 'nullable|image|max:2048',
            'street'        => 'required|string|max:255',
            'ward'          => 'required|string|max:255',
            'district'      => 'required|string|max:100',
            'city'          => 'required|string|max:100',
        ]);

        // Nếu có ảnh bìa mới
        if ($request->hasFile('cover_image')) {
            // Xóa ảnh cũ nếu có
            if ($coffeeshop->cover_image && file_exists(public_path('frontend/images/' . $coffeeshop->cover_image))) {
                unlink(public_path('frontend/images/' . $coffeeshop->cover_image));
            }
            // Lưu ảnh mới và cập nhật tên ảnh
            $imageName = time() . '_' . $request->file('cover_image')->getClientOriginalName();
            $request->file('cover_image')->move(public_path('frontend/images'), $imageName);
            $coffeeshop->cover_image = $imageName;
        }

        $coffeeshop->update([
            'shop_name' => $validated['shop_name'],
            'phone'     => $validated['phone'],
            'user_id'   => $validated['user_id'],
            'styles_id' => $validated['styles_id'],
            'status'    => $validated['status'],
        ]);

        // Cập nhật địa chỉ
        $coffeeshop->address()->updateOrCreate([], [
            'street'   => $validated['street'],
            'ward'     => $validated['ward'],
            'district' => $validated['district'],
            'city'     => $validated['city'],
        ]);

        return redirect()->route('coffeeshops_management')->with('success', 'Cập nhật quán cà phê thành công!');
    }

    // =============== Xóa quán ===============
    public function destroy(CoffeeShop $coffeeshop)
    {
        // Xóa ảnh liên quan
        foreach (['cover_image', 'image_1', 'image_2', 'image_3'] as $imgField) {
            if ($coffeeshop->$imgField && file_exists(public_path('frontend/images/' . $coffeeshop->$imgField))) {
                unlink(public_path('frontend/images/' . $coffeeshop->$imgField));
            }
        }

        $coffeeshop->delete();

        return redirect()->route('coffeeshops_management')->with('success', 'Đã xóa quán cà phê.');
    }

    // =============== Chi tiết ===============
    public function show($id)
    {
        $coffeeShop = CoffeeShop::with('reviews.user')->findOrFail($id);
        $reviews = Review::where('shop_id', $id)->with('user')->orderBy('created_at', 'desc')->get();
        return view('owner.index', compact('coffeeShop', 'reviews'));
    }

    // =============== Like / Unlike ===============
    public function like($id)
    {
        $shop = CoffeeShop::findOrFail($id);
        $user = auth()->user();

        $liked = false;

        if ($shop->likes()->where('user_id', $user->id)->exists()) {
            $shop->likes()->where('user_id', $user->id)->delete();
        } else {
            $shop->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likes' => $shop->likes()->count(),
        ]);
    }

    // =============== Gửi đánh giá ===============
    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string|max:500',
            'rating' => 'required|integer|min:1|max:5',
            'img_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imgPath = $request->hasFile('img_url')
            ? $request->file('img_url')->store('reviews', 'public')
            : null;

        Review::create([
            'user_id'    => auth()->id(),
            'shop_id'    => $id,
            'content'    => $request->content,
            'rating'     => $request->rating,
            'img_url'    => $imgPath,
            'likes_count'=> 0,
        ]);

        return redirect()->back()->with('success', 'Đánh giá của bạn đã được gửi.');
    }

    // =============== Chỉnh sửa đánh giá ===============
    public function editReview($id)
    {
        $review = Review::findOrFail($id);
        return view('reviews.edit', compact('review'));
    }
}
