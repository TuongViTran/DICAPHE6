<?php

namespace App\Http\Controllers;

use App\Models\CoffeeShop;
use App\Models\Review; // Đảm bảo bạn đã import model Review
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User; // Thêm dòng này
use App\Models\Address; // Đảm bảo bạn đã import model Address
use App\Models\Style; // Đảm bảo bạn đã import model Style
use App\Models\SocialNetwork; // Đảm 

class CoffeeShopController extends Controller
{
    public function like($id)
    {
        $shop = CoffeeShop::findOrFail($id);
        $user = auth()->user();
    
        if ($shop->likes()->where('user_id', $user->id)->exists()) {
            $shop->likes()->where('user_id', $user->id)->delete();
            $liked = false;
        } else {
            $shop->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }
    
        return response()->json([
            'liked' => $liked,
            'likes' => $shop->likes()->count(),
        ]);
    }

    public function index()
    {
        // Lấy tất cả quán cà phê cùng với thông tin người quản lý và địa chỉ
        $coffeeShops = CoffeeShop::with('user', 'address')->get();
        
        // Trả về view với biến $coffeeShops
        return view('backend.admin.coffeeshops_management', compact('coffeeShops'));
    }

        public function create()
        {
            // Lấy danh sách địa chỉ từ cơ sở dữ liệu
            $addresses = Address::all(); // Lấy tất cả địa chỉ
            $styles = Style::all(); // Lấy tất cả phong cách
            $socialNetworks = SocialNetwork::all(); // Lấy tất cả mạng xã hội
    
            // Trả về view với các biến cần thiết
            return view('backend.admin.create_coffeeshop', compact('addresses', 'styles', 'socialNetworks'));
        }

   

    public function edit(CoffeeShop $coffeeshop)
    {
        // Lấy danh sách người dùng để chọn người quản lý
        $users = User::all(); // Lấy tất cả người dùng
        return view('backend.admin.edit_coffeeshop', compact('coffeeshop', 'users')); // Truyền cả $coffeeshop và $users đến view
    }

    public function update(Request $request, CoffeeShop $coffeeshop)
    {
        // Xác thực dữ liệu
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'description' => 'nullable|string',
            'status' => 'required|in:open,closed',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        // Cập nhật thông tin quán cà phê
        $coffeeshop->update($request->only(['shop_name', 'phone', 'description', 'status']));

        // Lưu ảnh nếu có
        if ($request->hasFile('cover_image')) {
            // Xóa ảnh cũ nếu có
            if ($coffeeshop->cover_image) {
                Storage::disk('public')->delete($coffeeshop->cover_image);
            }
            $coffeeshop->cover_image = $request->file('cover_image')->store('coffeeshops', 'public');
        }

               // Lưu quán cà phê
               $coffeeshop->save();

               // Chuyển hướng về trang quản lý quán cà phê với thông báo thành công
               return redirect()->route('coffeeshops_management')->with('success', 'Quán cà phê đã được cập nhật thành công.');
           }
       
           public function destroy(CoffeeShop $coffeeshop)
           {
               // Xóa quán cà phê
               // Xóa ảnh nếu có
               if ($coffeeshop->cover_image) {
                   Storage::disk('public')->delete($coffeeshop->cover_image);
               }
       
               $coffeeshop->delete();
               return redirect()->route('coffeeshops_management')->with('success', 'Quán cà phê đã được xóa thành công.');
           }
       
           public function show($id)
           {
               // Lấy quán cà phê cùng với các đánh giá của nó
               $coffeeShop = CoffeeShop::with('reviews.user')->findOrFail($id);
               $reviews = Review::where('shop_id', $id)
                   ->with('user') // Nếu có mối quan hệ với bảng users
                   ->orderBy('created_at', 'desc')
                   ->get();
       
               return view('owner.index', compact('coffeeShop', 'reviews'));
           }
       
           public function storeReview(Request $request, $id)
           {
               // Xác thực dữ liệu đầu vào
               $request->validate([
                   'content' => 'required|string|max:500',
                   'rating' => 'required|integer|min:1|max:5',
                   'img_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
               ]);
       
               // Lưu ảnh nếu có
               $imgPath = null;
               if ($request->hasFile('img_url')) {
                   $imgPath = $request->file('img_url')->store('reviews', 'public');
               }
       
               // Thêm đánh giá vào database
               Review::create([
                   'user_id' => auth()->id(), // Lấy ID người dùng đăng nhập
                   'shop_id' => $id,
                   'content' => $request->content,
                   'rating' => $request->rating,
                   'img_url' => $imgPath,
                   'likes_count' => 0,
               ]);
       
               return redirect()->back()->with('success', 'Đánh giá của bạn đã được gửi.');
           }
       }