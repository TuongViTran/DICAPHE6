<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CoffeeShop;
use App\Models\Review;
use App\Models\User;
use App\Models\Style;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoffeeShopController extends Controller
{
    // ================== Danh sách ==================
    public function index()
    {
        $coffeeShops = CoffeeShop::with(['user', 'address', 'style'])->get(); // Load thêm các mối quan hệ nếu cần
        return view('backend.admin.coffeeshops_management', [
            'coffeeShops' => $coffeeShops,
        ]);
    }

    // ================== Trang tạo mới ==================
    public function create()
    {
        $users = User::all();
        $styles = Style::all();
        $addresses = Address::all();

        return view('backend.admin.create_coffeeshop', compact('users', 'styles', 'addresses'));
    }

    // ================== Lưu quán mới ==================
    public function store(Request $request)
    {
        // 1. Xác thực yêu cầu đến
        $validated = $request->validate([
            'shop_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id',
            'styles_id' => 'required|exists:styles,id',
            'status' => 'required|in:open,closed',
            'cover_image' => 'nullable|image',
        ]);
    
        // 2. Chèn địa chỉ vào bảng địa chỉ và lấy ID
        $address = Address::create([
            'street' => $request->street,
            'ward' => $request->ward,
            'district' => $request->district,
            'city' => $request->city,
        ]);
    
        // Tạo mục nhập quán cà phê
        $coffeeshop = new CoffeeShop([
            'shop_name' => $request->shop_name,
            'phone' => $request->phone,
            'user_id' => $request->user_id,
            'address_id' => $address->id, 
            'styles_id' => $request->styles_id,
            'status' => $request->status,
        ]);
    
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('frontend/images'), $imageName); // ✅ Lưu vào public/frontend/images
            $coffeeshop->cover_image = $imageName;
        }
        
    
        $coffeeshop->save();
    
        return redirect()->route('coffeeshops_management')->with('success', 'Thêm quán cà phê thành công!');
    }
    
    public function update(Request $request, CoffeeShop $coffeeshop)
    {
        $request->validate([
            'shop_name'           => 'required|string|max:255',
            'phone'               => 'nullable|string|max:15',
            'description'         => 'nullable|string',
            'status'              => 'required|in:open,closed',
            'cover_image'         => 'nullable|image|max:2048',
            'reviews_avg_rating'  => 'nullable|numeric|min:0|max:5',
        ]);
    
        $coffeeshop->fill($request->only([
            'shop_name', 'phone', 'description', 'status', 'reviews_avg_rating'
        ]));
    
     
        if ($request->hasFile('cover_image')) {
            
            if ($coffeeshop->cover_image && Storage::disk('public')->exists('frontend/images/' . $coffeeshop->cover_image)) {
                Storage::disk('public')->delete('frontend/images/' . $coffeeshop->cover_image);
            }
    
          
            $image = $request->file('cover_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('frontend/images', $imageName, 'public');
            $coffeeshop->cover_image = $imageName;
        }
    
      
        $coffeeshop->save();
    
        return redirect()->route('coffeeshops_management')->with('success', 'Quán cà phê đã được cập nhật thành công.');
    }
    
    // ================== Xoá ==================
    public function destroy(CoffeeShop $coffeeshop)
    {
        if ($coffeeshop->cover_image) {
            $imagePath = public_path('frontend/images/' . $coffeeshop->cover_image); // Đảm bảo đường dẫn đúng
            if (file_exists($imagePath)) {
                unlink($imagePath); // Xóa ảnh cũ nếu tồn tại
            }
        }
        
      
        $coffeeshop->delete();

        return redirect()->route('coffeeshops_management')->with('success', 'Quán cà phê đã được xóa thành công.');
    }

    // ================== Hiển thị chi tiết ==================
    

    // ================== Like / Unlike ==================
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

    // ================== Đánh giá ==================
    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'content'  => 'required|string|max:500',
            'rating'   => 'required|integer|min:1|max:5',
            'img_url'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imgPath = null;

        if ($request->hasFile('img_url')) {
            $imgPath = $request->file('img_url')->store('reviews', 'public');
        }

        Review::create([
            'user_id'     => auth()->id(),
            'shop_id'     => $id,
            'content'     => $request->content,
            'rating'      => $request->rating,
            'img_url'     => $imgPath,
            'likes_count' => 0,
        ]);

        return redirect()->back()->with('success', 'Đánh giá của bạn đã được gửi.');
    }

    // ================== Chỉnh sửa quán ==================
    public function edit(CoffeeShop $coffeeshop)
    {
        // Lấy danh sách người dùng để chọn người quản lý
        $users = User::all(); // Lấy tất cả người dùng
        return view('backend.admin.edit_coffeeshop', compact('coffeeshop', 'users')); // Truyền cả $coffeeshop và $users đến view
    }

    // ================== Chỉnh sửa đánh giá ==================
    public function editReview($id)
    {
        $review = Review::findOrFail($id);
        return view('reviews.edit', compact('review'));
    }
}
