<?php

namespace App\Http\Controllers;

use App\Models\CoffeeShop;
use App\Models\Review;
use App\Models\User;
use App\Models\Style;
use App\Models\Address;
use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
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

    public function destroy(CoffeeShop $coffeeshop)
    {
        // Xóa các bản ghi liên quan trong bảng favoriteshop
        \DB::table('favoriteshop')->where('shop_id', $coffeeshop->id)->delete();
        
        // Xóa các bản ghi liên quan trong bảng review
        \DB::table('review')->where('shop_id', $coffeeshop->id)->delete();
        
        // Xóa ảnh
        foreach (['cover_image', 'image_1', 'image_2', 'image_3'] as $imgField) {
            if ($coffeeshop->$imgField && file_exists(public_path('frontend/images/' . $coffeeshop->$imgField))) {
                unlink(public_path('frontend/images/' . $coffeeshop->$imgField));
            }
        }
    
        // Xóa quán cà phê
        $coffeeshop->delete();
    
        // Cập nhật lại danh sách quán
        $shops = CoffeeShop::with('reviews')->get();
    
        // Trả về trang quản lý quán cà phê với thông báo thành công
        return redirect()->route('coffeeshops_management', compact('shops'))->with('success', 'Đã xóa quán cà phê và dữ liệu liên quan.');
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


    // ================== Hiển thị form đăng ký quán ==================
    public function createCoffeeshop()
    {
        return view('frontend.dangkycoffeeshop', [
            'addresses' => \App\Models\Address::all(),
            'styles' => \App\Models\Style::all(),
        ]); 
    }

    // ================== Lưu quán mới ==================
    public function storeCoffeeshop(Request $request)
    {
        
        $user = Auth::user();
        // Kiểm tra đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để đăng ký quán.');
        }

        // Validate dữ liệu từ form
        $validated = $request->validate([
            'shop_name' => 'required|string|max:255',
            'phone' => 'required|regex:/^\d{1,11}$/',
            'description' => 'required|string',
            // 'address_id' => 'required|exists:addresses,id',
            'styles_id' => 'required|exists:styles,id',
            'opening_time' => 'required|date_format:H:i',
            'closing_time' => 'required|date_format:H:i',
            'parking' => 'required|string|max:255',
            'wifi_password' => 'required|string|min:8|max:255',
            'hotline' => 'required|regex:/^\d{1,11}$/',
            'min_price' => 'required|numeric|min:0',
            'max_price' => 'required|numeric|min:0|gt:min_price',
            'images' => 'required|array|size:4', // Bắt buộc phải có 4 ảnh
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'menu_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'street' => 'required|string|max:255',
            'ward' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            
        ], [
            'shop_name.required' => 'Tên quán là bắt buộc.',
            'shop_name.max' => 'Tên quán không được vượt quá 255 ký tự.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'description.required' => 'Mô tả là bắt buộc.',
            // 'address_id.required' => 'Địa chỉ là bắt buộc.',
            // 'address_id.exists' => 'Địa chỉ không tồn tại.',
            'styles_id.required' => 'Phong cách là bắt buộc.',
            'styles_id.exists' => 'Phong cách không tồn tại.',
            'opening_time.required' => 'Giờ mở cửa là bắt buộc.',
            'opening_time.date_format' => 'Giờ mở cửa không đúng định dạng (HH:mm).',
            'closing_time.required' => 'Giờ đóng cửa là bắt buộc.',
            'closing_time.date_format' => 'Giờ đóng cửa không đúng định dạng (HH:mm).',
            'parking.required' => 'Thông tin bãi đỗ xe là bắt buộc.',
            'wifi_password.required' => 'Mật khẩu wifi là bắt buộc.',
            'wifi_password.min' => 'Mật khẩu wifi phải có ít nhất 8 ký tự.',
            'hotline.required' => 'Hotline là bắt buộc.',
            'hotline.regex' => 'Hotline không hợp lệ.',
            'min_price.required' => 'Giá thấp nhất là bắt buộc.',
            'min_price.numeric' => 'Giá thấp nhất phải là số.',
            'max_price.required' => 'Giá cao nhất là bắt buộc.',
            'max_price.numeric' => 'Giá cao nhất phải là số.',
            'max_price.gt' => 'Giá tối đa phải lớn hơn giá tối thiểu.',
            'images.required' => 'Vui lòng tải lên 4 ảnh.',
            'images.size' => 'Phải chọn đúng 4 ảnh.',
            'images.*.image' => 'Tệp tải lên phải là hình ảnh.',
            'images.*.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg.',
            'images.*.max' => 'Ảnh không được vượt quá 2MB.',
            'menu_image.required' => 'Vui lòng chọn ảnh thực đơn.',
            'menu_image.image' => 'Tệp tải lên phải là hình ảnh.',
            'menu_image.mimes' => 'Ảnh thực đơn phải có định dạng jpeg, png hoặc jpg.',
            'menu_image.max' => 'Ảnh thực đơn không được vượt quá 2MB.',

            'street.required' => 'Đường là trường bắt buộc.',
            'street.string' => 'Đường phải là chuỗi ký tự.',
            'street.max' => 'Đường không được vượt quá 255 ký tự.',
            
            'ward.required' => 'Phường là trường bắt buộc.',
            'ward.string' => 'Phường phải là chuỗi ký tự.',
            'ward.max' => 'Phường không được vượt quá 100 ký tự.',
            
            'district.required' => 'Quận là trường bắt buộc.',
            'district.string' => 'Quận phải là chuỗi ký tự.',
            'district.max' => 'Quận không được vượt quá 100 ký tự.',
            
            'city.required' => 'Thành phố là trường bắt buộc.',
            'city.string' => 'Thành phố phải là chuỗi ký tự.',
            'city.max' => 'Thành phố không được vượt quá 100 ký tự.',
            
            'country.required' => 'Quốc gia là trường bắt buộc.',
            'country.string' => 'Quốc gia phải là chuỗi ký tự.',
            'country.max' => 'Quốc gia không được vượt quá 100 ký tự.',
            
            'postal_code.max' => 'Mã bưu điện không được vượt quá 20 ký tự.',
            
        ]);

        // Xử lý ảnh (tối đa 4 ảnh)
        $imageNames = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imageName = time() . "_{$index}_" . $image->getClientOriginalName();
                $image->move(public_path('frontend/images'), $imageName); // lưu vật lý
                $imageNames[] = $imageName; // chỉ lưu tên
            }
        }

        

        // Tạo địa chỉ mới
        $address = Address::create([
            'street' => $request->street,
            'ward' => $request->ward,
            'district' => $request->district,
            'city' => $request->city,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
        $address_id = $address->id;

        // Tạo bản ghi mới
        $coffeeShop = CoffeeShop::create([
            'shop_name' => $validated['shop_name'],
            'phone' => $validated['phone'] ?? null,
            'description' => $validated['description'] ?? null,
            'address_id' => $address_id,
            'styles_id' => $validated['styles_id'],
            'user_id' => Auth::id(),
            'opening_time' => $validated['opening_time'] ?? null,
            'closing_time' => $validated['closing_time'] ?? null,
            'parking' => $validated['parking'] ?? null,
            'wifi_password' => $validated['wifi_password'] ?? null,
            'hotline' => $validated['hotline'] ?? null,
            'min_price' => $validated['min_price'] ?? null,
            'max_price' => $validated['max_price'] ?? null,
            'cover_image' => $imageNames[0],
            'image_1' => $imageNames[1],
            'image_2' => $imageNames[2],
            'image_3' => $imageNames[3],
        ]); 

        // xử lí ảnh menu
        if ($request->hasFile('menu_image')) {
            $menuImage = $request->file('menu_image');
            $menuImageName = time() . '_' . $menuImage->getClientOriginalName();
            $menuImage->move(public_path('frontend/images'), $menuImageName);
        
            // Lưu đường dẫn vào DB
            Menu::create([
                'shop_id' => $coffeeShop->id,
                'image_url' => $menuImageName,
                'item_name' => 'Menu quán',
                'price' => 30000,
            ]);
        }

        return redirect()->route('owner', ['id' => $user->id])->with('success', 'Đăng ký quán thành công!');
    }

}
