<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Menu;
use App\Models\CoffeeShop;
use Illuminate\Support\Facades\Storage;
use App\Models\Address;
use App\Models\Shop;
use App\Models\Post;
use App\Models\Review;
use Illuminate\Support\Facades\Validator;

class OwnerController extends Controller
{  public function owner($id)
    {
        $user = auth()->user();
         // Nếu không phải chủ quán hoặc ID không khớp, từ chối truy cập
        if (!$user || $user->role !== 'owner' || $user->id != $id) {
            abort(403, 'Không có quyền truy cập.');
        }
        // Lấy coffeeShop của chủ quán có ID = $id
        $coffeeShop = CoffeeShop::where('user_id', $id)->first();
        // Kiểm tra nếu chủ quán chưa đăng ký quán
        if (!$coffeeShop) {
            return redirect()->route('register.shop')
                ->with('warning', 'Bạn chưa đăng ký quán. Vui lòng hoàn tất thông tin quán để tiếp tục.');
        }

        $posts = Post::with('user') // Lấy bài viết cùng user tạo bài viết đó
            // ->where('status', 'Published')
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        $userId = auth()->id();
        $postCount = Post::where('user_id', $userId)->count(); // Tổng số bài viết của chủ quán
        $reviewCount = $coffeeShop->reviews()->count();  //Tổng lượt đánh giá của shop
        
        // Lấy danh sách đánh giá theo shop_id
        $reviews = Review::with('user')
        ->where('shop_id', $coffeeShop->id)
        ->latest()
        ->get();
    
          // Lấy các quán đã lưu của user
        //   $user = auth()->user();
          $savedShops = [];
          
          if ($user) {
              $savedShops = $user->favoriteShops()->with('address')->get();
          }

          $saveCount = \DB::table('favoriteshop')
          ->where('shop_id', $coffeeShop->id)
          ->count();
      

          return view('frontend.owner', compact('coffeeShop', 'posts', 'reviews', 'postCount', 'reviewCount', 'savedShops', 'saveCount', 'user'));
    }
    
    // Cập nhật menu
    public function update(Request $request, $id)
    {
        $request->validate([
            'menu_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Kiểm tra file hợp lệ
        ]);

        $menu = Menu::findOrFail($id);

        if ($request->hasFile('menu_image')) {
            // Xóa ảnh cũ nếu có
            if ($menu->image_url && file_exists(public_path('frontend/images/' . $menu->image_url))) {
                unlink(public_path('frontend/images/' . $menu->image_url));
            }

            // Lưu ảnh mới vào thư mục public/frontend/images/
            $file = $request->file('menu_image');
            $filename = time() . '_' . $file->getClientOriginalName(); //tạo tên ảnh bằng thời gian hiện tại với tên gốc để không bị trùng
            $file->move(public_path('frontend/images/'), $filename);

            // Cập nhật đường dẫn ảnh trong DB
            $menu->image_url = $filename;
            $menu->save();
        }

        return redirect()->back()->with('success', 'Cập nhật menu thành công!');
    }

        public function infor($id)
        {
            // Lấy danh sách quán của chủ sở hữu
            $coffeeShop = Coffeeshop::where('user_id', $id)
            ->with( 'address') 
            ->first();
        
            // Kiểm tra nếu không có quán nào
            if (!$coffeeShop) {
                return abort(404, "Không tìm thấy quán cà phê của chủ sở hữu này.");
            }
        
            return view('frontend.owner', compact('coffeeShop'));
        }


        public function updateinfor(Request $request, $id)
        {
            // Validate dữ liệu
            $validator = Validator::make($request->all(), [
                'shop_name' => 'required|string|max:255',
                'status' => 'required|string',
                'phone' => 'required|regex:/^\d{1,11}$/',
                'description' => 'required|string',
                'opening_time' => ['required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'], 
                'closing_time' => ['required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'],
                'min_price' => 'required|numeric|min:0',
                'max_price' => 'required|numeric|min:0|gt:min_price',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'address' => 'required|string|max:255',
            ], [
                'shop_name.required' => 'Vui lòng nhập tên quán.',
                'shop_name.max' => 'Tên quán không được vượt quá 255 ký tự.',
        
                'status.required' => 'Vui lòng chọn trạng thái.',
        
                'phone.required' => 'Vui lòng nhập số điện thoại.',
                'phone.regex' => 'Số điện thoại không hợp lệ.',
        
                'description.required' => 'Vui lòng nhập mô tả.',
        
                'opening_time.required' => 'Vui lòng nhập giờ mở cửa.',
                'opening_time.regex' => 'Định dạng giờ mở cửa không hợp lệ (hh:mm).',
        
                'closing_time.required' => 'Vui lòng nhập giờ đóng cửa.',
                'closing_time.regex' => 'Định dạng giờ đóng cửa không hợp lệ (hh:mm).',
        
                'min_price.required' => 'Vui lòng nhập giá nhỏ nhất.',
                'min_price.numeric' => 'Giá nhỏ nhất phải là số.',
                'min_price.min' => 'Giá nhỏ nhất phải lớn hơn hoặc bằng 0.',
        
                'max_price.required' => 'Vui lòng nhập giá lớn nhất.',
                'max_price.numeric' => 'Giá lớn nhất phải là số.',
                'max_price.min' => 'Giá lớn nhất phải lớn hơn hoặc bằng 0.',
                'max_price.gt' => 'Giá lớn nhất phải lớn hơn giá nhỏ nhất.',
        
                'cover_image.image' => 'Tệp phải là ảnh.',
                'cover_image.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg hoặc gif.',
                'cover_image.max' => 'Ảnh không được vượt quá 2MB.',
        
                'image_1.image' => 'Tệp phải là ảnh.',
                'image_1.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg hoặc gif.',
                'image_1.max' => 'Ảnh không được vượt quá 2MB.',
        

                'image_2.image' => 'Tệp phải là ảnh.',
                'image_2.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg hoặc gif.',
                'image_2.max' => 'Ảnh không được vượt quá 2MB.',
        
                'image_3.image' => 'Tệp phải là ảnh.',
                'image_3.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg hoặc gif.',
                'image_3.max' => 'Ảnh không được vượt quá 2MB.',
        
                'address.required' => 'Vui lòng nhập địa chỉ.',
                'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            ]);

            // kiểm tra lỗi validate
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('openEditModal', true); // FLAG để mở đúng modal
            }

            $coffeeShop = CoffeeShop::with('user')->find($id);

            // Tìm quán cà phê cần cập nhật
            $coffeeShop = CoffeeShop::findOrFail($id);
    
            // Cập nhật thông tin quán
            $coffeeShop->shop_name = $request->shop_name;
            $coffeeShop->status = $request->status;
            $coffeeShop->phone = $request->phone;
            $coffeeShop->description = $request->description;
            $coffeeShop->opening_time = $request->opening_time;
            $coffeeShop->closing_time = $request->closing_time;
            $coffeeShop->min_price = $request->min_price;
            $coffeeShop->max_price = $request->max_price;
    
            // Xử lý hình ảnh
            foreach (['cover_image', 'image_1', 'image_2', 'image_3'] as $img) {
                if ($request->hasFile($img)) {
                    $filename = time() . '_' . $request->file($img)->getClientOriginalName();
                    $request->file($img)->move(public_path('frontend/images'), $filename);
                    $coffeeShop->update([$img => $filename]);
                }
            }

            $coffeeShop->save();
    
            // Cập nhật địa chỉ
            $addressParts = explode(',', $request->address);
            $street = trim($addressParts[0] ?? '');
            $district = trim($addressParts[1] ?? '');
            $city = trim($addressParts[2] ?? '');
            $country = trim($addressParts[3] ?? '');
    
            Address::updateOrCreate(
                ['id' => $coffeeShop->address_id],
                [
                    'street' => $street,
                    'district' => $district,
                    'city' => $city,
                    'country' => $country,
                ]
            );
    
            return redirect()->back()->with('success', 'Cập nhật thông tin quán thành công!');
        }

}


    

